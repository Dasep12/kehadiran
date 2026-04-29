<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    // Attendance - Employee Shift 
    public function EmployeeShift()
    {
        $data = [
            'title' => 'Shift Employee',
        ];
        return view('attendance.shift-employee', $data);
    }

    public function getEmployeeShiftData(Request $request)
    {
        $data = DB::table('vw_mst_group_shift_employee')
            ->select('*');


        if ($request->formAction == "byDateActive") {
            $data =   $data->where('start_date', '<=', now())
                ->where(function ($query) {
                    $query->where('end_date', '>=', now())
                        ->orWhereNull('end_date');
                });
        } else  if ($request->formAction == "byEmployee") {
            $data =  $data->where('employee_id', $request->employee_id);
        }


        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('employee_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudEmployeeShift(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'shift_group_id'            => $request->action == 'create' ? 'required|exists:mst_shift_group,shift_group_id' : 'required',
            'employee_id'    => $request->action == 'create' ? 'required|exists:mst_employee,employee_id' : 'nullable',
            'start_date' => $request->action != 'delete' ? 'required|date' : 'nullable',
            // 'end_date' => $request->action != 'delete' ? 'after:start_date' : 'nullable',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'end_date' => $request->end_date,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['id'] = $request->id;
                    $data['created_at'] = now();
                    $data['start_date'] = $request->start_date;
                    $data['shift_group_id'] = $request->shift_group_id;
                    $data['employee_id'] = $request->employee_id;
                    $last = DB::table('trn_employee_shift_group')
                        ->where('employee_id', $request->employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('trn_employee_shift_group')
                            ->where('id', $last->id)
                            ->update([
                                'end_date'   => date('Y-m-d', strtotime($request->start_date . ' -1 day')),
                                'updated_at' => now(),
                            ]);
                    }
                    DB::table('trn_employee_shift_group')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('trn_employee_shift_group')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':


                    DB::table('trn_employee_shift_group')->where('id', $request->id)->delete();

                    $last = DB::table('trn_employee_shift_group')
                        ->where('employee_id', $request->employee_id)
                        ->orderByDesc('start_date')
                        ->first();

                    if ($last) {
                        DB::table('trn_employee_shift_group')
                            ->where('id', $last->id)
                            ->update([
                                'end_date'   => null,
                            ]);
                    }

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
    // End of Attendance - Employee Shift 

    // Attendance - Employee Attendance
    public function EmployeeAttendance()
    {
        $data = [
            'title' => 'Attendance Employee',
        ];
        return view('attendance.attendance-employee', $data);
    }

    public function getEmployeeAttendanceData(Request $request)
    {
        // $data = DB::table('vw_attendance_employee')
        //     ->select('*')
        //     ->where('work_date', '2026-04-09'); //date('Y-m-d'));

        // if ($request->has('search') && !empty($request->search)) {
        //     $data = $data->where('employee_name', 'like', '%' . $request->search . '%');
        // }
        // $data = $data->orderBy('work_date', 'asc')->get();
        // return response()->json($data);
        // dd($request->start_date, $request->end_date);
        $query = DB::table('vw_attendance_employee as v')
            ->leftJoin('trn_attendance_allowance as aa', function ($join) {
                $join->on('aa.employee_id', '=', 'v.employee_id')
                    ->on('aa.work_date', '=', 'v.work_date');
            })
            ->select(
                'v.employee_id',
                'v.employee_name',
                'v.employee_code',
                'v.photo',
                'v.photo_path',
                'v.work_date',
                'v.shift_name',
                'v.check_in',
                'v.check_out',
                'v.late_minutes',
                'v.early_leave_minutes',
                'v.schedule_type',
                'v.attendance_status',
                'v.attendance_code',
                'v.overtime_type',
                'v.overtime_first_start',
                'v.overtime_first_end',
                'v.overtime_last_start',
                'v.overtime_last_end',
                'v.overtime_holiday_start',
                'v.overtime_holiday_end',
                'v.total_hours',
                'v.total_hours_actual',
                'v.overtime_index',
                'aa.allowance_id',
                'aa.amount'
            )
            ->whereBetween('v.work_date', [$request->start_date, $request->end_date]);

        // 🔍 search
        if ($request->filled('search')) {
            $query->where('v.employee_name', 'like', '%' . $request->search . '%');
        }

        $rows = $query->orderBy('v.work_date', 'asc')
            ->orderBy('v.employee_name', 'asc')->get();

        // 🔥 Pivot + grouping
        $grouped = [];

        foreach ($rows as $row) {

            $key = $row->employee_id . '_' . $row->work_date;

            // buat 1 row per employee + tanggal
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'id' => $key,
                    'employee_id' => $row->employee_id,
                    'employee_name' => $row->employee_name,
                    'employee_code' => $row->employee_code,
                    'photo' => $row->photo,
                    'photo_path' => $row->photo_path,
                    'work_date' => $row->work_date,
                    'shift_name' => $row->shift_name,
                    'check_in' => $row->check_in,
                    'check_out' => $row->check_out,
                    'late_minutes' => $row->late_minutes,
                    'early_leave_minutes' => $row->early_leave_minutes,
                    'schedule_type' => $row->schedule_type,
                    'attendance_status' => $row->attendance_status,
                    'attendance_code' => $row->attendance_code,
                    'overtime_type' => $row->overtime_type,
                    'overtime_first_start' => $row->overtime_first_start,
                    'overtime_first_end' => $row->overtime_first_end,
                    'overtime_last_start' => $row->overtime_last_start,
                    'overtime_last_end' => $row->overtime_last_end,
                    'overtime_holiday_start' => $row->overtime_holiday_start,
                    'overtime_holiday_end' => $row->overtime_holiday_end,
                    'total_hours' => $row->total_hours,
                    'total_hours_actual' => $row->total_hours_actual,
                    'overtime_index' => $row->overtime_index,
                ];
            }

            // inject allowance jadi kolom
            if ($row->allowance_id) {
                $field = 'allowance_' . $row->allowance_id;
                $grouped[$key][$field] = $row->amount;
            }
        }

        $result = array_values($grouped);

        return response()->json($result);
    }

    public function getEmployeeAttendanceAllowanceData(Request $request)
    {
        $query = DB::table('vw_attendance_allowance')
            ->select('allowance_id', 'allowance_name');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('work_date', [
                $request->start_date,
                $request->end_date
            ]);
        } elseif ($request->start_date) {
            $query->whereDate('work_date', $request->start_date);
        }

        $data = $query
            ->groupBy('allowance_id', 'allowance_name')
            ->get();

        return response()->json($data);
    }
    // End of Attendance - Employee Attendance 

    // Attendance Attendance - Employee Schedule
    public function EmployeeSchedule()
    {
        $data = [
            'title' => 'Schedule Employee',
        ];
        return view('attendance.schedule-employee', $data);
    }

    public function EmployeeScheduleData(Request $request)
    {
        // Filter dari Request (misal dari input date range)
        $startDate = $request->input('start_date', '2026-04-01');
        $endDate = $request->input('end_date', '2026-04-30');

        // Buat list semua tanggal dalam range tersebut
        $period = CarbonPeriod::create($startDate, $endDate);
        $allDates = [];
        foreach ($period as $date) {
            $allDates[] = $date->format('Y-m-d');
        }

        $rawSchedules = DB::table('vw_employee_schedule')
            ->whereBetween('work_date', [$startDate, $endDate])
            ->get();

        if ($request->has('search') && !empty($request->search)) {
            $rawSchedules = $rawSchedules->where('employee_name', 'like', '%' . $request->search . '%')
                ->OrWhere('employee_code', $request->search);
        }

        $data = $rawSchedules->groupBy('employee_id')->map(function ($items) {
            $first = $items->first();
            $row = [
                'photo' => $first->photo,
                'name'  => $first->employee_name,
                'code'  => $first->employee_code,
            ];

            foreach ($items as $item) {
                $key = 'day_' . Carbon::parse($item->work_date)->format('d_M');
                // Simpan object agar Tabulator tahu ini kerja atau libur
                $row[$key] = [
                    'name' => $item->shift_name ?? ($item->schedule_type == 'HOLIDAY' ? $item->schedule_type : '-'),
                    'type' => $item->schedule_type
                ];
            }
            return $row;
        })->values();

        // Buat label untuk header kolom
        $dateLabels = collect($allDates)->map(function ($date) {
            return [
                'field' => 'day_' . Carbon::parse($date)->format('d_M'),
                'label' => Carbon::parse($date)->format('d M')
            ];
        });

        return response()->json([
            'data' => $data,
            'dateLabels' => $dateLabels
        ]);
    }

    public function GenerateSchedule(Request $request)
    {
        $group = $request->shift_group_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        try {
            // Gunakan DB::statement untuk mengeksekusi procedure
            // Gunakan bindings (?) untuk mencegah SQL Injection


            if ($group == "all") {
                $group_all =  DB::table('mst_shift_group')->select('shift_group_id')->get();
                foreach ($group_all as $gr) {
                    DB::statement("CALL sp_generate_employee_schedule(?, ?, ?)", [
                        $gr->shift_group_id,
                        $start_date,
                        $end_date
                    ]);
                }
            } else {
                DB::statement("CALL sp_generate_employee_schedule(?, ?, ?)", [
                    $group,
                    $start_date,
                    $end_date
                ]);
            }



            return response()->json([
                'status'  => 'success',
                'success'   => true,
                'message' => 'Schedule generated successfully!'
            ]);
        } catch (\Exception $e) {
            // Tangkap error jika prosedur gagal
            return response()->json([
                'status'  => 'error',
                'success'   => false,
                'message' => 'Failed to generate schedule: ' . $e->getMessage()
            ], 500);
        }
    }

    public function CrudOvveride(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'shift_group_id' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'shift_id' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $message = '';
        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'shift_group_id' => $request->shift_group_id,
            'work_date' => $request->work_date,
            'shift_id' => $request->shift_id,
            'is_work' => $request->is_work,
            'created_by'    => auth()->id() ?? 'system',
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];


        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    DB::table('trn_shift_group_override_detail')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('trn_shift_group_override_detail')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('trn_shift_group_override_detail')->where('id', $request->id)->delete();
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

    public function ShiftOvverideData(Request $request)
    {
        $data = DB::table('trn_shift_group_override_detail as a')
            ->leftJoin('mst_shift as b', 'b.shift_id', 'a.shift_id')
            ->leftJoin('mst_shift_group as c', 'c.shift_group_id', 'a.shift_group_id')
            ->select('a.*', 'b.shift_name', 'c.shift_group_name');
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }
    // End of Attendance - Employee Schedule

}
