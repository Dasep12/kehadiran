<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EssHomeController extends Controller
{
    //

    public function scheduleToday(Request $request)
    {
        $data = DB::table('vw_attendance_employee')->where(
            [
                'employee_id' => $request->user()->id,
                'work_date' => date('Y-m-d')
            ]
        )->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getAnnouncement(Request $request)
    {
        $data = DB::table('mst_announcement')->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getWorkCalendar(Request $request)
    {
        $data = DB::table('mst_holiday')->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
