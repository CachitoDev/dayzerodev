<?php

namespace App\Console\Commands;

use App\Models\Citizen;
use App\Models\Store;
use App\Models\TeamLeader;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DemoFill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:fill';

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
        $stores = Store::query()->get();

        $existingCitizens = Citizen::query()->get();
        $leaders = TeamLeader::query()
            ->whereIn('id', [62, 63])
            ->get();

        $finalCitizens = [];
        for ($i = 0; $i < 500; $i++) {
            $store = $stores->random(1)->first();
            $existing = $existingCitizens->random(1)->first();
            $leader = $leaders->random(1)->first();
            $data = [
                'curp'           => Str::ulid(),
                'image_path'     => $existing->image_path,
                'latitude'       => $store->latitude,
                'longitude'      => $store->longitude,
                'store_id'       => $store->id,
                'team_leader_id' => $leader->id
            ];
            $finalCitizens[] = $data;
        }
        echo "Inserting citizens\n";
        Citizen::query()->insert($finalCitizens);
        echo "Citizens inserted\n";
    }
}
