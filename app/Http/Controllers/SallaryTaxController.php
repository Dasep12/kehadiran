<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SallaryTaxController extends Controller
{
    // Master Data - Allowances
    public function allowances()
    {
        $data = [
            'title' => 'Allowances',
        ];
        return view('sallary-tax.allowances', $data);
    }

    public function getAllowancesData(Request $request)
    {
        $data = DB::table('mst_allowance_component')
            ->select(
                'id',
                'allowance_name',
                'allowance_code',
                'type',
                'calc_for',
                'daily',
                'is_tax',
                'is_actived',
                'is_gross',
                'is_membership',
                'created_at',
                'updated_at',
                'updated_by'
            );

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('allowance_name', 'like', '%' . $request->search . '%')
                ->orWhere('allowance_code', 'like', '%' . $request->search . '%');
        }


        if ($request->has('basicSalary') && !empty($request->basicSalary)) {
            $data = $data->where('basic_salary', 1);
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudAllowances(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            // 'id'            => $request->action == 'create' ? 'required|unique:mst_allowance_component,id' : 'required',
            'allowance_name'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'allowance_code'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'daily'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'is_tax'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'type'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'calc_for'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'is_actived'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'is_gross'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'is_membership'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'allowance_name' => $request->allowance_name,
            'allowance_code' => $request->allowance_code,
            'daily' => $request->daily,
            'is_tax' => $request->is_tax,
            'type' => $request->type,
            'calc_for' => $request->calc_for,
            'is_actived' => $request->is_actived,
            'is_gross' => $request->is_gross,
            'is_membership' => $request->is_membership,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    // $data['id'] = $request->id;
                    $data['created_at'] = now();
                    DB::table('mst_allowance_component')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_allowance_component')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    // Tambahkan pengecekan: Apakah posisi ini punya bawahan (children)?
                    // $hasChildren = DB::table('mst_employee_education')->where('education_id', $request->id)->exists();
                    // if ($hasChildren) {
                    //     throw new \Exception('Gagal menghapus! Posisi ini masih memiliki bawahan.');
                    // }

                    DB::table('mst_allowance_component')->where('id', $request->id)->delete();
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

    // end of Master Data - Allowances


    // Master Data - Allowance Position
    public function allowancePosition()
    {
        $data = [
            'title' => 'Allowance Position',
        ];
        return view('sallary-tax.allowances-position', $data);
    }

    public function getAllowancePositionData(Request $request)
    {
        $data = DB::table('vw_allowance_position as a')
            ->select(
                'a.id',
                'a.allowance_id',
                'a.allowance_name',
                'a.position_id',
                'a.position_name',
                'a.grade_id',
                'a.grade_name',
                'a.working_id',
                'a.working_name',
                'a.education_id',
                'a.education_name',
                'a.amount',
                'a.start_date',
                'a.is_daily',
                'a.end_date',
                'a.created_at',
                'a.created_by',
                'a.updated_at',
                'a.updated_by'
            );

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where(function ($query) use ($request) {
                $query->where('a.allowance_name', 'like', '%' . $request->search . '%')
                    ->orWhere('a.position_name', 'like', '%' . $request->search . '%')
                    ->orWhere('a.education_name', 'like', '%' . $request->search . '%');
            });
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudAllowancePosition(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'position_id' => $request->action != 'delete' ? 'required|exists:mst_position,id' : 'nullable',
            'grade_id' => $request->action != 'delete' ? 'required|exists:mst_grade,id' : 'nullable',
            'working_id' => $request->action != 'delete' ? 'required|exists:mst_working_status,id' : 'nullable',
            'education_id' => $request->action != 'delete' ? 'required|exists:mst_education,id' : 'nullable',
            'allowance_id' => $request->action != 'delete' ? 'required|exists:mst_allowance_component,id' : 'nullable',
            'amount' => $request->action != 'delete' ? 'required|numeric|min:0' : 'nullable',
            'start_date' => $request->action != 'delete' ? 'required|date' : 'nullable',
            // 'end_date' => $request->action != 'delete' ? 'required|date|after:start_date' : 'nullable',
            // Tambahkan validasi untuk field lainnya sesuai kebutuhan
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'position_id' => $request->position_id,
            'grade_id' => $request->grade_id,
            'working_id' => $request->working_id,
            'education_id' => $request->education_id,
            'allowance_id' => $request->allowance_id,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_daily' => $request->is_daily ?? 0,
            'created_by'    => auth()->id() ?? 'system',
            // Tambahkan field lainnya sesuai kebutuhan
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['id'] = $request->id;
                    $data['created_at'] = now();
                    DB::table('mst_allowance_position')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_allowance_position')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('mst_allowance_position')->where('id', $request->id)->delete();
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


    //Master Data - Pay Periods
    public function payPeriods()
    {
        $data = [
            'title' => 'Pay Periods',
        ];
        return view('sallary-tax.pay-periods', $data);
    }

    public function getPayPeriodsData(Request $request)
    {
        $data = DB::table('payroll_period')
            ->select(
                'period_id',
                'period_name',
                'start_date',
                'end_date',
                'pay_date',
                'is_closed',
                'is_proporsional_day',
                'created_at',
                'updated_at',
                'updated_by'
            );

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('period_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudPayPeriods(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'period_name' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'start_date' => $request->action != 'delete' ? 'required|date' : 'nullable',
            'end_date' => $request->action != 'delete' ? 'required|date|after:start_date' : 'nullable',
            'pay_date' => $request->action != 'delete' ? 'required|date|after:end_date' : 'nullable',
            // Tambahkan validasi untuk field lainnya sesuai kebutuhan
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'period_name' => $request->period_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'pay_date' => $request->pay_date,
            'is_closed' => $request->is_closed ?? 0,
            'created_by'    => auth()->id() ?? 'system',
            // Tambahkan field lainnya sesuai kebutuhan
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['period_id'] = $request->period_id;
                    $data['created_at'] = now();
                    DB::table('payroll_period')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('payroll_period')->where('period_id', $request->period_id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('payroll_period')->where('period_id', $request->period_id)->delete();
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
    // End of Master Data - Pay Periods

    // Master Data - Tax PTKP
    public function taxPTKP()
    {
        $data = [
            'title' => 'Tax PTKP',
        ];
        return view('sallary-tax.tax-ptkp', $data);
    }

    public function getTaxPTKPData(Request $request)
    {
        $data = DB::table('mst_tax_ptkp')
            ->select(
                'ptkp_code',
                'description',
                'amount',
                'effective_date',
                'end_date',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            );

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('ptkp_code', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudTaxPTKP(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'ptkp_code' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'description' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'amount' => $request->action != 'delete' ? 'required|numeric|min:0' : 'nullable',
            'effective_date' => $request->action != 'delete' ? 'required|date' : 'nullable',
            // 'end_date' => $request->action != 'delete' ? 'required|date|after:effective_date' : 'nullable',
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'ptkp_code' => $request->ptkp_code,
            'description' => $request->description,
            'amount' => $request->amount,
            'effective_date' => $request->effective_date,
            'end_date' => $request->end_date,
            'created_by'    => auth()->id() ?? 'system',
            // Tambahkan field lainnya sesuai kebutuhan
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    DB::table('mst_tax_ptkp')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_tax_ptkp')->where('ptkp_code', $request->ptkp_code)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('mst_tax_ptkp')->where('ptkp_code', $request->ptkp_code)->delete();
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
    // End of Master Data - Tax PTKP

    // Master Data - Tax Ter
    public function taxTer()
    {
        $data = [
            'title' => 'Tax Effective Rate (TER)',
        ];
        return view('sallary-tax.tax-ter', $data);
    }
    public function getTaxTerData(Request $request)
    {
        $data = DB::table('mst_tax_ter')
            ->select(
                'id',
                'ptkp_code',
                'min_salary',
                'max_salary',
                'rate',
                'effective_date',
                'end_date',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            );

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('description', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudTaxTER(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'ptkp_code' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'min_salary' => $request->action != 'delete' ? 'required|numeric|min:0' : 'nullable',
            'max_salary' => $request->action != 'delete' ? 'required|numeric|min:0|gte:min_salary' : 'nullable',
            'rate' => $request->action != 'delete' ? 'required|numeric|min:0|max:100' : 'nullable',
            'effective_date' => $request->action != 'delete' ? 'required|date' : 'nullable',
            'end_date' => $request->action != 'delete' ? 'date|after:effective_date' : 'nullable',
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'ptkp_code' => $request->ptkp_code,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'rate' => $request->rate,
            'effective_date' => $request->effective_date,
            'end_date' => $request->end_date,
            'created_by'    => auth()->id() ?? 'system',
            // Tambahkan field lainnya sesuai kebutuhan
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['id'] = $request->id;
                    DB::table('mst_tax_ter')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_tax_ter')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('mst_tax_ter')->where('id', $request->id)->delete();
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


    // End of Master Data - Tax Ter

    // Master Data - Tax Brackets
    public function taxBrackets()
    {
        $data = [
            'title' => 'Tax Brackets',
        ];
        return view('sallary-tax.tax-brackets', $data);
    }

    public function getTaxBracketsData(Request $request)
    {
        $data = DB::table('mst_tax_bracket')
            ->select(
                'id',
                'min_amount',
                'max_amount',
                'rate',
                'effective_date',
                'end_date',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            );

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('rate', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudTaxBrackets(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'min_amount' => $request->action != 'delete' ? 'required|numeric|min:0' : 'nullable',
            'max_amount' => $request->action != 'delete' ? 'required|numeric|min:0|gte:min_amount' : 'nullable',
            'rate' => $request->action != 'delete' ? 'required|numeric|min:0|max:100' : 'nullable',
            'effective_date' => $request->action != 'delete' ? 'required|date' : 'nullable',
            'end_date' => $request->action != 'delete' ? 'date|after:effective_date' : 'nullable',
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'rate' => $request->rate,
            'effective_date' => $request->effective_date,
            'end_date' => $request->end_date,
            'created_by'    => auth()->id() ?? 'system',
            // Tambahkan field lainnya sesuai kebutuhan
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['id'] = $request->id;
                    DB::table('mst_tax_bracket')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_tax_bracket')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('mst_tax_bracket')->where('id', $request->id)->delete();
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
    // End of Master Data - Tax Brackets

    // Master Data - Tax Settings
    public function taxSettings()
    {
        $data = [
            'title' => 'Tax Settings',
            'remark' => ''
        ];
        return view('sallary-tax.tax-settings', $data);
    }

    public function getTaxSettingsData(Request $request)
    {
        $data = DB::table('mst_tax_config')
            ->select(
                'config_code',
                'value',
                'description',
                'effective_date',
                'end_date',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            );
        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('setting_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudTaxSettings(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'config_code' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'value' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'description' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'effective_date' => $request->action != 'delete' ? 'required|date' : 'nullable',
            // 'end_date' => $request->action != 'delete' ? 'required|date|after:effective_date' : 'nullable',
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'config_code' => $request->config_code,
            'value' => $request->value,
            'description' => $request->description,
            'effective_date' => $request->effective_date,
            'end_date' => $request->end_date,
            'created_by'    => auth()->id() ?? 'system',
            // Tambahkan field lainnya sesuai kebutuhan
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    DB::table('mst_tax_config')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_tax_config')->where('config_code', $request->config_code)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('mst_tax_config')->where('config_code', $request->config_code)->delete();
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

    // End of Master Data - Tax Settings

    // Master Data Sallary Group
    public function sallaryGroup()
    {
        $data = [
            'title' => 'Sallary Gruop',
            'remark' => ''
        ];
        return view('sallary-tax.sallary-group', $data);
    }

    public function getSallaryGroupData(Request $request)
    {
        $data = DB::table('mst_basic_sallary_group')
            ->select(
                'group_id',
                'name_group',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            );
        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('name_group', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function getSallaryGroupDataDetail(Request $request)
    {
        $data = DB::table('mst_basic_sallary_group_detail')
            ->select(
                'group_id',
                'start_date',
                'end_date',
                'amount',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            )->where('group_id', $request->group_id);
        $data = $data->orderBy('start_date', 'desc')->get();
        return response()->json($data);
    }
    public function CrudSallaryGroup(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'group_id' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'name_group' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'group_id' => $request->group_id,
            'name_group' => $request->name_group,
            'created_by'    => auth()->id() ?? 'system',
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];


        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    DB::table('mst_basic_sallary_group')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_basic_sallary_group')->where('group_id', $request->group_id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('mst_basic_sallary_group')->where('group_id', $request->group_id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            // 🔥 Decode jika detail dikirim sebagai JSON string
            $detail = $request->detail;
            if (is_string($detail)) {
                $detail = json_decode($detail, true);
            }
            // 🔥 Proses detail hanya jika ada data
            if (!empty($detail) && is_array($detail)) {
                self::CrudSallaryGroupDetail($detail);
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    private function CrudSallaryGroupDetail(array $detail)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }

            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['group_id']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'group_id'   => $row['group_id'],
                'start_date' => $row['start_date'],
                'end_date'   => $row['end_date'] == ""  ? NULL : $row['end_date'],
                'amount'     => $row['amount']     ?? 0,
                'updated_by' => auth()->id()       ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_basic_sallary_group_detail')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_basic_sallary_group_detail')
                        ->where('group_id',   $row['group_id'])
                        ->where('start_date', $row['start_date'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_basic_sallary_group_detail')
                        ->where('group_id',   $row['group_id'])
                        ->where('start_date', $row['start_date'])
                        ->delete();
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    // End of Master Data - Sallary Group  

    // Master Data Sallary Group
    public function membershipFees()
    {
        $data = [
            'title' => 'Membership Fees',
            'remark' => ''
        ];
        return view('coredata.membership-fees', $data);
    }

    public function getMembershipFeesData(Request $request)
    {
        $data = DB::table('mst_membership as a')
            ->leftJoin('mst_allowance_component as b', 'b.id', 'a.membership_id')
            ->select(
                'b.allowance_name',
                'a.membership_id',
                'a.membership_code',
                'a.calculation_type',
                'a.base_type',
                'a.company_share',
                'a.employee_share',
                'a.is_active',
                'a.created_at',
                'a.created_by',
                'a.updated_at',
                'a.updated_by'
            );
        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('a.membership_code', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function getMembershipFeesDataRate(Request $request)
    {
        $data = DB::table('mst_membership_rate')
            ->select(
                'rate_id',
                'membership_id',
                'calculation_type',
                'value',
                'max_amount',
                'min_amount',
                'start_date',
                'end_date',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            )->where('membership_id', $request->membership_id);
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudMembershipFees(Request $request)
    {
        // Validasi
        $rules = [
            'action' => 'required|in:insert,update,delete,create',
            'membership_id' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'membership_code' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // Siapkan data untuk insert/update
        $data = [
            'membership_id' => $request->membership_id,
            'membership_code' => $request->membership_code,
            'calculation_type' => $request->calculation_type,
            'base_type' => $request->base_type,
            'employee_share' => $request->employee_share,
            'company_share' => $request->company_share,
            'is_active' => $request->is_active,
            'is_taxable' => $request->is_taxable,
            'created_by'    => auth()->id() ?? 'system',
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];


        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['created_at'] = now();
                    DB::table('mst_membership')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_membership')->where('membership_id', $request->membership_id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    DB::table('mst_membership')->where('membership_id', $request->membership_id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            // 🔥 Decode jika detail dikirim sebagai JSON string
            $detail = $request->detail;
            if (is_string($detail)) {
                $detail = json_decode($detail, true);
            }
            // 🔥 Proses detail hanya jika ada data
            if (!empty($detail) && is_array($detail)) {
                self::CrudMembershipFeesDetail($detail);
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    private function CrudMembershipFeesDetail(array $detail)
    {
        foreach ($detail as $row) {  // 🔥 Pakai foreach, hindari off-by-one

            // 🔥 Skip jika action null/kosong (row tidak diubah)
            $action = $row['action'] ?? null;
            if (empty($action)) {
                continue;
            }

            // 🔥 Validasi field wajib sebelum proses
            if (empty($row['membership_id']) || empty($row['start_date'])) {
                continue;
            }

            $data = [
                'membership_id'   => $row['membership_id'],
                'calculation_type'   => $row['calculation_type'],
                'value'     => $row['value'] ?? 0,
                'max_amount'     => $row['max_amount']  ?? 0,
                'min_amount'     => $row['min_amount']  ?? 0,
                'start_date' => $row['start_date'],
                'end_date'   => $row['end_date'] == ""  ? NULL : $row['end_date'],
                'updated_by' => auth()->id() ?? 'system',
                'updated_at' => now(),
            ];

            switch ($action) {
                case 'create':
                    $data['created_at'] = now();
                    $data['created_by'] = auth()->id() ?? 'system';
                    // 🔥 Hindari duplicate insert
                    DB::table('mst_membership_rate')
                        ->insertOrIgnore($data);
                    break;

                case 'update':
                    DB::table('mst_membership_rate')
                        ->where('rate_id',   $row['rate_id'])
                        ->update($data);
                    break;

                case 'delete':
                    DB::table('mst_membership_rate')
                        ->where('rate_id',   $row['rate_id'])
                        ->delete();
                    break;

                default:
                    // action tidak dikenal, skip
                    break;
            }
        }
    }

    public function ListMemberhsipJson()
    {
        $data =   DB::table('mst_allowance_component')
            ->select('id', 'allowance_name', 'is_tax', 'calc_for', 'allowance_code')
            ->where('is_membership', 1)->get();
        return response()->json($data);
    }
}
