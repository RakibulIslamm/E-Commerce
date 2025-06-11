<?php

namespace App\Http\Controllers\App\Options;

use App\Models\ShippingData;
use Illuminate\Http\Request;

class ShippingDataController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingData = ShippingData::all();
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
        $validated = $request->validate([
            'courier' => 'required|string|max:255',
            'minimum_spend' => 'nullable|numeric',
            'marking_costs' => 'nullable|numeric',
            'vat_value' => 'nullable|numeric',
            'shipping_italy_until' => 'nullable|numeric',
            'shipping_italy_charge' => 'nullable|numeric',
            'shipping_major_islands_until' => 'nullable|numeric',
            'shipping_major_islands_charge' => 'nullable|numeric',
            'shipping_smaller_islands_until' => 'nullable|numeric',
            'shipping_smaller_islands_charge' => 'nullable|numeric',
        ]);
        $shippingData = ShippingData::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingData $shippingData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingData $shippingData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingData $shippingData)
    {
        $validated = $request->validate([
            'courier' => 'sometimes|required|string|max:255',
            'minimum_spend' => 'nullable|numeric',
            'marking_costs' => 'nullable|numeric',
            'vat_value' => 'nullable|numeric',
            'shipping_italy_until' => 'nullable|numeric',
            'shipping_italy_charge' => 'nullable|numeric',
            'shipping_major_islands_until' => 'nullable|numeric',
            'shipping_major_islands_charge' => 'nullable|numeric',
            'shipping_smaller_islands_until' => 'nullable|numeric',
            'shipping_smaller_islands_charge' => 'nullable|numeric',
        ]);
        $shippingData->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingData $shippingData)
    {
        $shippingData->delete();
    }
}
