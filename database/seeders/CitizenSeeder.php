<?php

namespace Database\Seeders;

use App\Models\Citizen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitizenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Citizen::factory(500)->create();

        Citizen::factory(100)->coordinates1()->create();
        Citizen::factory(100)->coordinates2()->create();
        Citizen::factory(100)->coordinates3()->create();
        Citizen::factory(100)->coordinates4()->create();
        Citizen::factory(100)->coordinates5()->create();
    }
}
