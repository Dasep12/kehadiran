<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    //
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
            ->select('*')
            ->where('start_date', '<=', now());


        if ($request->formAction == "byDateActive") {
            $data =   $data->where(function ($query) {
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
}
