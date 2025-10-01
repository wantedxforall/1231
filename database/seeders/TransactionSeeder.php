<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\front\transactions;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        transactions::factory(20)->create();
    }
}
