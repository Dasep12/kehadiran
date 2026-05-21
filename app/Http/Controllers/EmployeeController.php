<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\EmployeeFormatForImport;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $data = [
            'title' => 'Employee',
            'canCreate' => has_permission('employees.index', 'create'),
            'canEdit' => has_permission('employees.index', 'edit'),
            'canDelete' => has_permission('employees.index', 'delete'),
        ];
        return view('employee.index', $data);
    }

    public function getDataEmployee(Request $request)
    {
        $data = DB::table('vw_employee');
        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where(function ($query) use ($request) {
                $query->where('employee_name', 'like', '%' . $request->search . '%')
                    ->orWhere('employee_code', 'like', '%' . $request->search . '%');
            });
        }
        return response()->json($data->get());
    }

    public function getDetailEmployee(Request $request)
    {
        $nameData = $request->nameData;
        $employeeId = $request->employee_id;

        // Gunakan null sebagai default agar bisa divalidasi
        $query = null;

        switch ($nameData) {
            case "organization":
                $query = DB::table('vw_employee_organization')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('start_date', 'desc');
                break;

            case "position":
                $query = DB::table('vw_employee_position')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('start_date', 'desc');
                break;

            case "grade":
                $query = DB::table('vw_employee_grade')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('start_date', 'desc');
                break;

            case "working_status":
                $query = DB::table('vw_employee_working_status')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('start_date', 'desc');
                break;

            case "basic_sallary":
                $query = DB::table('vw_employee_basic_salary_by_date')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('emp_start_date', 'desc');
                break;

            case "bank_account":
                $query = DB::table('vw_employee_bank')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('start_date', 'desc');
                break;

            case "membership":
                $query = DB::table('vw_employee_membership')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('start_date', 'desc');
                break;
            case "ptkp":
                $query = DB::table('vw_employee_ptkp')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('start_date', 'desc');
                break;

            case "education":
                $query = DB::table('vw_employee_education')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('start_date', 'desc');
                break;

            case "overtime":
                $query = DB::table('vw_employee_overtime_group')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('start_date', 'desc');
                break;
            case "family":
                $query = DB::table('vw_employee_family')
                    ->select('*')
                    ->where('employee_id', $employeeId)
                    ->orderBy('created_at', 'desc');
                break;


            default:
                return response()->json([], 200);
        }

        // Pastikan query tidak null sebelum memanggil get()
        return response()->json($query->get());
    }


    public function getSalaryByJoinDate(Request $request)
    {
        $joinDate = $request->join_date;

        $data = DB::table('mst_basic_sallary_group as msg')
            ->join('mst_basic_sallary_group_detail as gsd', 'msg.group_id', '=', 'gsd.group_id')
            ->select(
                'msg.group_id',
                'msg.name_group',
                'gsd.amount'
            )
            ->whereDate('gsd.start_date', '<=', $joinDate)
            ->where(function ($q) use ($joinDate) {
                $q->whereDate('gsd.end_date', '>=', $joinDate)
                    ->orWhereNull('gsd.end_date');
            })
            ->get();

        return response()->json($data);
    }

    // Helper decode JSON kalau string
    private function parseJson($data)
    {
        return is_string($data) ? json_decode($data, true) : $data;
    }
    public function CrudEmployee(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'employee_code' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'employee_name' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'email' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'phone' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'join_date' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'gender' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'id_card' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'npwp' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $message = '';
        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'employee_code' => $request->employee_code,
            'employee_name' => $request->employee_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'join_date' => $request->join_date,
            'gender' => $request->gender,
            'id_card' => $request->id_card,
            'npwp' => $request->npwp,
            'created_by'    => auth()->id() ?? 'system',
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];


        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    DB::table('mst_employee')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_employee')->where('employee_id', $request->employee_id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('mst_employee')->where('employee_id', $request->employee_id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            // Mapping request → handler
            $details = [
                'organization'   => 'CrudOrganization',
                'position'       => 'CrudPosition',
                'workingStatus'  => 'CrudWorkingStatus',
                'grade'          => 'CrudGrade',
                'basicSalary'    => 'CrudBasicSalary',
                'bank'    => 'CrudBankAccount',
                'ptkp'    => 'CrudPTKP',
                'education' => 'CrudEducation',
                'overtime' => 'CrudOvertimeGroup',
                'family' => 'CrudFamily',
            ];

            foreach ($details as $key => $method) {
                $data = self::parseJson($request->$key);

                if (!empty($data) && is_array($data)) {
                    self::$method($data, $request->employee_id);
                }
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    private function CrudOrganization(array $detail, string $employee_id)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }



            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['organization_id']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'organization_id'   => $row['organization_id'],
                'start_date'   => $row['start_date'],
                'end_date'   => $row['end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';

                    $last = DB::table('mst_employee_organization')
                        ->where('employee_id',   $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_organization')
                            ->where('employee_id', $last->employee_id)
                            ->where('organization_id', $last->organization_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($data['start_date'] . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_employee_organization')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_organization')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('organization_id',   $row['organization_id'])
                        ->where('start_date',   $row['start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_organization')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('organization_id',   $row['organization_id'])
                        ->where('start_date',   $row['start_date'])
                        ->delete();

                    $last = DB::table('mst_employee_organization')
                        ->where('employee_id', $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_organization')
                            ->where('employee_id', $last->employee_id)
                            ->where('organization_id', $last->organization_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    private function CrudPosition(array $detail, string $employee_id)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }



            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['position_id']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'position_id'   => $row['position_id'],
                'start_date'   => $row['start_date'],
                'end_date'   => $row['end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';

                    $last = DB::table('mst_employee_position')
                        ->where('employee_id',   $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_position')
                            ->where('employee_id', $last->employee_id)
                            ->where('position_id', $last->position_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($data['start_date'] . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_employee_position')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_position')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('position_id',   $row['position_id'])
                        ->where('start_date',   $row['start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_position')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('position_id',   $row['position_id'])
                        ->where('start_date',   $row['start_date'])
                        ->delete();

                    $last = DB::table('mst_employee_position')
                        ->where('employee_id', $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_position')
                            ->where('employee_id', $last->employee_id)
                            ->where('position_id', $last->position_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    private function CrudWorkingStatus(array $detail, string $employee_id)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }



            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['working_id']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'working_id'   => $row['working_id'],
                'start_date'   => $row['start_date'],
                'end_date'   => $row['end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';

                    $last = DB::table('mst_employee_working_status')
                        ->where('employee_id',   $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_working_status')
                            ->where('employee_id', $last->employee_id)
                            ->where('working_id', $last->working_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($data['start_date'] . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_employee_working_status')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_working_status')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('working_id',   $row['working_id'])
                        ->where('start_date',   $row['start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_working_status')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('working_id',   $row['working_id'])
                        ->where('start_date',   $row['start_date'])
                        ->delete();

                    $last = DB::table('mst_employee_working_status')
                        ->where('employee_id', $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_working_status')
                            ->where('employee_id', $last->employee_id)
                            ->where('working_id', $last->working_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    private function CrudGrade(array $detail, string $employee_id)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }



            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['grade_id']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'grade_id'   => $row['grade_id'],
                'start_date'   => $row['start_date'],
                'end_date'   => $row['end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';

                    $last = DB::table('mst_employee_grade')
                        ->where('employee_id',   $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_grade')
                            ->where('employee_id', $last->employee_id)
                            ->where('grade_id', $last->grade_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($data['start_date'] . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_employee_grade')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_grade')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('grade_id',   $row['grade_id'])
                        ->where('start_date',   $row['start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_grade')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('grade_id',   $row['grade_id'])
                        ->where('start_date',   $row['start_date'])
                        ->delete();

                    $last = DB::table('mst_employee_grade')
                        ->where('employee_id', $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_grade')
                            ->where('employee_id', $last->employee_id)
                            ->where('grade_id', $last->grade_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    private function CrudBasicSalary(array $detail, string $employee_id)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }



            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['group_id']) || empty($row['emp_start_date']) || empty($row['allowance_id'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'allowance_id'   => $row['allowance_id'],
                'group_id'   => $row['group_id'],
                'start_date'   => $row['emp_start_date'],
                'end_date'   => $row['emp_end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';

                    $last = DB::table('mst_employee_basic_sallary')
                        ->where('employee_id',   $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_basic_sallary')
                            ->where('employee_id', $last->employee_id)
                            ->where('group_id', $last->group_id)
                            ->where('allowance_id', $last->allowance_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($data['start_date'] . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_employee_basic_sallary')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_basic_sallary')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('allowance_id', $row['allowance_id'])
                        ->where('group_id',   $row['group_id'])
                        ->where('start_date',   $row['emp_start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_basic_sallary')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('allowance_id', $row['allowance_id'])
                        ->where('group_id',   $row['group_id'])
                        ->where('start_date',   $row['emp_start_date'])
                        ->delete();

                    $last = DB::table('mst_employee_basic_sallary')
                        ->where('employee_id', $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_basic_sallary')
                            ->where('employee_id', $last->employee_id)
                            ->where('allowance_id', $last->allowance_id)
                            ->where('group_id', $last->group_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    private function CrudBankAccount(array $detail, string $employee_id)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }



            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['bank_id']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'bank_id'   => $row['bank_id'],
                'account_name'   => $row['account_name'],
                'account_number'   => $row['account_number'],
                'start_date'   => $row['start_date'],
                'end_date'   => $row['end_date'] == "" ? null :  $row['end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';

                    $last = DB::table('mst_employee_bank')
                        ->where('employee_id',   $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_bank')
                            ->where('employee_id', $last->employee_id)
                            ->where('bank_id', $last->bank_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($data['start_date'] . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_employee_bank')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_bank')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('bank_id',   $row['bank_id'])
                        ->where('start_date',   $row['start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_bank')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('bank_id',   $row['bank_id'])
                        ->where('start_date',   $row['start_date'])
                        ->delete();

                    $last = DB::table('mst_employee_bank')
                        ->where('employee_id', $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_bank')
                            ->where('employee_id', $last->employee_id)
                            ->where('bank_id', $last->bank_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    private function CrudPTKP(array $detail, string $employee_id)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }

            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['ptkp_code']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'ptkp_code'   => $row['ptkp_code'],
                'start_date'   => $row['start_date'],
                'end_date'   => $row['end_date'] == "" ? null :  $row['end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';

                    $last = DB::table('mst_employee_ptkp')
                        ->where('employee_id',   $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_ptkp')
                            ->where('employee_id', $last->employee_id)
                            ->where('ptkp_code', $last->ptkp_code)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($data['start_date'] . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_employee_ptkp')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_ptkp')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('ptkp_code',   $row['ptkp_code'])
                        ->where('start_date',   $row['start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_ptkp')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('ptkp_code',   $row['ptkp_code'])
                        ->where('start_date',   $row['start_date'])
                        ->delete();

                    $last = DB::table('mst_employee_ptkp')
                        ->where('employee_id', $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_ptkp')
                            ->where('employee_id', $last->employee_id)
                            ->where('ptkp_code', $last->ptkp_code)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    private function CrudEducation(array $detail, string $employee_id)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }

            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['education_id']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'education_id'   => $row['education_id'],
                'name_institution'   => $row['name_institution'],
                'major'   => $row['major'],
                'gpa'   => $row['gpa'],
                'start_date'   => $row['start_date'],
                'end_date'   => $row['end_date'] == "" ? null :  $row['end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';

                    $last = DB::table('mst_employee_education')
                        ->where('employee_id',   $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_education')
                            ->where('employee_id', $last->employee_id)
                            ->where('education_id', $last->education_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($data['start_date'] . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_employee_education')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_education')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('education_id',   $row['education_id'])
                        ->where('start_date',   $row['start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_education')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('education_id',   $row['education_id'])
                        ->where('start_date',   $row['start_date'])
                        ->delete();

                    $last = DB::table('mst_employee_education')
                        ->where('employee_id', $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_education')
                            ->where('employee_id', $last->employee_id)
                            ->where('education_id', $last->education_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    private function CrudOvertimeGroup(array $detail, string $employee_id)
    {

        foreach ($detail as $row) {
            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }

            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['group_id']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'group_id'   => $row['group_id'],
                'start_date'   => $row['start_date'],
                'end_date'   => $row['end_date'] == "" ? null :  $row['end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';

                    $last = DB::table('mst_employee_overtime_group')
                        ->where('employee_id',   $employee_id)
                        ->orderByDesc('start_date')
                        ->first();
                    if ($last) {
                        DB::table('mst_employee_overtime_group')
                            ->where('employee_id', $last->employee_id)
                            ->where('group_id', $last->group_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($data['start_date'] . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_employee_overtime_group')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_overtime_group')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('group_id',   $row['group_id'])
                        ->where('start_date',   $row['start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_overtime_group')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('group_id',   $row['group_id'])
                        ->where('start_date',   $row['start_date'])
                        ->delete();

                    $last = DB::table('mst_employee_overtime_group')
                        ->where('employee_id', $employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('mst_employee_overtime_group')
                            ->where('employee_id', $last->employee_id)
                            ->where('group_id', $last->group_id)
                            ->where('start_date', $last->start_date)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    private function CrudFamily(array $detail, string $employee_id)
    {

        foreach ($detail as $row) {
            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }

            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['family_id'])) {
                continue;
            }

            $data = [
                'employee_id'   => $employee_id,
                'family_id'   => $row['family_id'],
                'name_family'   => $row['name_family'],
                'born_date'   => $row['born_date'],
                'born_place'   => $row['born_place'],
                'contact'   => $row['contact'],
                'gender'   => $row['gender'],
                'address'   => $row['address'],
                'id_card'   => $row['id_card'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';
                    DB::table('mst_employee_family')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_employee_family')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('family_id',   $row['family_id'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_employee_family')
                        ->where('employee_id',   $row['employee_id'])
                        ->where('family_id',   $row['family_id'])
                        ->delete();
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    public function importEmployee()
    {
        $data = [
            'title' => 'Imprort Employee',
            'canCreate' => has_permission('employees.importEmployee', 'create'),
            'canEdit' => has_permission('employees.importEmployee', 'edit'),
            'canDelete' => has_permission('employees.importEmployee', 'delete'),
        ];
        return view('employee.import-employee', $data);
    }

    public function downloadFormatEmployeeImport()
    {
        return Excel::download(new EmployeeFormatForImport, 'employee_format.xlsx');
    }

    public function submitImportNewEmployee(Request $request)
    {
        DB::beginTransaction();

        try {

            $import = $request->employee_data;

            $errors = [];

            /*
        |--------------------------------------------------------------------------
        | EMPLOYEE DATA
        |--------------------------------------------------------------------------
        */

            $employee_code       = $import['employee_code'] ?? null;
            $employee_name       = $import['employee_name'] ?? null;
            $email               = $import['email'] ?? null;
            $phone               = $import['phone'] ?? null;
            $gender              = $import['gender'] ?? null;
            $join_date           = $import['join_date'] ?? null;
            $id_card             = $import['id_card'] ?? null;
            $npwp                = $import['npwp'] ?? null;

            $grade_name          = $import['grade_name'] ?? null;
            $position_name       = $import['position_name'] ?? null;
            $working_name        = $import['working_name'] ?? null;
            $ptkp_code           = $import['ptkp_code'] ?? null;
            $education_name      = $import['education_name'] ?? null;
            $bank_name           = $import['bank_name'] ?? null;
            $account_name_bank   = $import['account_name_bank'] ?? null;
            $account_number_bank = $import['account_number_bank'] ?? null;
            $organization_name   = $import['organization_name'] ?? null;
            $company_name        = $import['company_name'] ?? null;



            /*
        |--------------------------------------------------------------------------
        | VALIDATE MASTER DATA
        |--------------------------------------------------------------------------
        */

            $grade = $this->validateMasterData(
                'mst_grade',
                'grade_name',
                $grade_name,
                'Grade',
                'id'
            );

            $position = $this->validateMasterData(
                'mst_position',
                'position_name',
                $position_name,
                'Position',
                'id'
            );

            $organization = $this->validateMasterData(
                'mst_organization',
                'organization_name',
                $organization_name,
                'Organization',
                'organization_id'
            );

            $company = $this->validateMasterData(
                'mst_company',
                'company_name',
                $company_name,
                'Company',
                'company_id'
            );

            $working = $this->validateMasterData(
                'mst_working_status',
                'working_name',
                $working_name,
                'Working Status',
                'id'
            );

            $ptkp = $this->validateMasterData(
                'mst_tax_ptkp',
                'ptkp_code',
                $ptkp_code,
                'PTKP',
                'ptkp_code'
            );

            $education = $this->validateMasterData(
                'mst_education',
                'education_name',
                $education_name,
                'Education',
                'id'
            );

            $bank = $this->validateMasterData(
                'mst_bank',
                'bank_name',
                $bank_name,
                'Bank Name',
                'bank_id'
            );


            /*
        |--------------------------------------------------------------------------
        | COLLECT ERRORS
        |--------------------------------------------------------------------------
        */

            $validations = [
                $grade,
                $position,
                $organization,
                $company,
                $ptkp,
                $working,
                $education,
                $bank
            ];

            foreach ($validations as $validation) {

                if (!$validation['success']) {
                    $errors[] = $validation;
                }
            }

            /*
        |--------------------------------------------------------------------------
        | RETURN VALIDATION ERROR
        |--------------------------------------------------------------------------
        */

            if (!empty($errors)) {

                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'errors'  => $errors
                ], 422);
            }

            /*
        |--------------------------------------------------------------------------
        | INSERT EMPLOYEE
        |--------------------------------------------------------------------------
        */

            $employee_id = DB::table('mst_employee')->insertGetId([

                'employee_code' => $employee_code,
                'employee_name' => $employee_name,
                'email'         => $email,
                'phone'         => $phone,
                'join_date'     => $join_date,
                'gender'        => $gender,
                'id_card'       => $id_card,
                'npwp'          => $npwp,

                'created_by'    => auth()->id() ?? 'system',
                'updated_by'    => auth()->id() ?? 'system',
                'created_at'    => now(),
                'updated_at'    => now(),

            ], 'employee_id');

            /*
        |--------------------------------------------------------------------------
        | INSERT EMPLOYEE GRADE
        |--------------------------------------------------------------------------
        */

            DB::table('mst_employee_grade')->insert([

                'employee_id' => $employee_id,
                'grade_id'    => $grade['id'],
                'start_date'  => $join_date,
                'created_by'  => auth()->id() ?? 'system',
                'updated_by'  => auth()->id() ?? 'system',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            /*
        |--------------------------------------------------------------------------
        | INSERT EMPLOYEE POSITION
        |--------------------------------------------------------------------------
        */

            DB::table('mst_employee_position')->insert([

                'employee_id' => $employee_id,
                'position_id' => $position['id'],
                'start_date'  => $join_date,
                'created_by'  => auth()->id() ?? 'system',
                'updated_by'  => auth()->id() ?? 'system',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            /*
        |--------------------------------------------------------------------------
        | INSERT EMPLOYEE ORGANIZATION
        |--------------------------------------------------------------------------
        */

            DB::table('mst_employee_organization')->insert([

                'employee_id'     => $employee_id,
                'organization_id' => $organization['id'],
                'start_date'      => $join_date,
                'created_by'      => auth()->id() ?? 'system',
                'updated_by'      => auth()->id() ?? 'system',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            /*
        |--------------------------------------------------------------------------
        | INSERT EMPLOYEE WORKING STATUS
        |--------------------------------------------------------------------------
        */

            DB::table('mst_employee_working_status')->insert([

                'employee_id'     => $employee_id,
                'working_id' => $working['id'],
                'start_date'      => $join_date,
                'created_by'      => auth()->id() ?? 'system',
                'updated_by'      => auth()->id() ?? 'system',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
            /*

        |--------------------------------------------------------------------------
        | INSERT EMPLOYEE TAX PTKP
        |--------------------------------------------------------------------------
        */

            DB::table('mst_employee_ptkp')->insert([

                'employee_id'     => $employee_id,
                'ptkp_code' => $ptkp['id'],
                'start_date'      => $join_date,
                'created_by'      => auth()->id() ?? 'system',
                'updated_by'      => auth()->id() ?? 'system',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
            /*

        |--------------------------------------------------------------------------
        | INSERT EMPLOYEE EDUCATION
        |--------------------------------------------------------------------------
        */

            DB::table('mst_employee_education')->insert([

                'employee_id'     => $employee_id,
                'education_id' => $education['id'],
                'start_date'      => $join_date,
                'created_by'      => auth()->id() ?? 'system',
                'updated_by'      => auth()->id() ?? 'system',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            /*

        |--------------------------------------------------------------------------
        | INSERT EMPLOYEE BANK
        |--------------------------------------------------------------------------
        */

            DB::table('mst_employee_bank')->insert([

                'employee_id'     => $employee_id,
                'bank_id'         => $bank['id'],
                'start_date'      => $join_date,
                'account_name'    => $account_name_bank,
                'account_number'  => $account_number_bank,
                'created_by'      => auth()->id() ?? 'system',
                'updated_by'      => auth()->id() ?? 'system',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Employee imported successfully'
            ]);
        } catch (\Exception $ex) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATE MASTER DATA
    |--------------------------------------------------------------------------
    */

    private function validateMasterData(
        $table,
        $column,
        $value,
        $label,
        $idColumn = 'id'
    ) {

        if (empty($value)) {

            return [
                'success' => false,
                'field'   => $column,
                'message' => $label . ' is required',
                'id'      => null
            ];
        }

        $data = DB::table($table)
            ->where($column, $value)
            ->first();

        if (!$data) {

            return [
                'success' => false,
                'field'   => $column,
                'message' => $label . ' master data not found : ' . $value,
                'id'      => null
            ];
        }

        return [
            'success' => true,
            'field'   => $column,
            'message' => null,
            'id'      => $data->$idColumn,
            'data'    => $data
        ];
    }
}
