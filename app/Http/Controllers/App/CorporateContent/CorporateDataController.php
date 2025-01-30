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
        // Validate the request data
        $request->validate([
            'logo' => 'nullable|image|mimes:png,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,svg|max:100',
            'logo_height' => 'nullable|integer',
            'name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Retrieve the tenant instance
        $tenant = tenant();
        if (!$tenant) {
            return redirect()->route('app.corporate-data')->withErrors('Tenant not found.');
        }

        // Initialize data array
        $data = $request->only(['logo_height', 'name', 'tagline', 'description']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            
            // Validate logo
            if (!$logo->isValid()) {
                return redirect()->route('app.corporate-data')->withErrors('Logo upload failed. Please try again.');
            }

            // Store the logo and update the URL
            $path = $logo->store("logos", 'public');
            if ($path) {
                $data['logo'] = tenant_asset($path);
            } else {
                return redirect()->route('app.corporate-data')->withErrors('Failed to store logo.');
            }
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');

            // Validate favicon
            if (!$favicon->isValid()) {
                return redirect()->route('app.corporate-data')->withErrors('Favicon upload failed. Please try again.');
            }

            // Store the favicon and update the URL
            $faviconPath = $favicon->store("favicons", 'public');
            if ($faviconPath) {
                $data['favicon'] = tenant_asset($faviconPath);
            } else {
                return redirect()->route('app.corporate-data')->withErrors('Failed to store favicon.');
            }
        }

        // Merge existing brand_info with new data
        $brand_info = $tenant->brand_info ?? [];
        $newData = array_merge($brand_info, $data);

        // Update the tenant's brand_info
        $tenant->update([
            "brand_info" => $newData
        ]);

        return redirect()->route('app.corporate-data')->with('success', 'Brand information updated successfully.');
    }


    public function update_address(Request $request)
    {
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

    public function update_smtp(Request $request)
    {
        $validateData = $request->validate([
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|string',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_from_address' => 'nullable|string'
        ]);

        $tenant = tenant();
        $tenant->update([
            "smtp" => $validateData
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
