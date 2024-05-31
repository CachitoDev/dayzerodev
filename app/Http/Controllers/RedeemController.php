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


    public function reedem2(Request $request)
    {
        $citizen = Citizen::query()->where('id', $request->folio)->orWhere('folio', $request->folio)->first();
        if (!$citizen instanceof Citizen) {
            return redirect()->back()->with('error', 'No se encontró el folio');
        }
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        if ($citizen->store instanceof Store) {
            $latitude = $citizen->store->latitude;
            $longitude = $citizen->store->longitude;
        }

        $path = 'images/' . Str::ulid() . '.png';
        $image = str_replace('data:image/png;base64,', '', $request->capturedImage);
        Storage::disk('s3')->put($path, base64_decode($image));
        $citizen->update([
            'image_path' => $path,
            'latitude'   => $latitude,
            'longitude'  => $longitude,
        ]);
        return view('redeem.happy')->with('citizen', $citizen);
    }

    public function store(Request $request)
    {
        return $this->reedem2($request);//TODO: this is only a workaround.
        $this->validate($request, [
            'curp'          => ['required', 'string', 'unique:citizens'],
            'latitude'      => ['required'],
            'longitude'     => ['required'],
            'capturedImage' => ['required', 'string']
        ], ['curp' => 'Ya has canjeado un código']);

        $curp = $request->curp;
        $lat = $request->latitude;
        $long = $request->longitude;
        $nearbyStore = Store::whereCords($lat, $long)?->id;
        $path = 'images/' . Str::ulid() . '.png';

        $image = str_replace('data:image/png;base64,', '', $request->capturedImage);
        Storage::disk('s3')->put($path, base64_decode($image));
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
