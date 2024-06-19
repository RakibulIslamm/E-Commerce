<?php

namespace App\Http\Controllers\App\CorporateContent;

use App\Models\Tenant;
use Illuminate\Http\Request;

class CorporateDataController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenant = tenant();
        $tenant->accepted_payments = json_decode($tenant->accepted_payments, true);
        return view('app.pages.corporate-content.corporate-data.index', ['settings' => $tenant, "mode" => 'view']);
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
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_brand(Request $request)
    {
        // dd(request()->all());
        $request->validate([
            'logo' => 'nullable|image|mimes:png,svg|max:2048',
            'logo_height' => 'nullable|integer',
            'name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['logo_height', 'name', 'tagline', 'description']);
        $tenant = tenant();
        // $folder = strtok($tenant->domain, ".");

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            // $stored = \Storage::disk('public')->put("$folder/logos", $logo);
            $path = $logo->store("logos", 'public');
            $url = tenant_asset($path);
            // dd($url);
            $data['logo'] = $url;
        }

        if (isset($tenant->brand_info)) {
            $newData = array_merge($tenant->brand_info, $data);
            $tenant->update([
                "brand_info" => $newData
            ]);
            return redirect()->route('app.corporate-data');
        }

        $tenant->update([
            "brand_info" => $data
        ]);
        return redirect()->route('app.corporate-data');
    }
    public function update_address(Request $request)
    {
        // dd(request()->all());
        $validateData = $request->validate([
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'street' => 'nullable|string',
            'email' => 'nullable|string',
            'telephone' => 'nullable|string',
            'fax' => 'nullable|string',
            'iban' => 'nullable|string',
            'map_iframe' => 'nullable|string'
        ]);

        // dd($validateData);
        $tenant = tenant();
        $tenant->update([
            "corporate_data" => $validateData
        ]);
        return redirect()->route('app.corporate-data');
    }
    public function update_social(Request $request)
    {
        $tenant = tenant();
        $existingSocials = $tenant->company_socials ?? [];
        $submittedLinks = $request->input('socialMediaLinks', []);
        foreach ($submittedLinks as $submittedLink) {
            $name = $submittedLink['name'];
            $url = $submittedLink['url'];
            $existingSocials[$name] = $url;
        }
        // dd($existingSocials);

        $tenant->update([
            "social_links" => $existingSocials
        ]);
        return redirect()->route('app.corporate-data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
}
