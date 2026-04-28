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
}
