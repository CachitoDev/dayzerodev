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
                'id'             => $store->id,
                'number'         => $store->number,
                'name'           => $store->name,
                'estimated'      => $estimated,
                'citizens_count' => $citizensCount,
                'verified'       => $verifiedCitizensCount,
            ];

            $storesData[] = $storeData;
        }

        return view('statistics.index', ['storesData' => $storesData]);
    }

    public function charts()
    {
        $citizensByLeader = Citizen::query()
            ->selectRaw('team_leader_id,count(*) as count')
            ->with('teamLeader')
            ->groupBy('team_leader_id')
            ->get();

        $citizensByLeaderChart = [
            'labels'   => $citizensByLeader->pluck('teamLeader.name'),
            'data' => $citizensByLeader->pluck('count'),
        ];


        return view('statistics.charts')
            ->with('citizensByLeaderChart', $citizensByLeaderChart);
    }
}
