<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $coordinates = Citizen::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select(['latitude', 'longitude'])
            ->get()
            ->map(fn($item) => [$item->latitude, $item->longitude])
            ->toArray();

        return view('dashboard.index')
            ->with('coordinates', $coordinates);
    }
}
