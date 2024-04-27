<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidatedSearchRequest;
use App\Models\Citizen;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ValidatedSearchRequest $request)
    {
        $search = $request->search;

        $citizens = Citizen::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('id', $search);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('citizen.index', ['citizens' => $citizens]);
    }

    /**
     *
     */
    public function verifiedCitizen(Citizen $citizen)
    {
        $citizen->update(['verified' => true]);

        return redirect()->back();
    }
}
