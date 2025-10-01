<?php

namespace App\Jobs;

use App\Models\front\stores;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class RenewSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $store;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(stores $store)
    {
        $this->store = $store;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->store->update([
            'expiry' => Carbon::now()->addDays(30),
            'status' => 1,
            'next_month_invoice_id' => null,
        ]);
    }
}
