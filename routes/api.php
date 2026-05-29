<?php

use App\Http\Controllers\API\V1\EssAttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\ESSAuthController;
use App\Http\Controllers\API\V1\EssHomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::post('/v1/login', [AuthController::class, 'loginProcess']);


// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/me', [AuthController::class, 'me']);
//     Route::post('/logout', [AuthController::class, 'logout']);
// });


Route::prefix('v1')->group(function () {

    Route::post('/login', [ESSAuthController::class, 'loginProcess']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [ESSAuthController::class, 'me']);
        Route::post('/logout', [ESSAuthController::class, 'logout']);


        // HOME 
        Route::get('/schedule-today', [EssHomeController::class, 'scheduleToday']);
        Route::get('/announcement', [EssHomeController::class, 'getAnnouncement']);


        // ATTENDANCE 
        Route::get('/history-attendance', [EssAttendanceController::class, 'historyAttendance']);
        Route::post('/submit-absence', [EssAttendanceController::class, 'submitAbsence']);
        Route::get('/location-absence', [EssAttendanceController::class, 'locationAbsenPoint']);
        Route::post('/faceEmbeding', [EssAttendanceController::class, 'faceEmbeding']);
        Route::get('/get-faceEmbeding', [EssAttendanceController::class, 'getFaceEmbeding']);
    });
});
