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
        ->name('coredata.getCompanyDataJson');
    Route::get('/coredata/company-data-detail', [App\Http\Controllers\CoreDataController::class, 'getSubCompanyData'])
        ->name('coredata.getSubCompanyData');
    Route::post('/coredata/company-data-crud', [App\Http\Controllers\CoreDataController::class, 'CrudCompany'])
        ->name('coredata.CrudCompany');

    // Master Education Routes
    Route::get('/coredata/education', [App\Http\Controllers\CoreDataController::class, 'education'])
        ->middleware('permission:coredata.education')
        ->name('coredata.education');
    Route::get('/master/education', [App\Http\Controllers\CoreDataController::class, 'getEducationData'])
        ->name('coredata.getEducationData');
    Route::post('/master/education-crud', [App\Http\Controllers\CoreDataController::class, 'CrudEducation'])
        ->name('coredata.CrudEducation');

    // Master Work Status Routes
    Route::get('/coredata/work-status', [App\Http\Controllers\CoreDataController::class, 'workStatus'])
        ->middleware('permission:coredata.workStatus')
        ->name('coredata.workStatus');
    Route::get('/master/work-status', [App\Http\Controllers\CoreDataController::class, 'getWorkStatusData'])
        ->name('coredata.getWorkStatusData');
    Route::post('/master/work-status-crud', [App\Http\Controllers\CoreDataController::class, 'CrudWorkStatus'])
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
        ->name('coredata.getPositionEmployee');
    Route::post('/master/position-crud', [App\Http\Controllers\CoreDataController::class, 'CrudPosition'])
        ->name('coredata.CrudPosition');
    Route::get('/coredata/positionTree', [App\Http\Controllers\CoreDataController::class, 'getTreePosition'])
        ->name('coredata.positionTree');
    Route::get('/coredata/positionTreeDetail', [App\Http\Controllers\CoreDataController::class, 'getTreePositionDetail'])
        ->name('coredata.positionTreeDetail');
    Route::get('/master/position', [App\Http\Controllers\CoreDataController::class, 'getPositionData'])
        ->name('coredata.getPositionData');

    // Master Organization Routes
    Route::get('/coredata/organization', [App\Http\Controllers\CoreDataController::class, 'organization'])
        ->middleware('permission:coredata.organization')
        ->name('coredata.organization');
    Route::get('/coredata/organizationTree', [App\Http\Controllers\CoreDataController::class, 'getTreeOrganization'])
        ->name('coredata.organizationTree');
    Route::get('/master/organization-employee', [App\Http\Controllers\CoreDataController::class, 'getOrganizationEmployee'])
        ->name('coredata.getOrganizationEmployee');
    Route::get('/coredata/organizationTree', [App\Http\Controllers\CoreDataController::class, 'getTreeOrganization'])
        ->name('coredata.organizationTree');
    Route::get('/coredata/organizationTreeDetail', [App\Http\Controllers\CoreDataController::class, 'getTreeOrganizationDetail'])
        ->name('coredata.OrganizationTreeDetail');
    Route::post('/master/organization-crud', [App\Http\Controllers\CoreDataController::class, 'CrudOrganization'])
        ->name('coredata.CrudOrganization');
    Route::get('/master/organization-parent-level', [App\Http\Controllers\CoreDataController::class, 'getParentOrganizationLevel'])
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
        ->name('coredata.getJobGradeData');
    Route::post('/master/job-grade-crud', [App\Http\Controllers\CoreDataController::class, 'CrudJobGrade'])
        ->name('coredata.CrudJobGrade');

    Route::get('/master/bank', [App\Http\Controllers\CoreDataController::class, 'getBankData'])
        ->middleware('permission:coredata.getBankData')
        ->name('coredata.getBankData');

    // Master Sallary Component Routes
    Route::get('/sallary-tax/allowances', [App\Http\Controllers\SallaryTaxController::class, 'allowances'])
        ->middleware('permission:sallaryTax.allowances')
        ->name('sallaryTax.allowances');
    Route::get('/master/allowances', [App\Http\Controllers\SallaryTaxController::class, 'getAllowancesData'])
        ->name('sallaryTax.getAllowancesData');
    Route::post('/master/allowances-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudAllowances'])
        ->name('sallaryTax.CrudAllowances');

    // Master Allowance Position Routes
    Route::get('/sallary-tax/allowance-position', [App\Http\Controllers\SallaryTaxController::class, 'allowancePosition'])
        ->middleware('permission:sallaryTax.allowancePosition')
        ->name('sallaryTax.allowancePosition');
    Route::get('/master/allowance-position', [App\Http\Controllers\SallaryTaxController::class, 'getAllowancePositionData'])
        ->name('sallaryTax.getAllowancePositionData');
    Route::post('/master/allowance-position-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudAllowancePosition'])
        ->name('sallaryTax.CrudAllowancePosition');


    // Master Data - Pay Periods
    Route::get('/sallary-tax/pay-periods', [App\Http\Controllers\SallaryTaxController::class, 'payPeriods'])
        ->middleware('permission:sallaryTax.payPeriods')
        ->name('sallaryTax.payPeriods');
    Route::get('/master/pay-periods', [App\Http\Controllers\SallaryTaxController::class, 'getPayPeriodsData'])
        ->name('sallaryTax.getPayPeriodsData');
    Route::post('/master/pay-periods-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudPayPeriods'])
        ->name('sallaryTax.CrudPayPeriods');


    // Master Data - Tax PTKP
    Route::get('/sallary-tax/tax-ptkp', [App\Http\Controllers\SallaryTaxController::class, 'taxPtkp'])
        ->middleware('permission:sallaryTax.taxPtkp')
        ->name('sallaryTax.taxPtkp');
    Route::get('/master/tax-ptkp', [App\Http\Controllers\SallaryTaxController::class, 'getTaxPtkpData'])
        ->name('sallaryTax.getTaxPtkpData');
    Route::post('/master/tax-ptkp-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxPTKP'])
        ->name('sallaryTax.CrudTaxPtkp');


    // Master Data - Tax TER
    Route::get('/sallary-tax/tax-ter', [App\Http\Controllers\SallaryTaxController::class, 'taxTer'])
        ->middleware('permission:sallaryTax.taxTer')
        ->name('sallaryTax.taxTer');
    Route::get('/master/tax-ter', [App\Http\Controllers\SallaryTaxController::class, 'getTaxTerData'])
        ->name('sallaryTax.getTaxTerData');
    Route::post('/master/tax-ter-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxTER'])
        ->name('sallaryTax.CrudTaxTer');



    // Master Data - Tax Brackets
    Route::get('/sallary-tax/tax-brackets', [App\Http\Controllers\SallaryTaxController::class, 'taxBrackets'])
        ->middleware('permission:sallaryTax.taxBrackets')
        ->name('sallaryTax.taxBrackets');
    Route::get('/master/tax-brackets', [App\Http\Controllers\SallaryTaxController::class, 'getTaxBracketsData'])
        ->name('sallaryTax.getTaxBracketsData');
    Route::post('/master/tax-brackets-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxBrackets'])
        ->name('sallaryTax.CrudTaxBrackets');

    // Master Data - Tax Settings
    Route::get('/sallary-tax/tax-settings', [App\Http\Controllers\SallaryTaxController::class, 'taxSettings'])
        ->middleware('permission:sallaryTax.taxSettings')
        ->name('sallaryTax.taxSettings');
    Route::get('/master/tax-settings', [App\Http\Controllers\SallaryTaxController::class, 'getTaxSettingsData'])
        ->name('sallaryTax.getTaxSettingsData');
    Route::post('/master/tax-settings-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudTaxSettings'])
        ->name('sallaryTax.CrudTaxSettings');



    // Master Data - Sallary Group
    Route::get('/sallary-tax/sallary-group', [App\Http\Controllers\SallaryTaxController::class, 'sallaryGroup'])
        ->middleware('permission:sallaryTax.sallaryGroup')
        ->name('sallaryTax.sallaryGroup');
    Route::get('/master/sallary-group', [App\Http\Controllers\SallaryTaxController::class, 'getSallaryGroupData'])
        ->name('sallaryTax.getSallaryGroupData');
    Route::get('/master/sallary-group-detail', [App\Http\Controllers\SallaryTaxController::class, 'getSallaryGroupDataDetail'])
        ->name('sallaryTax.getSallaryGroupDataDetail');
    Route::post('/master/sallary-group-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudSallaryGroup'])
        ->name('sallaryTax.CrudSallaryGroup');


    // Master Data - Membership Fees
    Route::get('/sallary-tax/membership-fees', [App\Http\Controllers\SallaryTaxController::class, 'membershipFees'])
        ->middleware('permission:sallaryTax.membershipFees')
        ->name('sallaryTax.membershipFees');
    Route::get('/master/membership-fees', [App\Http\Controllers\SallaryTaxController::class, 'getMembershipFeesData'])
        ->name('sallaryTax.getMembershipFeesData');
    Route::get('/master/membership-rate-detail', [App\Http\Controllers\SallaryTaxController::class, 'getMembershipFeesDataRate'])
        ->name('sallaryTax.getMembershipFeesDataRate');
    Route::post('/master/membership-fees-crud', [App\Http\Controllers\SallaryTaxController::class, 'CrudMembershipFees'])
        ->name('sallaryTax.CrudMembershipFees');
    Route::get('/master/membership-list', [App\Http\Controllers\SallaryTaxController::class, 'ListMemberhsipJson'])
        ->name('sallaryTax.ListMemberhsipJson');


    // Worktime - Work Time
    Route::get('/worktime/worktime-attendance-types', [App\Http\Controllers\WorkTimeController::class, 'AttendaceTypes'])
        ->middleware('permission:worktime.AttendaceTypes')
        ->name('worktime.AttendaceTypes');
    Route::get('/worktime/worktime-attendance-types-get', [App\Http\Controllers\WorkTimeController::class, 'getAttendaceTypesData'])
        ->name('worktime.getAttendaceTypesData');
    Route::post('/worktime/worktime-attendance-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudAttendaceTypes'])
        ->name('worktime.CrudAttendaceTypes');


    // Worktime - Shift Settings 
    Route::get('/worktime/worktime-shift-settings', [App\Http\Controllers\WorkTimeController::class, 'ShiftSettings'])
        ->middleware('permission:worktime.ShiftSettings')
        ->name('worktime.ShiftSettings');
    Route::get('/worktime/worktime-shift-group', [App\Http\Controllers\WorkTimeController::class, 'getShiftGroupData'])
        ->name('worktime.getShiftGroupData');
    Route::post('/worktime/worktime-shift-group-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudShiftGroup'])
        ->name('worktime.CrudShiftGroup');

    Route::get('/worktime/worktime-shift', [App\Http\Controllers\WorkTimeController::class, 'getShiftData'])
        ->name('worktime.getShiftData');
    Route::post('/worktime/worktime-shift-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudShift'])
        ->name('worktime.CrudShift');

    Route::get('/worktime/worktime-shift-pattern', [App\Http\Controllers\WorkTimeController::class, 'getShiftPatternData'])
        ->name('worktime.getShiftPatternData');
    Route::get('/worktime/worktime-shift-pattern-detail', [App\Http\Controllers\WorkTimeController::class, 'getShiftPatternDetailData'])
        ->name('worktime.getShiftPatternDetailData');

    Route::post('/worktime/worktime-shift-pattern-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudShiftPattern'])
        ->name('worktime.CrudShiftPattern');


    // Worktime - Overtime Settings
    Route::get('/worktime/worktime-overtime-settings', [App\Http\Controllers\WorkTimeController::class, 'OvertimeSettings'])
        ->middleware('permission:worktime.OvertimeSettings')
        ->name('worktime.OvertimeSettings');
    Route::get('/worktime/worktime-overtime-rule', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeRuleData'])
        ->name('worktime.getOvertimeRuleData');
    Route::get('/worktime/worktime-overtime-rate', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeRateData'])
        ->name('worktime.getOvertimeRateData');
    Route::post('/worktime/worktime-overtime-rule-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudOvertimeRule'])
        ->name('worktime.CrudOvertimeRule');

    Route::get('/worktime/worktime-overtime-group', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeGroupData'])
        ->name('worktime.getOvertimeGroupData');
    Route::get('/worktime/worktime-overtime-group-detail', [App\Http\Controllers\WorkTimeController::class, 'getOvertimeGroupDetailData'])
        ->name('worktime.getOvertimeGroupDetailData');
    Route::post('/worktime/worktime-overtime-group-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudOvertimeGroup'])
        ->name('worktime.CrudOvertimeGroup');


    // Worktime  - Work Calendar
    Route::get('/worktime/worktime-work-calendar', [App\Http\Controllers\WorkTimeController::class, 'WorkCalendar'])
        ->middleware('permission:worktime.WorkCalendar')
        ->name('worktime.WorkCalendar');
    Route::get('/worktime/worktime-work-calendar-data', [App\Http\Controllers\WorkTimeController::class, 'getWorkCalendarData'])
        ->name('worktime.getWorkCalendarData');
    Route::post('/worktime/worktime-work-calendar-crud', [App\Http\Controllers\WorkTimeController::class, 'CrudWorkCalendar'])
        ->name('worktime.CrudWorkCalendar');


    // Attendance - Shift Employee
    Route::get('/attendance/attendance-shift-employee', [App\Http\Controllers\AttendanceController::class, 'EmployeeShift'])
        ->middleware('permission:attendance.EmployeeShift')
        ->name('attendance.EmployeeShift');
    Route::get('/attendance/attendance-shift-employee-data', [App\Http\Controllers\AttendanceController::class, 'getEmployeeShiftData'])
        ->name('attendance.getEmployeeShiftData');
    Route::post('/worktime/worktime-employee-shift-crud', [App\Http\Controllers\AttendanceController::class, 'CrudEmployeeShift'])
        ->name('attendance.CrudEmployeeShift');

    // Attendance - Daily Attendance Employee
    Route::get('/attendance/attendance-employee', [App\Http\Controllers\AttendanceController::class, 'EmployeeAttendance'])
        ->middleware('permission:attendance.EmployeeAttendance')
        ->name('attendance.EmployeeAttendance');
    Route::get('/attendance/attendance-employee-data', [App\Http\Controllers\AttendanceController::class, 'getEmployeeAttendanceData'])
        ->name('attendance.getEmployeeAttendanceData');
    Route::get('/attendance/attendance-allowance-employee-data', [App\Http\Controllers\AttendanceController::class, 'getEmployeeAttendanceAllowanceData'])
        ->name('attendance.getEmployeeAttendanceAllowanceData');



    // Attendance - Schedule Employee
    Route::get('/attendance/schedule-employee', [App\Http\Controllers\AttendanceController::class, 'EmployeeSchedule'])
        ->middleware('permission:attendance.EmployeeSchedule')
        ->name('attendance.EmployeeSchedule');
    Route::get('/attendance/schedule-employee-data', [App\Http\Controllers\AttendanceController::class, 'EmployeeScheduleData'])
        ->name('attendance.EmployeeScheduleData');
    Route::post('/attendance/schedule-employee-data', [App\Http\Controllers\AttendanceController::class, 'GenerateSchedule'])
        ->name('attendance.GenerateSchedule');
    Route::post('/attendance/schedule-crud-ovveride', [App\Http\Controllers\AttendanceController::class, 'CrudOvveride'])
        ->name('attendance.CrudOvveride');
    Route::get('/attendance/schedule-shift-ovveride', [App\Http\Controllers\AttendanceController::class, 'ShiftOvverideData'])
        ->name('attendance.ShiftOvverideData');
    Route::get('/attendance/schedule--group-shift-by-date', [App\Http\Controllers\AttendanceController::class, 'ScheduleGroupByDate'])
        ->name('attendance.ScheduleGroupByDate');



    // EMPLOYEE - EMPLOYEE DATA
    Route::get('/employees/index', [App\Http\Controllers\EmployeeController::class, 'index'])
        ->middleware('permission:employees.index')
        ->name('employees.index');
    Route::get('/employees/employees-employee-data', [App\Http\Controllers\EmployeeController::class, 'getDataEmployee'])
        ->name('employees.getDataEmployee');
    Route::get('/employees/employees-employee-detail-data', [App\Http\Controllers\EmployeeController::class, 'getDetailEmployee'])
        ->name('employees.getDetailEmployee');
    Route::post('/employees/employees-crud', [App\Http\Controllers\EmployeeController::class, 'CrudEmployee'])
        ->name('employees.CrudEmployee');
    Route::get('/employees/employees-salary-join-date', [App\Http\Controllers\EmployeeController::class, 'getSalaryByJoinDate'])
        ->name('employees.getSalaryByJoinDate');

    // Employee - Import Employee
    Route::get('/employees/import-employee', [App\Http\Controllers\EmployeeController::class, 'importEmployee'])
        ->middleware('permission:employees.importEmployee')
        ->name('employees.importEmployee');
    Route::get('/employees/import-employee-format', [App\Http\Controllers\EmployeeController::class, 'downloadFormatEmployeeImport'])
        ->name('employees.import.downloadFormat');
    Route::post('/employees/submit-import-employee', [App\Http\Controllers\EmployeeController::class, 'submitImportNewEmployee'])
        ->name('employees.import.submit');



    // PAYROLL - SALARY MANUAL
    Route::get('/payroll/salary-manual', [App\Http\Controllers\PayrollController::class, 'SalaryManual'])
        ->middleware('permission:payroll.salary-manual')
        ->name('payroll.salary-manual');
    Route::post('/payroll/salary-import', [App\Http\Controllers\PayrollController::class, 'SalaryImport'])
        ->name('payroll.salary-import');
    Route::get('/payroll/salary-import-history', [App\Http\Controllers\PayrollController::class, 'getSalaryImportHistory'])
        ->name('payroll.getSalaryImportHistory');


    // PAYROLL - PROCESS PAYROLL
    Route::get('/payroll/process-payroll', [App\Http\Controllers\PayrollController::class, 'ProcessPayroll'])
        ->middleware('permission:payroll.process-payroll')
        ->name('payroll.process-payroll');
    Route::get('/payroll/process-payroll-data', [App\Http\Controllers\PayrollController::class, 'getPayrollProcessData'])
        ->name('payroll.getPayrollProcessData');
    Route::post('/payroll/process-payroll-crud', [App\Http\Controllers\PayrollController::class, 'CrudProcessPayroll'])
        ->name('payroll.CrudProcessPayroll');
    Route::post('/export', [App\Http\Controllers\PayrollController::class, 'export'])
        ->name('payroll.export');
    Route::get('/export-status/{id}', [App\Http\Controllers\PayrollController::class, 'exportStatus'])
        ->name('payroll.export.status');
    Route::post('/payroll/close-period', [App\Http\Controllers\PayrollController::class, 'closePayroll'])
        ->name('payroll.closePayroll');
    Route::get('/payroll/close-period-status', [App\Http\Controllers\PayrollController::class, 'checkPayrollStatus'])
        ->name('payroll.checkPayrollStatus');

    // SETTINGS -
    Route::get('/settings/icons', [App\Http\Controllers\SettingsController::class, 'DataIcons'])->name('settings.icons');
    Route::get('/settings/menu', [App\Http\Controllers\SettingsController::class, 'menu'])
        ->middleware('permission:settings.menu')
        ->name('settings.menu');
    Route::get('/settings/menu/data', [App\Http\Controllers\SettingsController::class, 'getDataMenu'])
        ->name('settings.getDataMenu');
    Route::post('/settings/menu-crud', [App\Http\Controllers\SettingsController::class, 'CrudMenu'])
        ->name('settings.CrudMenu');

    // ROLES 
    Route::get('/settings/roles', [App\Http\Controllers\SettingsController::class, 'roles'])
        ->middleware('permission:settings.roles')
        ->name('settings.roles');
    Route::get('/settings/roles/data', [App\Http\Controllers\SettingsController::class, 'getDataRoles'])
        ->name('settings.getDataRoles');
    Route::get('/settings/roles/menu-permissions', [App\Http\Controllers\SettingsController::class, 'MenuPermissions'])
        ->name('settings.MenuPermissions');
    Route::post('/settings/menu-crud', [App\Http\Controllers\SettingsController::class, 'CrudRoles'])
        ->name('settings.CrudRoles');


    // USERS
    Route::get('/settings/users', [App\Http\Controllers\SettingsController::class, 'users'])
        ->middleware('permission:settings.users')
        ->name('settings.users');
    Route::get('/settings/users/data', [App\Http\Controllers\SettingsController::class, 'getDataUsers'])
        ->name('settings.getDataUsers');
    Route::post('/settings/users-crud', [App\Http\Controllers\SettingsController::class, 'CrudUsers'])
        ->name('settings.CrudUsers');
});
