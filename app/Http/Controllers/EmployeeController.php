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
        $data = DB::table('vw_employee')->get();
        return response()->json($data);
    }
}
