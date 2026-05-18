<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeFormatForImport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'employee_code',
            'employee_name',
            'email',
            'phone',
            'gender',
            'join_date',
            'id_card',
            'npwp',
            'grade_name',
            'position_name',
            'working_name',
            'ptkp_code',
            'education_name',
            'bank_name',
            'account_name_bank',
            'account_number_bank',
            'organization_name',
            'company_name'
        ];
    }

    public function array(): array
    {
        return [
            [
                'EMP001',
                'DASEP DEPIYAWAN',
                'depiyawandasep13@gmail.com',
                '83821619460',
                'Male',
                '2025-12-01',
                '3217140000000000',
                '3217140000000000',
                'A1',
                'STAF',
                'PERMANENT',
                'K0',
                'SARJANA',
                'BANK BCA',
                'DASEP DEPIYAWAN',
                '0912982392127',
                'IT DEPARTMENT',
                'PT. DEVELOPER INDONESIA'
            ]
        ];
    }
}
