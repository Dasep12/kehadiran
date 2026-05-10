<?php

namespace App\Http\Controllers;

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
            $period_id = 1; // ambil dari request / session / active period
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
}
