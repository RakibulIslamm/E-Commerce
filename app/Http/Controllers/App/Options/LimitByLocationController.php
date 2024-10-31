<?php

namespace App\Http\Controllers\App\Options;

use App\Models\Location;
use App\Models\RestrictedLocation;
use Illuminate\Http\Request;

class LimitByLocationController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return view("app.pages.options.limitations-for-cap.index", ["locations" => $locations]);
    }

    public function get_locations(Request $request)
    {
        $searchText = $request->query('search', '');
        // dd($searchText);
        $locations = Location::where(function ($query) use ($searchText) {
            $query->where('place', 'like', '%' . $searchText . '%')
                ->orWhere('zipcode', 'like', '%' . $searchText . '%');
        })->get();

        return response()->json([
            'success' => true,
            'locations' => $locations
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RestrictedLocation $restrictedLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestrictedLocation $restrictedLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RestrictedLocation $restrictedLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestrictedLocation $restrictedLocation)
    {
        //
    }
}
