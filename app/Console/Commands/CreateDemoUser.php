<?php

namespace App\Console\Commands;

use Database\Seeders\DefaultUserSeeder;
use Illuminate\Console\Command;

class CreateDemoUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $seed = new DefaultUserSeeder();
        $seed->run();
    }
}
