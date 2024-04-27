<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property string $latitude
 * @property string $longitude
 * @property string $geometric
 */
class Geofence extends Model
{
    use SoftDeletes;
}
