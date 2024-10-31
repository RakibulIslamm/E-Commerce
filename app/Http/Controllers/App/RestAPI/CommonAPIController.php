<?php

namespace App\Http\Controllers\App\RestAPI;

use App\Models\Location;

class CommonAPIController
{
    public function get_location($zip_code)
    {
        try {
            $location = Location::where('zipcode', $zip_code)->get();
            return response()->json(['success' => true, 'locations' => $location]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
