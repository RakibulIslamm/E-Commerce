<?php

namespace App\Http\Controllers\App\Options;

use App\Models\Location;
use App\Models\AvailableLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LimitByLocationController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $locations = Location::all();
        $locations = AvailableLocation::with('location')->get();
        return view("app.pages.options.limitations-for-cap.index", ["available_locations" => $locations]);
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
    
    public function get_limitation_cap(Request $request)
    {
        try {
            $locations = AvailableLocation::all();
            return response()->json([
                'status' => 'success',
                'locations' => $locations
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'locations' => 'required|array',
            'locations.*.location_id' => 'required|string',
            'locations.*.postal_code' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status'=>'error',
                'message' => $validator->errors()->first(),
                'code' => 400,
            ]);
        }

        try {
            $locationsData = $request->input('locations');
            $createdLocations = [];
            foreach ($locationsData as $data) {
                $caps = AvailableLocation::create($data);
                $createdLocations[] = $caps;
            }

            return response()->json([
                'message' => 'Available locations added successfully',
                'locations' => $createdLocations,
                'code' => 201,
                'status' => 'success',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "code" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
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
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(AvailableLocation $availableLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AvailableLocation $availableLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AvailableLocation $availableLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvailableLocation $availableLocation)
    {
        $availableLocation->delete();
        return redirect()->back()->with('success', "Deleted successfully");
    }
}
