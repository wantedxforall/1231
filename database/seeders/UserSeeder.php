<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Providers;
use App\Models\front\plans;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Admin',
            'last_name' => 'Admin',
            'phone' => '201068973658',
            'country' => 'EG',
            'email' => 'admin@app.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);
        // User::factory(10)->create();

    }
}
