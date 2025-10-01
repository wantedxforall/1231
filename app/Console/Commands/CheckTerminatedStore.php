<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\front\stores;
use App\Models\front\invoices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckTerminatedStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:terminated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stores = stores::where('status', 1)->get();
        $terminatedCount = 0;

        foreach ($stores as $store) {
            $expiry = $store->expiry;
            $future_date = Carbon::createFromFormat('Y-m-d H:i:s', $expiry);
            $diff_in_days = $future_date->diffInDays(Carbon::now());
            if ($diff_in_days == 1) {
                $invoice = invoices::find($store->next_month_invoice_id);
                if ($invoice) {
                    if ($invoice->status != 1) {
                        $store->update(['status' => 3]);
                        Log::info([
                            'Status' => 'Terminated',
                            'Store' => $store->domain,
                        ]);
                        $terminatedCount++;
                    }
                }
            }
        }
        echo $terminatedCount . ' Stores Terminated';

    }
}
