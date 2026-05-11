<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollRecapitulationExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($periodId, $companyId)
    {
        $this->data = collect(
            DB::select(
                "CALL sp_payroll_recapitulation(?, ?)",
                [$periodId, $companyId]
            )
        );
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        if ($this->data->isEmpty()) {
            return [];
        }

        return array_keys((array) $this->data->first());
    }
}
