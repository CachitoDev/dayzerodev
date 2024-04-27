<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property string $name
 * @property string $latitude
 * @property string $longitude
 * @property string|null $geo
 * @property int $estimated
 * @property double $radius
 */
class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'latitude', 'longitude', 'geo', 'radius', 'estimated'];

    /**
     *
     */
    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }

    /**
     * Generate the geometry of the store.
     *
     * @return void
     */
    public function generateGeometry()
    {
        $latitude = $this->latitude;
        $longitude = $this->longitude;
        $bufferDistanceMeters = $this->radius;
        $bufferDistanceDegrees = $bufferDistanceMeters / (2 * 6378137 * pi() / 360);
        DB::statement("UPDATE stores SET geo = ST_SetSRID(ST_Multi(ST_Buffer(ST_SetSRID(ST_MakePoint($longitude, $latitude), 4326), $bufferDistanceDegrees)), 900913) WHERE id=" . $this->id . ";");
    }
}
