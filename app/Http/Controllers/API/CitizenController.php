<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CitizenController extends Controller
{
    /**
     *
     */
    public function check(Request $request)
    {
        $curp = $request->input('curp');
        $citizen = Citizen::where('curp', $curp)->first();

        if ($citizen) {
            return response()->json(['status' => false,'message' => 'Ya has canjeado tu cupón de descuento.']);
        } else {
            return response()->json(['status' => true,'message' => 'Felicidades, tienes un cupón de descuento para canjear.']);
        }
    }

    /**
     *
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude'   => 'required',
            'curp'       => ['required', 'unique:citizens'],
            'image_path' => 'required',
            'longitude'  => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        Http::acceptJson()->post('https://webhook.site/3a2ccd34-f7f0-48ec-8b64-e7424f2d1ce6',$request->toArray());

        $citizen = Citizen::create([
            'curp'       => $request->curp,
            'image_path' => 'imagepath',//$request->image_path,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
        ]);

        return response()->json($citizen, 201);
    }
}
