<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeamLeader extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'curp', 'phone'];

    /**
     *
     */
    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }



    /**
     * Store a new team leader.
     *
     * @param string $name
     * @param string|null $curp
     * @param string|null $phone
     * @return TeamLeader
     */
    public static function store(string $name, string $curp = null, string $phone = null): TeamLeader
    {
        $name = Str::upper($name);
        return TeamLeader::firstOrCreate([
            'name' => $name,
        ], [
            'curp'  => $curp,
            'phone' => $phone,
        ]);
    }
}
