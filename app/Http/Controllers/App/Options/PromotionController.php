<?php

namespace App\Http\Controllers\App\Options;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Storage;

class PromotionController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::all();
        return view('app.pages.options.promotions.index', ["promotions" => $promotions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.pages.options.promotions.create', ["mode" => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->all('active')['active'] == 'on') {
            $request->merge(['active' => true]);
        } else {
            $request->merge(['active' => false]);
        }


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:promotions',
            'discount_amount' => 'nullable|numeric',
            'discount_percentage' => 'nullable|integer',
            'minimum_spend' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'active' => 'boolean',
            'bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['discount_amount'] = $validated['discount_amount'] ? $validated['discount_amount'] : 0;
        $validated['discount_percentage'] = $validated['discount_percentage'] ? ($validated['discount_percentage']) : 0;
        // Set all other promotions to inactive
        if ($validated['active'] == true) {
            Promotion::where('active', true)->update(['active' => false]);
        }

        if ($request->hasFile('bg_image')) {
            $path = $request->file('bg_image')->store('promotions', 'public');
            $url = tenant_asset($path);
            $validated['bg_image'] = $url;
        }
        $promotion = Promotion::create($validated);
        return redirect()->route('app.promotions')->with('success', 'Created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        return view('app.pages.options.promotions.edit', ["mode" => 'edit', "promotion" => $promotion]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        if ($request->all('active')['active'] == 'on') {
            $request->merge(['active' => true]);
        } else {
            $request->merge(['active' => false]);
        }
        // dd($request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'code' => 'required|string|max:255|unique:promotions',
            'discount_amount' => 'nullable|numeric',
            'discount_percentage' => 'nullable|integer',
            'minimum_spend' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'active' => 'boolean',
            'bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['discount_amount'] = $validated['discount_amount'] ? $validated['discount_amount'] : null;
        $validated['discount_percentage'] = $validated['discount_percentage'] ? ($validated['discount_percentage']) : null;

        // dd($validated);

        if ($validated['active'] == true) {
            Promotion::where('active', true)->update(['active' => false]);
        }

        if ($request->hasFile('bg_image')) {
            if ($promotion->bg_image) {
                $filename = basename(parse_url($promotion->bg_image, PHP_URL_PATH));
                $path = 'promotions/' . $filename;
                Storage::disk('public')->delete($path);
            }

            $path = $request->file('bg_image')->store('promotions', 'public');
            $url = tenant_asset($path);
            $validated['bg_image'] = $url;
        }
        $promotion->update($validated);
        return redirect()->route('app.promotions')->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        if ($promotion->bg_image) {
            $filename = basename(parse_url($promotion->bg_image, PHP_URL_PATH));
            $path = 'promotions/' . $filename;
            Storage::disk('public')->delete($path);
        }
        $promotion->delete();
    }
}
