<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CitizenRegisterRequest;
use App\Models\Citizen;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CitizenController extends Controller
{
    /**
     *
     */
    public function check(Request $request)
    {
        $search = $request->input('curp');

        $citizen = Citizen::where('folio', $search)->orWhere('curp', $search)->first();

        if (is_null($citizen)) {
            return response()->json(['status' => true, 'message' => 'Felicidades, tienes un cupón de descuento para canjear.']);
        } elseif ($citizen->folio === $search) {
            return response()->json(['status' => true, 'message' => 'Folio Valido.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Ya has canjeado tu cupón de descuento.']);
        }
    }

    /**
     *
     */
    public function register(CitizenRegisterRequest $request)
    {
        $curp = $request->curp;
        $lat = $request->latitude;
        $long = $request->longitude;

        $nearbyStore = Store::whereCords($lat, $long)?->id;
        $path = 'images/' . Str::ulid() . '.png';
        Storage::disk('s3')->put($path, base64_decode($request->image_path));
        $citizen = Citizen::create([
            'curp'       => $curp,
            'image_path' => $path,
            'latitude'   => $lat,
            'longitude'  => $long,
            'store_id'   => $nearbyStore
        ]);

        return response()->json($citizen, 201);
    }
}
