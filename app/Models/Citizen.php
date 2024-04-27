<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'curp', 'image_path', 'latitude', 'longitude', 'store_id', 'verified'
    ];

    /**
     *
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function getImageUrl(): string
    {
        return Storage::disk('s3')->temporaryUrl($this->image_path, now()->addMinutes(5));
    }
}
