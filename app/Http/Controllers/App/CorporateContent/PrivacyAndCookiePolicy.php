<?php

namespace App\Http\Controllers\App\CorporateContent;

use App\Models\Tenant;
use Illuminate\Http\Request;

class PrivacyAndCookiePolicy
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenant = tenant();
        $privacy_and_cookie = $tenant['privacy_and_cookie'] ?? '';
        return view('app.pages.corporate-content.privacy-and-cookie.index', ['privacy_and_cookie' => $privacy_and_cookie]);
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
        $tenant = tenant();
        $privacy_and_cookie = $tenant['privacy_and_cookie'] ?? '';
        return view('app.pages.privacy.privacy-and-cookie', ['privacy_and_cookie' => $privacy_and_cookie]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $tenant = tenant();
        $privacy_and_cookie = $tenant['privacy_and_cookie'] ?? '';
        return view('app.pages.corporate-content.privacy-and-cookie.edit', ['privacy_and_cookie' => $privacy_and_cookie]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            "privacy_and_cookie" => 'string'
        ]);

        tenant()->update($validatedData);

        return redirect()->route('app.corporate-content.privacy-and-cookie');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
