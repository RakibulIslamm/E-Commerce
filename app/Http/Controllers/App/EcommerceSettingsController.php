<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class EcommerceSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check() || auth()->user()->role != 1)
            abort(404);

        $tenant = tenant();
        $tenant->accepted_payments = json_decode($tenant->accepted_payments, true);
        return view('app.settings.ecommerce.index', ['settings' => $tenant]);
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
        $tenant->accepted_payments = json_decode($tenant->accepted_payments, true);
        return view('app.settings.ecommerce.edit', ['settings' => $tenant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
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


        if (!Auth::check() || auth()->user()->role != 1)
            abort(404);
        dd($validatedData);
        $tenant = tenant();
        $tenant->update($validatedData);
        return redirect()->route('app.settings.ecommerce');
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
