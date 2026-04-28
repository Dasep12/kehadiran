<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.main');
});


// Master Education Routes
Route::get('/coredata/education', [App\Http\Controllers\CoreDataController::class, 'education'])->name('coredata.education');
Route::get('/master/education', [App\Http\Controllers\CoreDataController::class, 'getEducationData'])->name('coredata.getEducationData');
Route::post('/master/education-crud', [App\Http\Controllers\CoreDataController::class, 'CrudEducation'])->name('coredata.CrudEducation');

// Master Work Status Routes
Route::get('/coredata/work-status', [App\Http\Controllers\CoreDataController::class, 'workStatus'])->name('coredata.workStatus');
Route::get('/master/work-status', [App\Http\Controllers\CoreDataController::class, 'getWorkStatusData'])->name('coredata.getWorkStatusData');
Route::post('/master/work-status-crud', [App\Http\Controllers\CoreDataController::class, 'CrudWorkStatus'])->name('coredata.CrudWorkStatus');

// Master Position Routes
Route::get('/coredata/position', [App\Http\Controllers\CoreDataController::class, 'position'])->name('coredata.position');
Route::get('/master/position-employee', [App\Http\Controllers\CoreDataController::class, 'getPositionEmployee'])->name('coredata.getPositionEmployee');
Route::post('/master/position-crud', [App\Http\Controllers\CoreDataController::class, 'CrudPosition'])->name('coredata.CrudPosition');
Route::get('/coredata/positionTree', [App\Http\Controllers\CoreDataController::class, 'getTreePosition'])->name('coredata.positionTree');
Route::get('/coredata/positionTreeDetail', [App\Http\Controllers\CoreDataController::class, 'getTreePositionDetail'])->name('coredata.positionTreeDetail');
Route::get('/master/position', [App\Http\Controllers\CoreDataController::class, 'getPositionData'])->name('coredata.getPositionData');


// Master Job Grade Routes
Route::get('/coredata/job-grade', [App\Http\Controllers\CoreDataController::class, 'jobGrade'])->name('coredata.jobGrade');
Route::get('/master/job-grade', [App\Http\Controllers\CoreDataController::class, 'getJobGradeData'])->name('coredata.getJobGradeData');
Route::post('/master/job-grade-crud', [App\Http\Controllers\CoreDataController::class, 'CrudJobGrade'])->name('coredata.CrudJobGrade');


// Master Sallary Component Routes
Route::get('/sallary-tax/allowances', [App\Http\Controllers\SallaryTaxController::class, 'allowances'])->name('sallaryTax.allowances');
Route::get('/master/allowances', [App\Http\Controllers\SallaryTaxController::class, 'getAllowancesData'])->name('sallaryTax.getAllowancesData');
Route::post('/master/allowances-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudAllowances'])->name('sallaryTax.CrudAllowances');

// Master Allowance Position Routes
Route::get('/sallary-tax/allowance-position', [App\Http\Controllers\SallaryTaxController::class, 'allowancePosition'])->name('sallaryTax.allowancePosition');
Route::get('/master/allowance-position', [App\Http\Controllers\SallaryTaxController::class, 'getAllowancePositionData'])->name('sallaryTax.getAllowancePositionData');
Route::post('/master/allowance-position-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudAllowancePosition'])->name('sallaryTax.CrudAllowancePosition');


// Master Data - Pay Periods
Route::get('/sallary-tax/pay-periods', [App\Http\Controllers\SallaryTaxController::class, 'payPeriods'])->name('sallaryTax.payPeriods');
Route::get('/master/pay-periods', [App\Http\Controllers\SallaryTaxController::class, 'getPayPeriodsData'])->name('sallaryTax.getPayPeriodsData');
Route::post('/master/pay-periods-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudPayPeriods'])->name('sallaryTax.CrudPayPeriods');


// Master Data - Tax PTKP
Route::get('/sallary-tax/tax-ptkp', [App\Http\Controllers\SallaryTaxController::class, 'taxPtkp'])->name('sallaryTax.taxPtkp');
Route::get('/master/tax-ptkp', [App\Http\Controllers\SallaryTaxController::class, 'getTaxPtkpData'])->name('sallaryTax.getTaxPtkpData');
Route::post('/master/tax-ptkp-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxPTKP'])->name('sallaryTax.CrudTaxPtkp');


// Master Data - Tax TER
Route::get('/sallary-tax/tax-ter', [App\Http\Controllers\SallaryTaxController::class, 'taxTer'])->name('sallaryTax.taxTer');
Route::get('/master/tax-ter', [App\Http\Controllers\SallaryTaxController::class, 'getTaxTerData'])->name('sallaryTax.getTaxTerData');
Route::post('/master/tax-ter-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxTER'])->name('sallaryTax.CrudTaxTer');



// Master Data - Tax Brackets
Route::get('/sallary-tax/tax-brackets', [App\Http\Controllers\SallaryTaxController::class, 'taxBrackets'])->name('sallaryTax.taxBrackets');
Route::get('/master/tax-brackets', [App\Http\Controllers\SallaryTaxController::class, 'getTaxBracketsData'])->name('sallaryTax.getTaxBracketsData');
Route::post('/master/tax-brackets-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxBrackets'])->name('sallaryTax.CrudTaxBrackets');

// Master Data - Tax Settings
Route::get('/sallary-tax/tax-settings', [App\Http\Controllers\SallaryTaxController::class, 'taxSettings'])->name('sallaryTax.taxSettings');
Route::get('/master/tax-settings', [App\Http\Controllers\SallaryTaxController::class, 'getTaxSettingsData'])->name('sallaryTax.getTaxSettingsData');
Route::post('/master/tax-settings-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxSettings'])->name('sallaryTax.CrudTaxSettings');



// Master Data - Sallary Group
Route::get('/sallary-tax/sallary-group', [App\Http\Controllers\SallaryTaxController::class, 'sallaryGroup'])->name('sallaryTax.sallaryGroup');
Route::get('/master/sallary-group', [App\Http\Controllers\SallaryTaxController::class, 'getSallaryGroupData'])->name('sallaryTax.getSallaryGroupData');
Route::get('/master/sallary-group-detail', [App\Http\Controllers\SallaryTaxController::class, 'getSallaryGroupDataDetail'])->name('sallaryTax.getSallaryGroupDataDetail');
Route::post('/master/sallary-group-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudSallaryGroup'])->name('sallaryTax.CrudSallaryGroup');


// Master Data - Membership Fees
Route::get('/sallary-tax/membership-fees', [App\Http\Controllers\SallaryTaxController::class, 'membershipFees'])->name('sallaryTax.membershipFees');
Route::get('/master/membership-fees', [App\Http\Controllers\SallaryTaxController::class, 'getMembershipFeesData'])->name('sallaryTax.getMembershipFeesData');
Route::get('/master/membership-rate-detail', [App\Http\Controllers\SallaryTaxController::class, 'getMembershipFeesDataRate'])->name('sallaryTax.getMembershipFeesDataRate');
Route::post('/master/membership-fees-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudMembershipFees'])->name('sallaryTax.CrudMembershipFees');
Route::get('/master/membership-list', [App\Http\Controllers\SallaryTaxController::class, 'ListMemberhsipJson'])->name('sallaryTax.ListMemberhsipJson');


// Worktime - Work Time
Route::get('/worktime/worktime-attendance-types', [App\Http\Controllers\WorkTimeController::class, 'AttendaceTypes'])->name('worktime.AttendaceTypes');
Route::get('/worktime/worktime-attendance-types-get', [App\Http\Controllers\WorkTimeController::class, 'getAttendaceTypesData'])->name('worktime.getAttendaceTypesData');
Route::post('/worktime/worktime-attendance-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudAttendaceTypes'])->name('worktime.CrudAttendaceTypes');


// Worktime - Shift Settings 
Route::get('/worktime/worktime-shift-settings', [App\Http\Controllers\WorkTimeController::class, 'ShiftSettings'])->name('worktime.ShiftSettings');
Route::get('/worktime/worktime-shift-group', [App\Http\Controllers\WorkTimeController::class, 'getShiftGroupData'])->name('worktime.getShiftGroupData');
Route::post('/worktime/worktime-shift-group-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudShiftGroup'])->name('worktime.CrudShiftGroup');

Route::get('/worktime/worktime-shift', [App\Http\Controllers\WorkTimeController::class, 'getShiftData'])->name('worktime.getShiftData');
Route::post('/worktime/worktime-shift-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudShift'])->name('worktime.CrudShift');

Route::get('/worktime/worktime-shift-pattern', [App\Http\Controllers\WorkTimeController::class, 'getShiftPatternData'])->name('worktime.getShiftPatternData');
Route::get('/worktime/worktime-shift-pattern-detail', [App\Http\Controllers\WorkTimeController::class, 'getShiftPatternDetailData'])->name('worktime.getShiftPatternDetailData');

Route::post('/worktime/worktime-shift-pattern-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudShiftPattern'])->name('worktime.CrudShiftPattern');


// Worktime - Overtime Settings
Route::get('/worktime/worktime-overtime-settings', [App\Http\Controllers\WorkTimeController::class, 'OvertimeSettings'])->name('worktime.OvertimeSettings');
Route::get('/worktime/worktime-overtime-rule', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeRuleData'])->name('worktime.getOvertimeRuleData');
Route::get('/worktime/worktime-overtime-rate', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeRateData'])->name('worktime.getOvertimeRateData');
Route::post('/worktime/worktime-overtime-rule-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudOvertimeRule'])->name('worktime.CrudOvertimeRule');

Route::get('/worktime/worktime-overtime-group', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeGroupData'])->name('worktime.getOvertimeGroupData');
Route::get('/worktime/worktime-overtime-group-detail', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeGroupDetailData'])->name('worktime.getOvertimeGroupDetailData');
Route::post('/worktime/worktime-overtime-group-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudOvertimeGroup'])->name('worktime.CrudOvertimeGroup');


// Worktime  - Work Calendar
Route::get('/worktime/worktime-work-calendar', [App\Http\Controllers\WorkTimeController::class, 'WorkCalendar'])->name('worktime.WorkCalendar');
Route::get('/worktime/worktime-work-calendar-data', [App\Http\Controllers\WorkTimeController::class, 'getWorkCalendarData'])->name('worktime.getWorkCalendarData');
Route::post('/worktime/worktime-work-calendar-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudWorkCalendar'])->name('worktime.CrudWorkCalendar');


// Attendance - Shift Employee
Route::get('/attendance/attendance-shift-employee', [App\Http\Controllers\AttendanceController::class, 'EmployeeShift'])->name('attendance.EmployeeShift');
Route::get('/attendance/attendance-shift-employee-data', [App\Http\Controllers\AttendanceController::class, 'getEmployeeShiftData'])->name('attendance.getEmployeeShiftData');
Route::post('/worktime/worktime-work-calendar-crud', [App\Http\Controllers\AttendanceController::class, 'CrudEmployeeShift'])->name('attendance.CrudEmployeeShift');

// Attendance - Daily Attendance Employee
Route::get('/attendance/attendance-employee', [App\Http\Controllers\AttendanceController::class, 'EmployeeAttendance'])->name('attendance.EmployeeAttendance');
Route::get('/attendance/attendance-employee-data', [App\Http\Controllers\AttendanceController::class, 'getEmployeeAttendanceData'])->name('attendance.getEmployeeAttendanceData');
Route::get('/attendance/attendance-allowance-employee-data', [App\Http\Controllers\AttendanceController::class, 'getEmployeeAttendanceAllowanceData'])->name('attendance.getEmployeeAttendanceAllowanceData');


// EMPLOYEE - EMPLOYEE DATA
Route::get('/employees/employees-employee-data', [App\Http\Controllers\EmployeeController::class, 'getDataEmployee'])->name('employees.getDataEmployee');
