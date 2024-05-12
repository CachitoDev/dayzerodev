<?php

namespace App\Imports;

use App\Models\Store;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StoreImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Store([
            'number' => $row['number'],
            'name' => $row['name'],
            'latitude' => $row['lat'],
            'longitude' => $row['long'],
            'radius' => $row['radius'],
            'estimated' => $row['estimated'],
        ]);
    }
}
