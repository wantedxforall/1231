<?php

namespace App\Console\Commands;

use App\Helpers\Tiny;
use App\Models\CurrencyRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency rates from an external API';

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
        try {
            $response = Http::post('https://p2p.binance.com/bapi/c2c/v2/friendly/c2c/adv/search', [
                'fiat' => 'EGP',
                'page' => 1,
                'rows' => 1,
                'tradeType' => 'BUY',
                'asset' => 'USDT',
                'countries' => ['EG'],
                'proMerchantAds' => false,
                'shieldMerchantAds' => false,
                'filterType' => 'all',
                'additionalKycVerifyFilter' => 0,
                'publisherType' => null,
                'payTypes' => ['Vodafonecash'],
                'classifies' => ['mass', 'profession']
            ]);
            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['data'][0]['adv']['price'])) {
                    $newRate = $responseData['data'][0]['adv']['price'];
                    Tiny::option('usdt_rate', $newRate);
                    $this->info('Currency rates updated successfully.');
                } else {
                    $this->error('Invalid data format: Unable to update currency rates.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Error updating currency rates: ' . $e->getMessage());
            $this->error('An error occurred while updating currency rates. Please try again later.');
        }

        try {
            $url = "https://www.alexbank.com/digitalServicesServlet/?operation=latestExchangeRatesCashless&httpMethod=GET&endpointName=latestExchangeRatesCashless&headers=standardHeaders&bank=ALEX&bankId=ALEX&locale=en";
            $response = Http::get($url);
            $data = $response->json();

            if(isset($data['rates'])) {

                foreach($data['rates'] as $rate) {
                    if($rate['fromCurrency']['code'] === '818' && $rate['toCurrency']['code'] === '840') {
                        // Found USD to EGP rate
                        $usdBuyRate = $rate['buyRate']['rate'];
                        Tiny::option('usd_rate', $usdBuyRate);
                        $this->info('USD to EGP exchange rate updated successfully.');
                        break; // No need to continue once we find the USD rate
                    }
                }
            } else {
                $this->error('Invalid data format: Unable to update currency rates.');
            }
        } catch (\Exception $e) {
            Log::error('Error updating currency rates: ' . $e->getMessage());
            $this->error('An error occurred while updating currency rates. Please try again later.');
        }
    }
}
