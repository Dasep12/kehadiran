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

Route::get('/', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.index');

Route::post('/auth', [App\Http\Controllers\AuthController::class, 'loginProcess'])->name('auth.login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->middleware('permission:dashboard.index')
        ->name('dashboard.index');

    // Master Company Routes
    Route::get('/coredata/company', [App\Http\Controllers\CoreDataController::class, 'Company'])
        ->middleware('permission:coredata.company')
        ->name('coredata.company');
    Route::get('/coredata/company-data', [App\Http\Controllers\CoreDataController::class, 'getCompanyDataJson'])
        ->middleware('permission:coredata.getCompanyDataJson')
        ->name('coredata.getCompanyDataJson');
    Route::get('/coredata/company-data-detail', [App\Http\Controllers\CoreDataController::class, 'getSubCompanyData'])
        ->middleware('permission:coredata.getSubCompanyData')
        ->name('coredata.getSubCompanyData');
    Route::post('/coredata/company-data-crud', [App\Http\Controllers\CoreDataController::class, 'CrudCompany'])
        ->middleware('permission:coredata.CrudCompany')
        ->name('coredata.CrudCompany');

    // Master Education Routes
    Route::get('/coredata/education', [App\Http\Controllers\CoreDataController::class, 'education'])
        ->middleware('permission:coredata.education')
        ->name('coredata.education');
    Route::get('/master/education', [App\Http\Controllers\CoreDataController::class, 'getEducationData'])
        ->middleware('permission:coredata.getEducationData')
        ->name('coredata.getEducationData');
    Route::post('/master/education-crud', [App\Http\Controllers\CoreDataController::class, 'CrudEducation'])
        ->middleware('permission:coredata.CrudEducation')
        ->name('coredata.CrudEducation');

    // Master Work Status Routes
    Route::get('/coredata/work-status', [App\Http\Controllers\CoreDataController::class, 'workStatus'])
        ->middleware('permission:coredata.workStatus')
        ->name('coredata.workStatus');
    Route::get('/master/work-status', [App\Http\Controllers\CoreDataController::class, 'getWorkStatusData'])
        ->middleware('permission:coredata.getWorkStatusData')
        ->name('coredata.getWorkStatusData');
    Route::post('/master/work-status-crud', [App\Http\Controllers\CoreDataController::class, 'CrudWorkStatus'])
        ->middleware('permission:coredata.CrudWorkStatus')
        ->name('coredata.CrudWorkStatus');

    // Master Family
    // Route::get('/master/family', [App\Http\Controllers\CoreDataController::class, 'family'])->name('coredata.family');
    Route::get('/master/family-data', [App\Http\Controllers\CoreDataController::class, 'getFamilyData'])
        ->middleware('permission:coredata.getFamilyData')
        ->name('coredata.getFamilyData');

    // Master Position Routes
    Route::get('/coredata/position', [App\Http\Controllers\CoreDataController::class, 'position'])
        ->middleware('permission:coredata.position')
        ->name('coredata.position');
    Route::get('/master/position-employee', [App\Http\Controllers\CoreDataController::class, 'getPositionEmployee'])
        ->middleware('permission:coredata.getPositionEmployee')
        ->name('coredata.getPositionEmployee');
    Route::post('/master/position-crud', [App\Http\Controllers\CoreDataController::class, 'CrudPosition'])
        ->middleware('permission:coredata.CrudPosition')
        ->name('coredata.CrudPosition');
    Route::get('/coredata/positionTree', [App\Http\Controllers\CoreDataController::class, 'getTreePosition'])
        ->middleware('permission:coredata.positionTree')
        ->name('coredata.positionTree');
    Route::get('/coredata/positionTreeDetail', [App\Http\Controllers\CoreDataController::class, 'getTreePositionDetail'])
        ->middleware('permission:coredata.positionTreeDetail')
        ->name('coredata.positionTreeDetail');
    Route::get('/master/position', [App\Http\Controllers\CoreDataController::class, 'getPositionData'])
        ->middleware('permission:coredata.getPositionData')
        ->name('coredata.getPositionData');

    // Master Organization Routes
    Route::get('/coredata/organization', [App\Http\Controllers\CoreDataController::class, 'organization'])
        ->middleware('permission:coredata.organization')
        ->name('coredata.organization');
    Route::get('/coredata/organizationTree', [App\Http\Controllers\CoreDataController::class, 'getTreeOrganization'])
        ->middleware('permission:coredata.organizationTree')
        ->name('coredata.organizationTree');
    Route::get('/master/organization-employee', [App\Http\Controllers\CoreDataController::class, 'getOrganizationEmployee'])
        ->middleware('permission:coredata.getOrganizationEmployee')
        ->name('coredata.getOrganizationEmployee');
    Route::get('/coredata/organizationTree', [App\Http\Controllers\CoreDataController::class, 'getTreeOrganization'])
        ->middleware('permission:coredata.organizationTree')
        ->name('coredata.organizationTree');
    Route::get('/coredata/organizationTreeDetail', [App\Http\Controllers\CoreDataController::class, 'getTreeOrganizationDetail'])
        ->middleware('permission:coredata.OrganizationTreeDetail')
        ->name('coredata.OrganizationTreeDetail');
    Route::post('/master/organization-crud', [App\Http\Controllers\CoreDataController::class, 'CrudOrganization'])
        ->middleware('permission:coredata.CrudOrganization')
        ->name('coredata.CrudOrganization');
    Route::get('/master/organization-parent-level', [App\Http\Controllers\CoreDataController::class, 'getParentOrganizationLevel'])
        ->middleware('permission:coredata.getParentOrganizationLevel')
        ->name('coredata.getParentOrganizationLevel');

    // Master Company Routes
    Route::get('/master/company-data', [App\Http\Controllers\CoreDataController::class, 'getCompanyData'])
        ->middleware('permission:coredata.getCompanyData')
        ->name('coredata.getCompanyData');

    // Master Job Grade Routes
    Route::get('/coredata/job-grade', [App\Http\Controllers\CoreDataController::class, 'jobGrade'])
        ->middleware('permission:coredata.jobGrade')
        ->name('coredata.jobGrade');
    Route::get('/master/job-grade', [App\Http\Controllers\CoreDataController::class, 'getJobGradeData'])
        ->middleware('permission:coredata.getJobGradeData')
        ->name('coredata.getJobGradeData');
    Route::post('/master/job-grade-crud', [App\Http\Controllers\CoreDataController::class, 'CrudJobGrade'])
        ->middleware('permission:coredata.CrudJobGrade')
        ->name('coredata.CrudJobGrade');

    Route::get('/master/bank', [App\Http\Controllers\CoreDataController::class, 'getBankData'])
        ->middleware('permission:coredata.getBankData')
        ->name('coredata.getBankData');

    // Master Sallary Component Routes
    Route::get('/sallary-tax/allowances', [App\Http\Controllers\SallaryTaxController::class, 'allowances'])
        ->middleware('permission:sallaryTax.allowances')
        ->name('sallaryTax.allowances');
    Route::get('/master/allowances', [App\Http\Controllers\SallaryTaxController::class, 'getAllowancesData'])
        ->middleware('permission:sallaryTax.getAllowancesData')
        ->name('sallaryTax.getAllowancesData');
    Route::post('/master/allowances-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudAllowances'])
        ->middleware('permission:sallaryTax.CrudAllowances')
        ->name('sallaryTax.CrudAllowances');

    // Master Allowance Position Routes
    Route::get('/sallary-tax/allowance-position', [App\Http\Controllers\SallaryTaxController::class, 'allowancePosition'])
        ->middleware('permission:sallaryTax.allowancePosition')
        ->name('sallaryTax.allowancePosition');
    Route::get('/master/allowance-position', [App\Http\Controllers\SallaryTaxController::class, 'getAllowancePositionData'])
        ->middleware('permission:sallaryTax.getAllowancePositionData')
        ->name('sallaryTax.getAllowancePositionData');
    Route::post('/master/allowance-position-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudAllowancePosition'])
        ->middleware('permission:sallaryTax.CrudAllowancePosition')
        ->name('sallaryTax.CrudAllowancePosition');


    // Master Data - Pay Periods
    Route::get('/sallary-tax/pay-periods', [App\Http\Controllers\SallaryTaxController::class, 'payPeriods'])
        ->middleware('permission:sallaryTax.payPeriods')
        ->name('sallaryTax.payPeriods');
    Route::get('/master/pay-periods', [App\Http\Controllers\SallaryTaxController::class, 'getPayPeriodsData'])
        ->middleware('permission:sallaryTax.getPayPeriodsData')
        ->name('sallaryTax.getPayPeriodsData');
    Route::post('/master/pay-periods-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudPayPeriods'])
        ->middleware('permission:sallaryTax.CrudPayPeriods')
        ->name('sallaryTax.CrudPayPeriods');


    // Master Data - Tax PTKP
    Route::get('/sallary-tax/tax-ptkp', [App\Http\Controllers\SallaryTaxController::class, 'taxPtkp'])
        ->middleware('permission:sallaryTax.taxPtkp')
        ->name('sallaryTax.taxPtkp');
    Route::get('/master/tax-ptkp', [App\Http\Controllers\SallaryTaxController::class, 'getTaxPtkpData'])
        ->middleware('permission:sallaryTax.getTaxPtkpData')
        ->name('sallaryTax.getTaxPtkpData');
    Route::post('/master/tax-ptkp-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxPTKP'])
        ->middleware('permission:sallaryTax.CrudTaxPtkp')
        ->name('sallaryTax.CrudTaxPtkp');


    // Master Data - Tax TER
    Route::get('/sallary-tax/tax-ter', [App\Http\Controllers\SallaryTaxController::class, 'taxTer'])
        ->middleware('permission:sallaryTax.taxTer')
        ->name('sallaryTax.taxTer');
    Route::get('/master/tax-ter', [App\Http\Controllers\SallaryTaxController::class, 'getTaxTerData'])
        ->middleware('permission:sallaryTax.getTaxTerData')
        ->name('sallaryTax.getTaxTerData');
    Route::post('/master/tax-ter-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxTER'])
        ->middleware('permission:sallaryTax.CrudTaxTer')
        ->name('sallaryTax.CrudTaxTer');



    // Master Data - Tax Brackets
    Route::get('/sallary-tax/tax-brackets', [App\Http\Controllers\SallaryTaxController::class, 'taxBrackets'])
        ->middleware('permission:sallaryTax.taxBrackets')
        ->name('sallaryTax.taxBrackets');
    Route::get('/master/tax-brackets', [App\Http\Controllers\SallaryTaxController::class, 'getTaxBracketsData'])
        ->middleware('permission:sallaryTax.getTaxBracketsData')
        ->name('sallaryTax.getTaxBracketsData');
    Route::post('/master/tax-brackets-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxBrackets'])
        ->middleware('permission:sallaryTax.CrudTaxBrackets')
        ->name('sallaryTax.CrudTaxBrackets');

    // Master Data - Tax Settings
    Route::get('/sallary-tax/tax-settings', [App\Http\Controllers\SallaryTaxController::class, 'taxSettings'])
        ->middleware('permission:sallaryTax.taxSettings')
        ->name('sallaryTax.taxSettings');
    Route::get('/master/tax-settings', [App\Http\Controllers\SallaryTaxController::class, 'getTaxSettingsData'])
        ->middleware('permission:sallaryTax.getTaxSettingsData')
        ->name('sallaryTax.getTaxSettingsData');
    Route::post('/master/tax-settings-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxSettings'])
        ->middleware('permission:sallaryTax.CrudTaxSettings')
        ->name('sallaryTax.CrudTaxSettings');



    // Master Data - Sallary Group
    Route::get('/sallary-tax/sallary-group', [App\Http\Controllers\SallaryTaxController::class, 'sallaryGroup'])
        ->middleware('permission:sallaryTax.sallaryGroup')
        ->name('sallaryTax.sallaryGroup');
    Route::get('/master/sallary-group', [App\Http\Controllers\SallaryTaxController::class, 'getSallaryGroupData'])
        ->middleware('permission:sallaryTax.getSallaryGroupData')
        ->name('sallaryTax.getSallaryGroupData');
    Route::get('/master/sallary-group-detail', [App\Http\Controllers\SallaryTaxController::class, 'getSallaryGroupDataDetail'])
        ->middleware('permission:sallaryTax.getSallaryGroupDataDetail')
        ->name('sallaryTax.getSallaryGroupDataDetail');
    Route::post('/master/sallary-group-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudSallaryGroup'])
        ->middleware('permission:sallaryTax.CrudSallaryGroup')
        ->name('sallaryTax.CrudSallaryGroup');


    // Master Data - Membership Fees
    Route::get('/sallary-tax/membership-fees', [App\Http\Controllers\SallaryTaxController::class, 'membershipFees'])
        ->middleware('permission:sallaryTax.membershipFees')
        ->name('sallaryTax.membershipFees');
    Route::get('/master/membership-fees', [App\Http\Controllers\SallaryTaxController::class, 'getMembershipFeesData'])
        ->middleware('permission:sallaryTax.getMembershipFeesData')
        ->name('sallaryTax.getMembershipFeesData');
    Route::get('/master/membership-rate-detail', [App\Http\Controllers\SallaryTaxController::class, 'getMembershipFeesDataRate'])
        ->middleware('permission:sallaryTax.getMembershipFeesDataRate')
        ->name('sallaryTax.getMembershipFeesDataRate');
    Route::post('/master/membership-fees-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudMembershipFees'])
        ->middleware('permission:sallaryTax.CrudMembershipFees')
        ->name('sallaryTax.CrudMembershipFees');
    Route::get('/master/membership-list', [App\Http\Controllers\SallaryTaxController::class, 'ListMemberhsipJson'])
        ->middleware('permission:sallaryTax.ListMemberhsipJson')
        ->name('sallaryTax.ListMemberhsipJson');


    // Worktime - Work Time
    Route::get('/worktime/worktime-attendance-types', [App\Http\Controllers\WorkTimeController::class, 'AttendaceTypes'])
        ->middleware('permission:worktime.AttendaceTypes')
        ->name('worktime.AttendaceTypes');
    Route::get('/worktime/worktime-attendance-types-get', [App\Http\Controllers\WorkTimeController::class, 'getAttendaceTypesData'])
        ->middleware('permission:worktime.getAttendaceTypesData')
        ->name('worktime.getAttendaceTypesData');
    Route::post('/worktime/worktime-attendance-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudAttendaceTypes'])
        ->middleware('permission:worktime.CrudAttendaceTypes')
        ->name('worktime.CrudAttendaceTypes');


    // Worktime - Shift Settings 
    Route::get('/worktime/worktime-shift-settings', [App\Http\Controllers\WorkTimeController::class, 'ShiftSettings'])
        ->middleware('permission:worktime.ShiftSettings')
        ->name('worktime.ShiftSettings');
    Route::get('/worktime/worktime-shift-group', [App\Http\Controllers\WorkTimeController::class, 'getShiftGroupData'])
        ->middleware('permission:worktime.getShiftGroupData')
        ->name('worktime.getShiftGroupData');
    Route::post('/worktime/worktime-shift-group-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudShiftGroup'])
        ->middleware('permission:worktime.CrudShiftGroup')
        ->name('worktime.CrudShiftGroup');

    Route::get('/worktime/worktime-shift', [App\Http\Controllers\WorkTimeController::class, 'getShiftData'])
        ->middleware('permission:worktime.getShiftData')
        ->name('worktime.getShiftData');
    Route::post('/worktime/worktime-shift-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudShift'])
        ->middleware('permission:worktime.CrudShift')
        ->name('worktime.CrudShift');

    Route::get('/worktime/worktime-shift-pattern', [App\Http\Controllers\WorkTimeController::class, 'getShiftPatternData'])
        ->middleware('permission:worktime.getShiftPatternData')
        ->name('worktime.getShiftPatternData');
    Route::get('/worktime/worktime-shift-pattern-detail', [App\Http\Controllers\WorkTimeController::class, 'getShiftPatternDetailData'])
        ->middleware('permission:worktime.getShiftPatternDetailData')
        ->name('worktime.getShiftPatternDetailData');

    Route::post('/worktime/worktime-shift-pattern-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudShiftPattern'])
        ->middleware('permission:worktime.CrudShiftPattern')
        ->name('worktime.CrudShiftPattern');


    // Worktime - Overtime Settings
    Route::get('/worktime/worktime-overtime-settings', [App\Http\Controllers\WorkTimeController::class, 'OvertimeSettings'])
        ->middleware('permission:worktime.OvertimeSettings')
        ->name('worktime.OvertimeSettings');
    Route::get('/worktime/worktime-overtime-rule', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeRuleData'])
        ->middleware('permission:worktime.getOvertimeRuleData')
        ->name('worktime.getOvertimeRuleData');
    Route::get('/worktime/worktime-overtime-rate', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeRateData'])
        ->middleware('permission:worktime.getOvertimeRateData')
        ->name('worktime.getOvertimeRateData');
    Route::post('/worktime/worktime-overtime-rule-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudOvertimeRule'])
        ->middleware('permission:worktime.CrudOvertimeRule')
        ->name('worktime.CrudOvertimeRule');

    Route::get('/worktime/worktime-overtime-group', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeGroupData'])
        ->middleware('permission:worktime.getOvertimeGroupData')
        ->name('worktime.getOvertimeGroupData');
    Route::get('/worktime/worktime-overtime-group-detail', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeGroupDetailData'])
        ->middleware('permission:worktime.getOvertimeGroupDetailData')
        ->name('worktime.getOvertimeGroupDetailData');
    Route::post('/worktime/worktime-overtime-group-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudOvertimeGroup'])
        ->middleware('permission:worktime.CrudOvertimeGroup')
        ->name('worktime.CrudOvertimeGroup');


    // Worktime  - Work Calendar
    Route::get('/worktime/worktime-work-calendar', [App\Http\Controllers\WorkTimeController::class, 'WorkCalendar'])
        ->middleware('permission:worktime.WorkCalendar')
        ->name('worktime.WorkCalendar');
    Route::get('/worktime/worktime-work-calendar-data', [App\Http\Controllers\WorkTimeController::class, 'getWorkCalendarData'])
        ->middleware('permission:worktime.getWorkCalendarData')
        ->name('worktime.getWorkCalendarData');
    Route::post('/worktime/worktime-work-calendar-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudWorkCalendar'])
        ->middleware('permission:worktime.CrudWorkCalendar')
        ->name('worktime.CrudWorkCalendar');


    // Attendance - Shift Employee
    Route::get('/attendance/attendance-shift-employee', [App\Http\Controllers\AttendanceController::class, 'EmployeeShift'])
        ->middleware('permission:attendance.EmployeeShift')
        ->name('attendance.EmployeeShift');
    Route::get('/attendance/attendance-shift-employee-data', [App\Http\Controllers\AttendanceController::class, 'getEmployeeShiftData'])
        ->middleware('permission:attendance.getEmployeeShiftData')
        ->name('attendance.getEmployeeShiftData');
    Route::post('/worktime/worktime-employee-shift-crud', [App\Http\Controllers\AttendanceController::class, 'CrudEmployeeShift'])
        ->middleware('permission:attendance.CrudEmployeeShift')
        ->name('attendance.CrudEmployeeShift');

    // Attendance - Daily Attendance Employee
    Route::get('/attendance/attendance-employee', [App\Http\Controllers\AttendanceController::class, 'EmployeeAttendance'])
        ->middleware('permission:attendance.EmployeeAttendance')
        ->name('attendance.EmployeeAttendance');
    Route::get('/attendance/attendance-employee-data', [App\Http\Controllers\AttendanceController::class, 'getEmployeeAttendanceData'])
        ->middleware('permission:attendance.getEmployeeAttendanceData')
        ->name('attendance.getEmployeeAttendanceData');
    Route::get('/attendance/attendance-allowance-employee-data', [App\Http\Controllers\AttendanceController::class, 'getEmployeeAttendanceAllowanceData'])
        ->middleware('permission:attendance.getEmployeeAttendanceAllowanceData')
        ->name('attendance.getEmployeeAttendanceAllowanceData');



    // Attendance - Schedule Employee
    Route::get('/attendance/schedule-employee', [App\Http\Controllers\AttendanceController::class, 'EmployeeSchedule'])
        ->middleware('permission:attendance.EmployeeSchedule')
        ->name('attendance.EmployeeSchedule');
    Route::get('/attendance/schedule-employee-data', [App\Http\Controllers\AttendanceController::class, 'EmployeeScheduleData'])
        ->middleware('permission:attendance.EmployeeScheduleData')
        ->name('attendance.EmployeeScheduleData');
    Route::post('/attendance/schedule-employee-data', [App\Http\Controllers\AttendanceController::class, 'GenerateSchedule'])
        ->middleware('permission:attendance.GenerateSchedule')
        ->name('attendance.GenerateSchedule');
    Route::post('/attendance/schedule-crud-ovveride', [App\Http\Controllers\AttendanceController::class, 'CrudOvveride'])
        ->middleware('permission:attendance.CrudOvveride')
        ->name('attendance.CrudOvveride');
    Route::get('/attendance/schedule-shift-ovveride', [App\Http\Controllers\AttendanceController::class, 'ShiftOvverideData'])
        ->middleware('permission:attendance.ShiftOvverideData')
        ->name('attendance.ShiftOvverideData');



    // EMPLOYEE - EMPLOYEE DATA
    Route::get('/employees/index', [App\Http\Controllers\EmployeeController::class, 'index'])
        ->middleware('permission:employees.index')
        ->name('employees.index');
    Route::get('/employees/employees-employee-data', [App\Http\Controllers\EmployeeController::class, 'getDataEmployee'])
        ->middleware('permission:employees.getDataEmployee')
        ->name('employees.getDataEmployee');
    Route::get('/employees/employees-employee-detail-data', [App\Http\Controllers\EmployeeController::class, 'getDetailEmployee'])
        ->middleware('permission:employees.getDetailEmployee')
        ->name('employees.getDetailEmployee');
    Route::post('/employees/employees-crud', [App\Http\Controllers\EmployeeController::class, 'CrudEmployee'])
        ->middleware('permission:employees.CrudEmployee')
        ->name('employees.CrudEmployee');
    Route::get('/employees/employees-salary-join-date', [App\Http\Controllers\EmployeeController::class, 'getSalaryByJoinDate'])
        ->middleware('permission:employees.getSalaryByJoinDate')
        ->name('employees.getSalaryByJoinDate');

    // Employee - Import Employee
    Route::get('/employees/import-employee', [App\Http\Controllers\EmployeeController::class, 'importEmployee'])
        ->middleware('permission:employees.importEmployee')
        ->name('employees.importEmployee');
    Route::get('/employees/import-employee-format', [App\Http\Controllers\EmployeeController::class, 'downloadFormatEmployeeImport'])
        ->middleware('permission:employees.import.downloadFormat')
        ->name('employees.import.downloadFormat');
    Route::post('/employees/submit-import-employee', [App\Http\Controllers\EmployeeController::class, 'submitImportNewEmployee'])
        ->middleware('permission:employees.import.submit')
        ->name('employees.import.submit');



    // PAYROLL - SALARY MANUAL
    Route::get('/payroll/salary-manual', [App\Http\Controllers\PayrollController::class, 'SalaryManual'])
        ->middleware('permission:payroll.salary-manual')
        ->name('payroll.salary-manual');
    Route::post('/payroll/salary-import', [App\Http\Controllers\PayrollController::class, 'SalaryImport'])
        ->middleware('permission:payroll.salary-import')
        ->name('payroll.salary-import');
    Route::get('/payroll/salary-import-history', [App\Http\Controllers\PayrollController::class, 'getSalaryImportHistory'])
        ->middleware('permission:payroll.getSalaryImportHistory')
        ->name('payroll.getSalaryImportHistory');


    // PAYROLL - PROCESS PAYROLL
    Route::get('/payroll/process-payroll', [App\Http\Controllers\PayrollController::class, 'ProcessPayroll'])
        ->middleware('permission:payroll.process-payroll')
        ->name('payroll.process-payroll');
    Route::get('/payroll/process-payroll-data', [App\Http\Controllers\PayrollController::class, 'getPayrollProcessData'])
        ->middleware('permission:payroll.getPayrollProcessData')
        ->name('payroll.getPayrollProcessData');
    Route::post('/payroll/process-payroll-crud', [App\Http\Controllers\PayrollController::class, 'CrudProcessPayroll'])
        ->middleware('permission:payroll.CrudProcessPayroll')
        ->name('payroll.CrudProcessPayroll');
    Route::post('/export', [App\Http\Controllers\PayrollController::class, 'export'])
        ->middleware('permission:payroll.export')
        ->name('payroll.export');
    Route::get('/export-status/{id}', [App\Http\Controllers\PayrollController::class, 'exportStatus'])
        ->middleware('permission:payroll.export.status')
        ->name('payroll.export.status');
    Route::post('/payroll/close-period', [App\Http\Controllers\PayrollController::class, 'closePayroll'])
        ->middleware('permission:payroll.closePayroll')
        ->name('payroll.closePayroll');
    Route::get('/payroll/close-period-status', [App\Http\Controllers\PayrollController::class, 'checkPayrollStatus'])
        ->middleware('permission:payroll.checkPayrollStatus')
        ->name('payroll.checkPayrollStatus');
});
