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


// Master Coredata Routes
Route::get('/coredata/education', [App\Http\Controllers\CoreDataController::class, 'education'])->name('coredata.education');
Route::get('/master/education', [App\Http\Controllers\CoreDataController::class, 'getEducationData'])->name('coredata.getEducationData');
Route::get('/coredata/work-status', [App\Http\Controllers\CoreDataController::class, 'workStatus'])->name('coredata.workStatus');
Route::get('/master/work-status', [App\Http\Controllers\CoreDataController::class, 'getWorkStatusData'])->name('coredata.getWorkStatusData');
Route::get('/coredata/position', [App\Http\Controllers\CoreDataController::class, 'position'])->name('coredata.position');
Route::get('/master/position-employee', [App\Http\Controllers\CoreDataController::class, 'getPositionEmployee'])->name('coredata.getPositionEmployee');
Route::post('/master/position-crud', [App\Http\Controllers\CoreDataController::class, 'CrudPosition'])->name('coredata.CrudPosition');

Route::get('/coredata/positionTree', [App\Http\Controllers\CoreDataController::class, 'getTreePosition'])->name('coredata.positionTree');
Route::get('/coredata/positionTreeDetail', [App\Http\Controllers\CoreDataController::class, 'getTreePositionDetail'])->name('coredata.positionTreeDetail');


Route::get('/master/position', [App\Http\Controllers\CoreDataController::class, 'getPositionData'])->name('coredata.getPositionData');
Route::get('/coredata/job-grade', [App\Http\Controllers\CoreDataController::class, 'jobGrade'])->name('coredata.jobGrade');
Route::get('/master/job-grade', [App\Http\Controllers\CoreDataController::class, 'getJobGradeData'])->name('coredata.getJobGradeData');



// Master Sallary Tax Routes
Route::get('/sallary-tax/allowances', [App\Http\Controllers\SallaryTaxController::class, 'allowances'])->name('sallaryTax.allowances');
Route::get('/master/allowances', [App\Http\Controllers\SallaryTaxController::class, 'getAllowancesData'])->name('sallaryTax.getAllowancesData');
Route::get('/sallary-tax/pay-periods', [App\Http\Controllers\SallaryTaxController::class, 'payPeriods'])->name('sallaryTax.payPeriods');
Route::get('/master/pay-periods', [App\Http\Controllers\SallaryTaxController::class, 'getPayPeriodsData'])->name('sallaryTax.getPayPeriodsData');
Route::get('/sallary-tax/tax-ptkp', [App\Http\Controllers\SallaryTaxController::class, 'taxPtkp'])->name('sallaryTax.taxPtkp');
Route::get('/master/tax-ptkp', [App\Http\Controllers\SallaryTaxController::class, 'getTaxPtkpData'])->name('sallaryTax.getTaxPtkpData');
Route::get('/sallary-tax/tax-ter', [App\Http\Controllers\SallaryTaxController::class, 'taxTer'])->name('sallaryTax.taxTer');
Route::get('/master/tax-ter', [App\Http\Controllers\SallaryTaxController::class, 'getTaxTerData'])->name('sallaryTax.getTaxTerData');
Route::get('/sallary-tax/tax-brackets', [App\Http\Controllers\SallaryTaxController::class, 'taxBrackets'])->name('sallaryTax.taxBrackets');
Route::get('/master/tax-brackets', [App\Http\Controllers\SallaryTaxController::class, 'getTaxBracketsData'])->name('sallaryTax.getTaxBracketsData');
Route::get('/sallary-tax/tax-settings', [App\Http\Controllers\SallaryTaxController::class, 'taxSettings'])->name('sallaryTax.taxSettings');


Route::get('/sallary-tax/sallary-group', [App\Http\Controllers\SallaryTaxController::class, 'sallaryGroup'])->name('sallaryTax.sallaryGroup');
Route::get('/master/sallary-group', [App\Http\Controllers\SallaryTaxController::class, 'getSallaryGroupData'])->name('sallaryTax.getSallaryGroupData');
Route::get('/master/sallary-group-detail', [App\Http\Controllers\SallaryTaxController::class, 'getSallaryGroupDataDetail'])->name('sallaryTax.getSallaryGroupDataDetail');

Route::get('/sallary-tax/membership-fees', [App\Http\Controllers\SallaryTaxController::class, 'membershipFees'])->name('sallaryTax.membershipFees');
Route::get('/master/membership-fees', [App\Http\Controllers\SallaryTaxController::class, 'getMembershipFeesData'])->name('sallaryTax.getMembershipFeesData');
Route::get('/master/membership-rate-detail', [App\Http\Controllers\SallaryTaxController::class, 'getMembershipFeesDataRate'])->name('sallaryTax.getMembershipFeesDataRate');
