<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PayrollExport;
use App\Exports\PayrollRecapitulationExport;
use Maatwebsite\Excel\Facades\Excel;

class GeneratePayrollExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $exportId;

    public function __construct($exportId)
    {
        $this->exportId = $exportId;
    }

    public function handle(): void
    {
        $export = PayrollExport::find($this->exportId);

        try {

            $export->update([
                'status' => 'processing'
            ]);

            $fileName = 'payroll-recap-' . time() . '.xlsx';
            $filePath = 'exports/' . $fileName;

            Excel::store(
                new PayrollRecapitulationExport(
                    $export->period_id,
                    $export->company_id
                ),
                $filePath,
                'public'
            );

            $export->update([
                'status' => 'completed',
                'file_name' => $fileName,
                'file_path' => $filePath,
            ]);
        } catch (\Exception $e) {

            $export->update([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }
}
