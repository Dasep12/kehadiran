<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $data = [
            'title' => 'Employee',
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
            // Tambahkan case lainnya di sini...

            default:
                return response()->json([], 200);
        }

        // Pastikan query tidak null sebelum memanggil get()
        return response()->json($query->get());
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

            // 🔥 Decode jika detail dikirim sebagai JSON string
            // $organization = $request->organization;
            // $position = $request->position;
            // $WorkingStatus = $request->workingStatus;
            // if (is_string($organization)) {
            //     $organization = json_decode($organization, true);
            // }

            // if (is_string($position)) {
            //     $position = json_decode($position, true);
            // }
            // if (is_string($WorkingStatus)) {
            //     $WorkingStatus = json_decode($WorkingStatus, true);
            // }
            // // 🔥 Proses detail hanya jika ada data
            // if (!empty($organization) && is_array($organization)) {
            //     self::CrudOrganization($organization, $request->employee_id);
            // }
            // if (!empty($position) && is_array($position)) {
            //     self::CrudPosition($position, $request->employee_id);
            // }

            // if (!empty($WorkingStatus) && is_array($WorkingStatus)) {
            //     self::CrudWorkingStatus($WorkingStatus, $request->employee_id);
            // }
            // Mapping request → handler
            $details = [
                'organization'   => 'CrudOrganization',
                'position'       => 'CrudPosition',
                'workingStatus'  => 'CrudWorkingStatus',
                'grade'          => 'CrudGrade',
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
}
