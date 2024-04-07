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

        Citizen::factory(100)->jardinPrincipal()->create();
        Citizen::factory(100)->estadio()->create();
        Citizen::factory(100)->parqueFundadores()->create();
        Citizen::factory(100)->deportivaNorte()->create();
        Citizen::factory(100)->xochipilli()->create();
    }
}
