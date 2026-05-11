<?php

namespace App\Http\Controllers;

use App\Jobs\GeneratePayrollExportJob;
use App\Models\PayrollExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    //

    public function SalaryManual(Request $request)
    {
        $data = [
            'title' => 'Employee',
        ];
        return view('payroll.salary_manual', $data);
    }

    public function SalaryImport(Request $request)
    {
        $salaryData = $request->salary_data;
        DB::beginTransaction();
        try {
            // ambil employee_id dari employee_code
            $employee_id = DB::table('vw_employee')
                ->where('employee_code', $salaryData['employee_code'])
                ->value('employee_id');
            if (!$employee_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee not found'
                ], 404);
            }
            $period_id = $request->period_id; // ambil dari request / session / active period
            foreach ($salaryData as $key => $value) {
                // hanya ambil kolom allowance_
                if (strpos($key, 'allowance_') === 0) {
                    // ambil angka setelah allowance_
                    $allowance_id = str_replace('allowance_', '', $key);
                    // skip jika kosong / 0
                    if (!$value || $value <= 0) {
                        continue;
                    }
                    DB::table('payroll_employee_manual')->updateOrInsert(
                        [
                            'period_id'    => $period_id,
                            'employee_id'  => $employee_id,
                            'allowance_id' => $allowance_id,
                        ],
                        [
                            'amount'       => $value,
                            'created_by'   => auth()->user()->name ?? 'system',
                            'created_at'   => now(),
                        ]
                    );
                }
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Salary imported successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSalaryImportHistory(Request $request)
    {
        $data = DB::table('vw_payroll_manual')
            ->select('*');

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('period_name', 'like', '%' . $request->search . '%')
                ->orWhere('employee_name', 'like', '%' . $request->search . '%')
                ->orWhere('allowance_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function ProcessPayroll()
    {
        $data = [
            'title' => 'Process Payroll',
        ];
        return view('payroll.process_payroll', $data);
    }

    public function getPayrollProcessData(Request $request)
    {
        $data = DB::table('vw_payroll_process')
            ->select('*');

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('employee_code', 'like', '%' . $request->search . '%')
                ->orWhere('employee_name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('company_id') && !empty($request->company_id)) {
            $data = $data->where('company_id', $request->company_id);
        }

        if ($request->has('period_id') && !empty($request->period_id)) {
            $data = $data->where('period_id', $request->period_id);
        }

        $data = $data->orderBy('employee_code')->get();
        return response()->json($data);
    }

    public function CrudProcessPayroll(Request $request)
    {
        $employee_id = $request->employee_id;
        $period_id = $request->period_id;
        try {
            DB::beginTransaction();
            switch ($request->action) {
                case 'process':
                    // call sp_generate_payroll
                    DB::statement(
                        "CALL sp_generate_payroll(?, ?)",
                        [
                            $period_id,
                            $employee_id
                        ]
                    );
                    break;
                case 'unpost':
                    // call sp_unpost_payroll
                    DB::statement(
                        "CALL sp_unpost_payroll(?, ?)",
                        [
                            $period_id,
                            $employee_id
                        ]
                    );
                    break;
                default:
                    throw new \Exception('Invalid action');
            }


            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Payroll processed successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function export(Request $request)
    {
        $export = PayrollExport::create([
            'period_id' => $request->period_id,
            'company_id' => $request->company_id,
            'status' => 'pending',
            'created_by' => auth()->id()
        ]);
        GeneratePayrollExportJob::dispatch($export->id);

        return response()->json([
            'success' => true,
            'export_id' => $export->id
        ]);
    }

    public function exportStatus($id)
    {
        $export = PayrollExport::findOrFail($id);
        return response()->json([
            'status' => $export->status,
            'download_url' => $export->file_path
                ? asset('storage/' . $export->file_path)
                : null,
            'message' => $export->message
        ]);
    }
}
