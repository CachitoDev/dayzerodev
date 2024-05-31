<?php

namespace App\Jobs;

use App\Models\Citizen;
use App\Models\Store;
use App\Models\TeamLeader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoreCitizenFromCsvLine implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected readonly array $csvData, protected readonly TeamLeader $teamLeader)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $name = $this->csvData[1] ?? null;
        if (empty($name)) {
            Log::alert('Data empty', ['csvData' => $this->csvData, 'teamLeader' => $this->teamLeader->name]);
            return;
        }

        $name = Str::upper($this->csvData[1]);
        $phone = $this->csvData[2] ?? '';
        $storeNumber = $this->csvData[3] ?? null;

        $store = Store::where('number', $storeNumber)->first();
        if (!$store instanceof Store) {
            Log::alert('Store not found', ['citizen' => $name, 'storeNumber' => $storeNumber]);
        }

        Citizen::create([
            'name'           => $name,
            'folio'          => Citizen::generateCustomSlug($name),
            'curp'           => Str::uuid(),
            'phone'          => $phone,
            'store_id'       => $store?->id,
            'team_leader_id' => $this->teamLeader->id,
        ]);
    }
}
