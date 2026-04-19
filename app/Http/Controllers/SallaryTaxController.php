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
                'daily',
                'is_tax',
                'type',
                'calc_for',
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
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }
    // end of Master Data - Allowances


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
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
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
}
