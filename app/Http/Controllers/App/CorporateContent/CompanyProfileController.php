<?php

namespace App\Http\Controllers\App\CorporateContent;

use Illuminate\Http\Request;
use App\Models\Tenant;

class CompanyProfileController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenant = tenant();
        $about = $tenant['about_us'] ?? '';
        return view('app.pages.corporate-content.company-profile.index', ['about_us' => $about]);
    }

    public function show_profile(Request $request)
    {
        $tenant = tenant();
        $about = $tenant['about_us'] ?? '';
        return view('app.pages.agency.index', ['about_us' => $about]);
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
        $tenant = tenant();
        $about = $tenant['about_us'] ?? '';
        return view('app.pages.corporate-content.company-profile.edit', ['about_us' => $about]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            "about_us" => 'string'
        ]);

        tenant()->update($validatedData);

        return redirect()->route('app.corporate-content.company-profile');
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
