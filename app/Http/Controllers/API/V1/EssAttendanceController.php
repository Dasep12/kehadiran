<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EssAttendanceController extends Controller
{
    //



    public function historyAttendance(Request $request)
    {
        try {
            $data = DB::table('vw_attendance_employee')->where(
                [
                    'employee_id' => $request->user()->id,
                    'work_date' => date('Y-m-d')
                ]
            )->select(
                'employee_id',
                'employee_name',
                'work_date',
                'shift_name',
                'check_in',
                'check_out',
                'attendance_status'
            )->get();
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function submitAbsence(Request $request)
    {
        $timeIN = $request->time_in;
        $timeOut = $request->time_out;
        $workDate = $request->work_date;
        $attendanceType  = $request->type;
        $employee_id  = $request->user()->id;
        try {
            DB::statement(
                "CALL sp_absen(?, ?,?,?,?)",
                [
                    $employee_id,
                    $attendanceType,
                    $workDate,
                    $timeIN,
                    $timeOut
                ]
            );
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'success'
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function locationAbsenPoint(Request $request)
    {
        try {
            $lokasiEmployee = DB::table('mst_employee_absent_point')
                ->where('employee_id', $request->user()->id)->get();
            if ($lokasiEmployee->count() > 0) {
                $data = DB::table('mst_employee_absent_point as a')
                    ->leftJoin('mst_absent_point as b', 'a.absent_point_id', 'b.id')
                    ->where('a.employee_id', $request->user()->id)
                    ->select('b.latitude', 'b.longitude', 'b.location', 'b.max_radius')
                    ->get();
            } else {
                $data = DB::table('mst_absent_point')
                    ->select('max_radius', 'latitude', 'longitude', 'location')
                    ->get();
            }
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function faceEmbeding(Request $request)
    {
        // 1. Validasi Input (Pastikan embedding selalu dikirim dan berupa array)
        $request->validate([
            'embedding' => 'required|array',
            'photo_path' => 'nullable|string'
        ]);
        $employee_id = $request->user()->id;

        // 2. Encode array ke JSON string karena kita menggunakan Query Builder (DB::table)
        $embedding_json = json_encode($request->embedding);

        DB::beginTransaction();
        try {
            // 3. Gunakan updateOrInsert: 
            // Jika employee_id sudah ada, maka akan diupdate. Jika belum, akan di-insert.
            DB::table('mst_employee_faces')->updateOrInsert(
                ['employee_id' => $employee_id], // Kondisi pencarian
                [
                    'embedding' => $embedding_json,
                    'photo_path' => $request->photo_path,
                    'updated_at' => now(),
                    'updated_by' => $employee_id,
                    // Jika DB Anda tidak memberikan default CURRENT_TIMESTAMP ke created_at, 
                    // Anda bisa menggunakan DB::raw('CURRENT_TIMESTAMP') 
                ]
            );
            DB::commit();
            // Ambil data yang baru saja disimpan
            $data = DB::table('mst_employee_faces')->where('employee_id', $employee_id)->first();
            // Decode kembali kolom JSON ke array agar response API lebih rapi
            if ($data && is_string($data->embedding)) {
                $data->embedding = json_decode($data->embedding, true);
            }
            return response()->json([
                'success' => true,
                'message' => 'Registrasi wajah berhasil disimpan',
                'data' => $data
            ]);
        } catch (Exception $ex) {
            // 4. Wajib menambahkan RollBack jika terjadi error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Gagal menyimpan wajah: ' . $ex->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }

    public function getFaceEmbeding(Request $request)
    {
        try {
            $employee_id = $request->user()->id;
            // Ambil data yang baru saja disimpan
            $data = DB::table('mst_employee_faces')->where('employee_id', $employee_id)->first();

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
                'message' => 'Gagal ambil data wajah: ' . $ex->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }
}
