<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
