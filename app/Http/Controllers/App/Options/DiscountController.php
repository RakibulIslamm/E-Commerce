<?php

namespace App\Http\Controllers\App\Options;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::all();
        return view("app.pages.options.discount-management.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view("app.pages.options.discount-management.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'minimum_price' => 'nullable|numeric',
            'value' => 'required|numeric',
            'duration_days' => 'nullable|integer',
        ]);
        $discount = Discount::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'type' => 'sometimes|required|string|max:255',
            'minimum_price' => 'nullable|numeric',
            'value' => 'sometimes|required|numeric',
            'duration_days' => 'nullable|integer',
        ]);
        $discount->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
    }
}
