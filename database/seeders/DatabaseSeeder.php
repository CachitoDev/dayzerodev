<?php

namespace Database\Seeders;

use App\Models\Citizen;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CitizenSeeder::class,
        ]);
    }
}
