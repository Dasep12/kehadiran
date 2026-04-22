<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkTimeController extends Controller
{
    // Work Time - Attendance Types
    public function AttendaceTypes()
    {
        $data = [
            'title' => 'Attendance Type',
        ];
        return view('worktime.attendance-types', $data);
    }

    public function getAttendaceTypesData(Request $request)
    {
        $data = DB::table('mst_attendance_type')
            ->select('code_attendance', 'name_attendance', 'status_attendance', 'remarks', 'is_show', 'created_at', 'updated_at', 'updated_by');


        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('name_attendance', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudAttendaceTypes(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'code_attendance'            => $request->action == 'create' ? 'required|unique:mst_attendance_type,code_attendance' : 'required',
            'name_attendance'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'code_attendance' => $request->code_attendance,
            'name_attendance' => $request->name_attendance,
            'status_attendance' => $request->status_attendance,
            'remarks' => $request->remarks,
            'is_show'   => 1,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    DB::table('mst_attendance_type')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_attendance_type')->where('code_attendance', $request->code_attendance)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':

                    DB::table('mst_attendance_type')->where('code_attendance', $request->code_attendance)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }
    // end of Master Data - Education


    // Work time - Setting Shift 
    public function ShiftSettings()
    {
        $data = [
            'title' => 'Shift',
        ];
        return view('worktime.shift-settings', $data);
    }

    public function getShiftGroupData(Request $request)
    {
        $data = DB::table('mst_shift_group')
            ->select('shift_group_id', 'shift_group_name', 'description', 'created_at', 'updated_at', 'updated_by');


        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('shift_group_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function getShiftData(Request $request)
    {
        $data = DB::table('mst_shift')
            ->select('shift_id', 'shift_group_id', 'shift_name', 'time_in', 'time_out', 'break_start', 'break_end', 'late_tolerance', 'is_night_shift', 'created_at', 'updated_at', 'updated_by');


        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('shift_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }
}
