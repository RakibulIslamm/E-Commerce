<?php

namespace App\Http\Controllers\App\CorporateContent;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class EcommerceSettingsController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if (!Auth::check() || auth()->user()->role != 1)
        //     abort(404);

        $tenant = tenant();
        $tenant->accepted_payments = json_decode($tenant->accepted_payments, true);
        return view('app.pages.corporate-content.ecommerce.index', ['settings' => $tenant]);
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
        // if (!Auth::check() || auth()->user()->role != 1)
        //     abort(404);
        $tenant = tenant();
        $tenant->accepted_payments = json_decode($tenant->accepted_payments, true);
        return view('app.pages.corporate-content.ecommerce.edit', ['settings' => $tenant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        // if (!Auth::check() || auth()->user()->role != 1)
        //     abort(404);

        $validatedData = $request->validate([
            'tax_code' => 'required|string',
            'phone' => 'required|string',
            'rest_api_user' => 'required|string',
            'price_with_vat' => 'nullable|boolean',
            'decimal_places' => 'nullable|integer',
            'size_color_options' => 'nullable|boolean',
            'product_stock_display' => 'required|in:Text Only,Text + Quantity,Do not display',
            'registration_process' => 'required|in:Optional,Mandatory,Mandatory with confirmation',
            'accepted_payments' => 'required|array',
            'offer_display' => 'required|in:View cut price,Do not display the cut price',
        ]);
        // $validated['NOVITA'] = $request->input('NOVITA', false) ? true : false;
        if (isset($validatedData['price_with_vat'])) {
            $validatedData['price_with_vat'] = true;
        } else {
            $validatedData['price_with_vat'] = false;
        }
        if (isset($validatedData['size_color_options'])) {
            $validatedData['size_color_options'] = true;
        } else {
            $validatedData['size_color_options'] = false;
        }
        $validatedData['accepted_payments'] = json_encode($validatedData['accepted_payments']);


        $tenant = tenant();
        $tenant->update($validatedData);
        return redirect()->route('app.corporate-content.ecommerce');
    }

    public function toggleOutOfStock(Request $request)
    {
        $value = $request->has('show_out_of_stock') ? 1 : 0;

        $tenant = tenant();
        $tenant->update([
            "show_out_of_stock" => $value
        ]);

        return redirect()->back()->with('success', 'Impostazione aggiornata.');
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
