<?php

namespace App\Jobs;

use App\Models\TeamLeader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessCitizenImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected readonly string $filePath)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileContent = Storage::disk('s3')->get($this->filePath);
        $items = explode("\n", $fileContent);

        $lastTeamLeader = null;
        foreach ($items as $key => $item) {
            if ($key === 0) {
                continue;
            }
            $itemData = explode(',', $item);
            $teamLeaderName = $itemData[4];
            if (!empty($teamLeaderName)) {
                $lastTeamLeader = TeamLeader::store($teamLeaderName);
            }

            StoreCitizenFromCsvLine::dispatch($itemData, $lastTeamLeader);
        }
    }
}
