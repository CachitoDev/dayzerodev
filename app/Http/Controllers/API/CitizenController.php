<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;

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
            return response()->json(['registered' => true]);
        } else {
            return response()->json(['registered' => false]);
        }
    }

    /**
     *
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'curp' => ['required', 'unique:citizens'],
            'image_path' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $citizen = Citizen::create([
            'curp' => $request->curp,
            'image_path' => $request->image_path,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json($citizen, 201);
    }
}
