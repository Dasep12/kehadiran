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

    public function CrudShiftGroup(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'shift_group_name'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'shift_group_name' => $request->shift_group_name,
            'description' => $request->description,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] =  auth()->id() ?? 'system';
                    DB::table('mst_shift_group')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_shift_group')->where('shift_group_id', $request->shift_group_id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':

                    DB::table('mst_shift_group')->where('shift_group_id', $request->shift_group_id)->delete();
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

    public function getShiftData(Request $request)
    {
        $data = DB::table('mst_shift')
            ->select('shift_id', 'shift_group_id', 'shift_name', 'time_in', 'time_out', 'break_start', 'break_end', 'late_tolerance', 'workday', 'is_night_shift', 'created_at', 'updated_at', 'updated_by');


        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('shift_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudShift(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'shift_name'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'shift_name' => $request->shift_name,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'late_tolerance' => $request->late_tolerance,
            'is_night_shift' => $request->is_night_shift ?? 1,
            'workday' => $request->workday ?? 1,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] =  auth()->id() ?? 'system';
                    DB::table('mst_shift')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_shift')->where('shift_id', $request->shift_id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':

                    DB::table('mst_shift')->where('shift_id', $request->shift_id)->delete();
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

    public function getShiftPatternData(Request $request)
    {
        $data = DB::table('vw_master_shift_pattern as a')
            ->select('a.*');


        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('pattern_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }
    public function getShiftPatternDetailData(Request $request)
    {
        $data = DB::table('vw_master_shift_pattern_detail as a')
            ->select('a.*');

        $data = $data->where('pattern_id', $request->pattern_id);
        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('shift_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('day_sequence', 'asc')->get();
        return response()->json($data);
    }

    public function CrudShiftPattern(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'shift_group_id' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'pattern_name' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'cycle_days' => $request->action != 'delete' ? 'required|int|max:30' : 'nullable',
            'pattern_start_date' => $request->action != 'delete' ? 'required|string|max:12' : 'nullable',
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'shift_group_id' => $request->shift_group_id,
            'pattern_name' => $request->pattern_name,
            'cycle_days' => $request->cycle_days,
            'pattern_start_date' => $request->pattern_start_date,
            'created_by'    => auth()->id() ?? 'system',
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];


        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    DB::table('mst_shift_pattern')->insert($data);

                    $last_pattern_id = DB::getPdo()->lastInsertId();
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_shift_pattern')->where('pattern_id', $request->pattern_id)->update($data);
                    $last_pattern_id = $request->pattern_id;
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('mst_shift_pattern')->where('pattern_id', $request->pattern_id)->delete();
                    $last_pattern_id = $request->pattern_id;
                    $message = 'Data berhasil dihapus';
                    break;
            }

            // 🔥 Decode jika detail dikirim sebagai JSON string
            $detail = $request->detail;
            if (is_string($detail)) {
                $detail = json_decode($detail, true);
            }

            // 🔥 Proses detail hanya jika ada data
            if (!empty($detail) && is_array($detail)) {
                self::CrudShiftPatternDetail($detail, $last_pattern_id);
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    private function CrudShiftPatternDetail(array $detail, $pattern_id)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }

            if (empty($row['pattern_id'])) {
                $row['pattern_id'] = $pattern_id;
            }
            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['pattern_id']) || empty($row['shift_id']) || empty($row['day_sequence'])) {
                continue;
            }
            $workday = DB::table('mst_shift')
                ->where('shift_id', $row['shift_id'])
                ->value('workday'); // ⬅️ ini langsung ambil value
            $data = [
                'pattern_id'   => $row['pattern_id'],
                'day_sequence'   => $row['day_sequence'],
                'shift_id'     => $row['shift_id'],
                'workday'     => $workday,
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_shift_pattern_detail')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_shift_pattern_detail')
                        ->where('pattern_detail_id',   $row['pattern_detail_id'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_shift_pattern_detail')
                        ->where('pattern_detail_id',   $row['pattern_detail_id'])
                        ->delete();
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }
}
