<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'folio', 'curp', 'phone', 'image_path', 'latitude', 'longitude', 'store_id', 'team_leader_id', 'verified'
    ];

    /**
     *
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     *
     */
    public function teamLeader()
    {
        return $this->belongsTo(TeamLeader::class);
    }

    public function getImageUrl(): string
    {
        return "";
        return Storage::disk('s3')->temporaryUrl($this->image_path, now()->addMinutes(5));
    }

    /**
     * Generate custom slug.
     *
     * @param $name
     * @return string
     */
    public static function generateCustomSlug($name): string
    {
        $nameParts = explode(' ', $name);
        $initials = '';

        foreach ($nameParts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }

        $newFolioNumber = strtoupper(substr(md5(uniqid()), 0, 4));

        return $initials . $newFolioNumber;
    }
}
