<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Store;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storesWithCitizensCount = Store::withCount('citizens')->get();

        $storesData = [];

        foreach ($storesWithCitizensCount as $store) {
            $estimated = $store->estimated;
            $citizensCount = $store->citizens_count;

            $verifiedCitizensCount = Citizen::where('store_id', $store->id)
                ->where('verified', true)
                ->count();

            $storeData = [
                'number' => $store->number,
                'name' => $store->name,
                'estimated' => $estimated,
                'citizens_count' => $citizensCount,
                'verified' => $verifiedCitizensCount,
            ];

            $storesData[] = $storeData;
        }

        return view('statistics.index', ['storesData' => $storesData]);
    }
}
