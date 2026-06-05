<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EssProposedController extends Controller
{
    //

    public function proposedOvertime(Request $request)
    {
        $request->validate([
            'work_date'      => 'required|date',
            'day_type'       => 'required',
            'overtime_type'  => 'required',
        ]);

        $file = $request->file('attachments');

        $employee_id = $request->user()->id;

        DB::beginTransaction();

        try {

            $exists = DB::table('req_overtime')
                ->where('employee_id', $employee_id)
                ->whereDate('work_date', $request->work_date)
                ->where('status', '<>', 'REJECTED')
                ->exists();

            if ($exists) {

                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Pengajuan lembur pada tanggal tersebut sudah pernah dibuat dan masih aktif.'
                ], 422);
            }

            $data = [
                'employee_id'    => $employee_id,
                'work_date'      => $request->work_date,
                'day_type'       => $request->day_type,
                'overtime_type'  => $request->overtime_type,
                'early_start'    => $request->early_start,
                'early_end'      => $request->early_end,
                'late_start'     => $request->late_start,
                'late_end'       => $request->late_end,
                'holiday_start'  => $request->holiday_start,
                'holiday_end'    => $request->holiday_end,
                'early_hours'    => $request->early_hours,
                'late_hours'     => $request->late_hours,
                'holiday_hours'  => $request->holiday_hours,
                'total_hours'    => $request->total_hours,
                'shift_id'       => $request->shift_id,
                'remark'         => $request->remark,
                'created_at'     => now(),
                'created_by'     => $employee_id
            ];

            $id = DB::table('req_overtime')->insertGetId($data);
            DB::statement(
                "CALL sp_generate_approval_route(?, ?,?)",
                [
                    $employee_id,
                    'OVERTIME',
                    $id
                ]
            );

            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destination = public_path('assets/document/proposed');
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }
                $file->move($destination, $fileName);
                DB::table('req_attachment')->insert([
                    'request_id' => $id,
                    'module_type' => 'OVERTIME',
                    'path' => 'assets/document/proposed/',
                    'name_attachment' =>  $fileName,
                    'created_at' => now(),
                    'created_by' => $employee_id
                ]);
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan lembur berhasil dibuat.',
                'id'      => $id,
                'data'    => $data
            ]);
        } catch (\Exception $ex) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 500);
        }
    }


    public function checkScheduleWork(Request $request)
    {
        try {
            $employee_id = $request->user()->id;

            $data = DB::table('vw_attendance_employee')
                ->where('employee_id', $employee_id)
                ->where('work_date', $request->work_date)
                ->select('shift_name', 'check_in', 'check_out', 'schedule_type')
                ->first();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Gagal ambil data : ' . $ex->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }


    public function listPermitLeave(Request $request)
    {
        try {
            // Ambil data yang baru saja disimpan
            $data = DB::table('mst_attendance_type')->where('type', $request->type)->select('code_attendance', 'name_attendance')->get();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $ex) {
            // 4. Wajib menambahkan RollBack jika terjadi error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Gagal ambil data : ' . $ex->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }
    public function proposedPermit(Request $request)
    {
        $request->validate([
            'start_date'      => 'required|date',
        ]);

        $file = $request->file('attachments');
        $employee_id = $request->user()->id;
        DB::beginTransaction();

        try {

            $exists = DB::table('req_permit')
                ->where('employee_id', $employee_id)
                ->whereDate('start_date', $request->start_date)
                ->where('status', '<>', 'REJECTED')
                ->exists();

            if ($exists) {

                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Pengajuan izin pada tanggal tersebut sudah pernah dibuat dan masih aktif.'
                ], 422);
            }

            $data = [
                'employee_id'    => $employee_id,
                'attendance_type_id'      => $request->attendance_type_id,
                'start_date'         => $request->start_date,
                'end_date'         => $request->end_date,
                'remark'         => $request->remark,
                'created_at'     => now(),
                'created_by'     => $employee_id
            ];

            $id = DB::table('req_permit')->insertGetId($data);
            DB::statement(
                "CALL sp_generate_approval_route(?, ?,?)",
                [
                    $employee_id,
                    'PERMIT',
                    $id
                ]
            );

            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destination = public_path('assets/document/proposed');
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }
                $file->move($destination, $fileName);
                DB::table('req_attachment')->insert([
                    'request_id' => $id,
                    'module_type' => 'OVERTIME',
                    'path' => 'assets/document/proposed/',
                    'name_attachment' =>  $fileName,
                    'created_at' => now(),
                    'created_by' => $employee_id
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan izin berhasil dibuat.',
                'id'      => $id,
                'data'    => $data
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function proposedLeave(Request $request)
    {
        $request->validate([
            'start_date'      => 'required|date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);

        $totalDays = $startDate->diffInDays($endDate) + 1;
        $file = $request->file('attachments');
        $employee_id = $request->user()->id;
        DB::beginTransaction();

        try {

            $exists = DB::table('req_leave')
                ->where('employee_id', $employee_id)
                ->whereDate('start_date', $request->start_date)
                ->where('status', '<>', 'REJECTED')
                ->exists();

            if ($exists) {

                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Pengajuan izin pada tanggal tersebut sudah pernah dibuat dan masih aktif.'
                ], 422);
            }

            $data = [
                'employee_id'        => $employee_id,
                'leave_type_id'      => $request->leave_type_id,
                'start_date'         => $request->start_date,
                'end_date'           => $request->end_date,
                'total_days'         => $totalDays,
                'remark'             => $request->remark,
                'created_at'         => now(),
                'created_by'         => $employee_id
            ];

            $id = DB::table('req_leave')->insertGetId($data);
            DB::statement(
                "CALL sp_generate_approval_route(?, ?,?)",
                [
                    $employee_id,
                    'LEAVE',
                    $id
                ]
            );

            if ($request->hasFile('attachments')) {
                $file = $request->file('attachments');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $destination = public_path('assets/document/proposed');
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }
                $file->move($destination, $fileName);
                DB::table('req_attachment')->insert([
                    'request_id' => $id,
                    'module_type' => 'OVERTIME',
                    'path' => 'assets/document/proposed/',
                    'name_attachment' =>  $fileName,
                    'created_at' => now(),
                    'created_by' => $employee_id
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan cuti berhasil dibuat.',
                'id'      => $id,
                'data'    => $data
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 500);
        }
    }


    public function listProposed(Request $request)
    {
        try {
            $employee_id = $request->user()->id;

            switch ($request->type) {
                case 'OVERTIME':
                    $query = DB::table('vw_list_proposed_overtime')
                        ->where('employee_id', $employee_id);
                    break;
                case 'PERMIT':
                    $query = DB::table('vw_list_proposed_permit')
                        ->where('employee_id', $employee_id);
                    break;
                case 'LEAVE':
                    $query = DB::table('vw_list_proposed_leave')
                        ->where('employee_id', $employee_id);
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'data' => null,
                        'message' => 'Tipe pengajuan tidak valid.'
                    ], 400); // 400 Bad Request
            }

            $data = $query->get();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Gagal ambil data : ' . $ex->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }

    public function listProposedApprovalDetail(Request $request)
    {
        try {
            $employee_id = $request->user()->id;

            switch ($request->type) {
                case 'OVERTIME':
                    $query = DB::table('vw_list_approval_route')
                        ->where('request_id', $employee_id)
                        ->where('module_type', 'OVERTIME');
                    break;
                case 'PERMIT':
                    $query = DB::table('vw_list_approval_route')
                        ->where('request_id', $employee_id)
                        ->where('module_type', 'PERMIT');
                    break;
                case 'LEAVE':
                    $query = DB::table('vw_list_approval_route')
                        ->where('request_id', $employee_id)
                        ->where('module_type', 'LEAVE');
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'data' => null,
                        'message' => 'Tipe pengajuan tidak valid.'
                    ], 400); // 400 Bad Request
            }

            $data = $query->get();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Gagal ambil data : ' . $ex->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }
}
