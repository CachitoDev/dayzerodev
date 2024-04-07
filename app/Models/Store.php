<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'latitude', 'longitude', 'geo'];

    /**
     *
     */
    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }
}
