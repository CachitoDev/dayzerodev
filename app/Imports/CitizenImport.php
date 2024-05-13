<?php

namespace App\Imports;

use App\Models\Citizen;
use App\Models\Store;
use App\Models\TeamLeader;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CitizenImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading

{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $store = Store::where('number', $row['store'])->first();
        $store_id = $store ? $store->id : null;

        $teamLeader = TeamLeader::where('name', $row['team_leader'])->first();
        $team_leader_id = $teamLeader ? $teamLeader->id : null;

        return new Citizen([
            'name' => $row['name'],
            'curp' => $row['curp'],
            'phone' => $row['phone'],
            'store_id' => $store_id,
            'team_leader_id' => $team_leader_id,
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
