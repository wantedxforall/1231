<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\Tiny;
use App\Helpers\Whatsapp;
use App\Models\front\plans;
use App\Models\front\stores;
use App\Models\front\invoices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckStoresExpireDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:expired';

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

    // public $amount;
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
        $stores = stores::where('status', 1)->whereNull('next_month_invoice_id')->get();
        $count = 0;
        foreach ($stores as $store) {
            $plan = plans::find($store->plan_id);
            $expiry = $store->expiry;
            $future_date = Carbon::createFromFormat('Y-m-d H:i:s', $expiry);
            $diff_in_days = $future_date->diffInDays(Carbon::now());
            if ($diff_in_days <= 5) {
                $invoice = invoices::create([
                    'hash' => bin2hex(random_bytes(16)),
                    'user_id' => $store->user_id,
                    'store_id' => $store->id,
                    'amount' => $plan->cost,
                    'status' => 0,
                    'is_cancel' => 0
                ]);
                $user = User::find($store->user_id);
                try {
                    Whatsapp::Invoice($user,$invoice);
                } catch (\Exception $e) {
                    Log::alert('message invoice failed');
                };
                $store->update(['next_month_invoice_id' => $invoice->id]);
                $count ++;
            }
        }
        Log::info([
            "stores" => count($stores),
            "invoice" => $count,
            "messages" => "Check Stores"]);
        echo count($stores) . ' Stores Done';
    }
}
