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

        $teamLeaderId = null;

        if (!empty($row['team_leader'])) {
            $teamLeader = TeamLeader::firstOrCreate(
                ['name' => $row['team_leader']]
            );

            $teamLeaderId = $teamLeader->id;
        }

        $nameParts = explode(' ', $row['name']);
        $initials = '';

        foreach ($nameParts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }

        $newFolioNumber = strtoupper(substr(md5(uniqid()), 0, 4));

        $newFolio = $initials . $newFolioNumber;

        return new Citizen([
            'name' => $row['name'],
            'folio' => $newFolio,
            'curp' => $row['curp'],
            'phone' => $row['phone'],
            'store_id' => $store_id,
            'team_leader_id' => $teamLeaderId,
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
