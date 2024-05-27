<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Models\Tenant;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // if (!auth()->user()) abort(404);

        $tenant = tenant();
        if(!$tenant) abort(404);
        $this->matchDomain($request, $tenant);
        $tenant->accepted_payments = json_decode($tenant->accepted_payments, true);
        return response()->json($tenant);
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
    public function show()
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        // dd("Hello from update");

        if (auth()->user()->role != 'admin') abort(404);
        $tenant = tenant();
        // $tenant->update();
        return response()->json($tenant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }

    private function matchDomain(Request $request, Tenant $tenant)
    {
        $allowedDomains = $tenant->domains->pluck('domain')->toArray();
        $requestDomain = $request->getHost();

        // dd($allowedDomains);
        // dd($requestDomain);

        if (!in_array($requestDomain, $allowedDomains)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
