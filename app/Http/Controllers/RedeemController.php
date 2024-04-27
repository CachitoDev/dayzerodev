<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RedeemController extends Controller
{
    public function create()
    {
        return view('redeem.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'curp'          => ['required', 'string',, 'unique:citizens'],
            'latitude'      => ['required'],
            'longitude'     => ['required'],
            'capturedImage' => ['required', 'string']
        ],['curp' => 'Ya has canjeado un código']);

        $curp = $request->curp;
        $lat = $request->latitude;
        $long = $request->longitude;
        $nearbyStore = Store::whereCords($lat, $long)?->id;
        $path = 'images/' . Str::ulid() . '.png';
        Storage::disk('s3')->put($path, base64_decode($request->capturedImage));
        $citizen = Citizen::create([
            'curp'       => $curp,
            'image_path' => $path,
            'latitude'   => $lat,
            'longitude'  => $long,
            'store_id'   => $nearbyStore
        ]);

        return view('redeem.happy')->with('citizen', $citizen);
    }
}
