<?php

namespace App\Http\Controllers\App\CorporateContent;

use Illuminate\Http\Request;
use App\Models\Tenant;

class ConditionForSaleController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenant = tenant();
        $condition_for_sale = $tenant['condition_for_sale'] ?? '';
        return view('app.pages.corporate-content.condition-for-sale.index', ['condition_for_sale' => $condition_for_sale]);
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
        $condition_for_sale = $tenant['condition_for_sale'] ?? '';
        return view('app.pages.terms.condition-for-sale', ['condition_for_sale' => $condition_for_sale]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $tenant = tenant();
        $condition_for_sale = $tenant['condition_for_sale'] ?? '';
        return view('app.pages.corporate-content.condition-for-sale.edit', ['condition_for_sale' => $condition_for_sale]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            "condition_for_sale" => 'string'
        ]);

        tenant()->update($validatedData);

        return redirect()->route('app.corporate-content.condition-for-sale');
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
