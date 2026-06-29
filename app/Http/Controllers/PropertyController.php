<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HOME PAGE
    |--------------------------------------------------------------------------
    */

    public function home()
    {
        $properties = Property::latest()
            ->take(4)
            ->get();

        return view('home', compact('properties'));
    }

    /*
    |--------------------------------------------------------------------------
    | LIST PROPERTY
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Property::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH PROPERTY
        |--------------------------------------------------------------------------
        */

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->keyword . '%')
                  ->orWhere('location', 'LIKE', '%' . $request->keyword . '%')
                  ->orWhere('property_type', 'LIKE', '%' . $request->keyword . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER CITY
        |--------------------------------------------------------------------------
        */

        if ($request->filled('city')) {
            $query->where('location', 'LIKE', '%' . $request->city . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER MAX PRICE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER PROPERTY TYPE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        | 10 Property per halaman
        | Layout View = 5 kolom x 2 baris
        */

        // HAPUS ->withCount('favorites') DI SINI
        $properties = $query
            ->latest()
            ->paginate(10);

        return view('properties.index', compact('properties'));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PROPERTY
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $property = Property::findOrFail($id);

        return view('properties.show', compact('property'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE PROPERTY
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('properties.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PROPERTY
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'building_area' => 'required|numeric',
            'land_area' => 'nullable|numeric',
            'distance_to_center' => 'nullable|numeric',
            'facility_score' => 'nullable|integer|min:1|max:5',
            'facility_details' => 'nullable|string',
            'security_score' => 'nullable|integer|min:1|max:5',
            'security_details' => 'nullable|string',
            'condition_score' => 'nullable|integer|min:0|max:100',
            'grade_score' => 'nullable|integer|min:0|max:100',
            'certificate_type' => 'nullable|in:SHM,SHGB,Lainnya',
            'property_type' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        Property::create($validated);

        return redirect('/properties')
            ->with('success', 'Property berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PROPERTY
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $property = Property::findOrFail($id);

        return view('properties.edit', compact('property'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PROPERTY
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'building_area' => 'required|numeric',
            'land_area' => 'nullable|numeric',
            'distance_to_center' => 'nullable|numeric',
            'facility_score' => 'nullable|integer|min:1|max:5',
            'facility_details' => 'nullable|string',
            'security_score' => 'nullable|integer|min:1|max:5',
            'security_details' => 'nullable|string',
            'condition_score' => 'nullable|integer|min:0|max:100',
            'grade_score' => 'nullable|integer|min:0|max:100',
            'certificate_type' => 'nullable|in:SHM,SHGB,Lainnya',
            'property_type' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        $property->update($validated);

        return redirect('/properties')
            ->with('success', 'Property berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY PROPERTY
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect('/properties')
            ->with('success', 'Property berhasil dihapus');
    }
}