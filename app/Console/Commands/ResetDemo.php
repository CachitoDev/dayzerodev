<?php

namespace App\Console\Commands;

use App\Models\Citizen;
use Illuminate\Console\Command;

class ResetDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo "Deleting citizens";
        Citizen::query()->delete();
        echo "Citizens deleted";

    }
}