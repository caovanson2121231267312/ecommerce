<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Exports\MonthlyReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class MonthlyReportExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 4;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $file_name = 'report_' . Carbon::now()->format('Y-m-d:H-i-s') . '.xlsx';
        Excel::store(new MonthlyReportExport, $file_name, 'export');
    }
}
