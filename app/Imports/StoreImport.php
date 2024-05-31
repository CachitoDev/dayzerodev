<?php

namespace App\Imports;

use App\Models\Store;
use Illuminate\Support\Str;
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
        $coordinates = $row['cordenadas'] ?? $row['coordenadas'] ?? null;
        if (!empty($coordinates)) {
            $coordinates = explode(',', $coordinates);
            $lat = trim($coordinates[0]);
            $long = trim($coordinates[1]);
        } else {
            $lat = $row['lat'] ?? null;
            $long = $row['long'] ?? null;
        }
        $name = $row['number'] ?? $row['nombre'];

        if (empty($name)) {
            return null;
        }


        return new Store([
            'number'    => $name,
            'name'      => $row['name'] ?? $row['nombre'],
            'latitude'  => $lat,
            'longitude' => $long,
            'radius'    => $row['radius'] ?? 5,
            'estimated' => $row['estimated'] ?? $row['total'],
        ]);
    }
}
