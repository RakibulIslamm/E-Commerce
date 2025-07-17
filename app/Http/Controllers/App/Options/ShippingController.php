<?php

namespace App\Http\Controllers\App\Options;

use App\Models\ShippingSetting;
use Illuminate\Http\Request;

class ShippingController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingSettings = ShippingSetting::with('rules')->paginate(10);

        return view('app.pages.options.shipping-settings.index', [
            'shippingSettings' => $shippingSettings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.pages.options.shipping-settings.create', ["mode" => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'courier' => 'nullable|string',
            'minimum_order' => 'required|numeric',
            'cod_fee' => 'required|numeric',
            'vat_rate' => 'required|numeric',
            'rules' => 'nullable|array',
            'rules.*.zone' => 'required|string',
            'rules.*.threshold' => 'required|numeric',
            'rules.*.fee' => 'required|numeric',
        ]);
    
        // Create or update the shipping settings
        $shippingSetting = ShippingSetting::updateOrCreate(
            ['id' => $request->id],
            $request->only('courier', 'minimum_order', 'cod_fee', 'vat_rate')
        );
    
        // Save rules
        if (!empty($validated['rules'])) {
            $shippingSetting->rules()->delete(); // Clear existing rules
            foreach ($validated['rules'] as $rule) {
                $shippingSetting->rules()->create($rule);
            }
        }
    
        return redirect()->route('app.shipping-settings')->with('success', 'Impostazioni di spedizione salvate con successo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingSetting $shippingSetting)
    {
        $shippingSetting->load('rules');

        return view('app.pages.options.shipping-settings.show', [
            'shippingSetting' => $shippingSetting
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingSetting $shippingSetting)
    {
        return view('app.pages.options.shipping-settings.edit', [
            'mode' => 'edit',
            'shipping_settings' => $shippingSetting->load('rules')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingSetting $shippingSetting)
    {
        $validated = $request->validate([
            'courier' => 'nullable|string',
            'minimum_order' => 'required|numeric',
            'cod_fee' => 'required|numeric',
            'vat_rate' => 'required|numeric',
            'rules' => 'nullable|array',
            'rules.*.zone' => 'required|string',
            'rules.*.threshold' => 'required|numeric',
            'rules.*.fee' => 'required|numeric',
        ]);

        // Update the shipping setting
        $shippingSetting->update($request->only('courier', 'minimum_order', 'cod_fee', 'vat_rate'));

        // Update the rules
        if (!empty($validated['rules'])) {
            $shippingSetting->rules()->delete(); // Clear existing rules
            foreach ($validated['rules'] as $rule) {
                $shippingSetting->rules()->create($rule);
            }
        }

        return redirect()->route('app.shipping-settings')->with('success', 'Impostazioni di spedizione aggiornate con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingSetting $shippingSetting)
    {
        try {
            $name = $shippingSetting->courier;
            $shippingSetting->delete();
            return redirect()->route('app.shipping-settings')->with('success', "$name Deleted");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
