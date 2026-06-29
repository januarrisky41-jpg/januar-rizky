<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProperties =
            Property::count();

        $totalCities =
            Property::distinct('location')
            ->count('location');

        $averagePrice =
            Property::avg('price');

        $minPrice =
            Property::min('price');

        $maxPrice =
            Property::max('price');

        $latestProperties =
            Property::latest()
            ->take(5)
            ->get();

        $cityStatistics =
            Property::select(
                'location',
                DB::raw('count(*) as total')
            )
            ->groupBy('location')
            ->orderByDesc('total')
            ->get();

        return view(
            'dashboard.index',
            compact(
                'totalProperties',
                'totalCities',
                'averagePrice',
                'minPrice',
                'maxPrice',
                'latestProperties',
                'cityStatistics'
            )
        );
    }
}