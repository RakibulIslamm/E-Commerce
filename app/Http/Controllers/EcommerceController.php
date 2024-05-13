<?php

namespace App\Http\Controllers;

use App\Models\Ecommerce;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role != 1 && auth()->user()->role != 2 && auth()->user()->role != 3) {
            abort(404);
        }
        $ecommerces = Ecommerce::all();
        foreach ($ecommerces as $ecommerce) {
            $ecommerce->accepted_payments = json_decode($ecommerce->accepted_payments, true);
        }
        // return Inertia::render("Ecommerces/Ecommerces", ['ecommerces' => $ecommerces]);
        return view("ecommerces.index", ['ecommerces' => $ecommerces]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role != 1 && auth()->user()->role != 3) {
            abort(403, "Unauthorized access");
        }
        return view("ecommerces.create", ['mode' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->user()->role != 1 && $request->user()->role != 3) {
            abort(403, "Unauthorized access");
        }

        $validatedData = $request->validate([
            'domain' => 'required|string',
            'auth_username' => 'required|string',
            'auth_password' => 'required|string',
            'email' => 'required|email',
            'tax_code' => 'required|string',
            'phone' => 'required|string',
            'rest_api_user' => 'required|string',
            'rest_api_password' => 'required|string',
            'business_type' => 'required|in:B2C,B2B,B2B Plus',
            'price_with_vat' => 'nullable|boolean',
            'decimal_places' => 'nullable|integer',
            'size_color_options' => 'nullable|boolean',
            'product_stock_display' => 'required|in:Text Only,Text + Quantity,Do not display',
            'registration_process' => 'required|in:Optional,Mandatory,Mandatory with confirmation',
            'accepted_payments' => 'required|array',
            'accepted_payments.*' => 'string',
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

        Ecommerce::create($validatedData);
        return redirect()->route('ecommerce.index')->with('success', 'New eCommerce created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ecommerce $ecommerce)
    {
        // dd($ecommerce);
        if (auth()->user()->role != 1 && auth()->user()->role != 2 && auth()->user()->role != 3) {
            abort(404);
        }
        $ecommerce->accepted_payments = json_decode($ecommerce->accepted_payments, true);
        // return Inertia::render('Ecommerces/Form', ['ecommerce' => $ecommerce, 'mode' => 'view']);
        return view("ecommerces.show", ['ecommerce' => $ecommerce, 'mode' => 'view']);
    }

    /* public function getSingleEcommerce($id)
    {
        $ecommerce = Ecommerce::findOrFail($id);
        $ecommerce->accepted_payments = json_decode($ecommerce->accepted_payments, true);
        return response()->json($ecommerce);
    } */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ecommerce $ecommerce)
    {
        if (auth()->user()->role != 1 && auth()->user()->role != 2) {
            abort(403, "Unauthorize access");
        }
        $ecommerce->accepted_payments = json_decode($ecommerce->accepted_payments, true);
        // return Inertia::render('Ecommerces/Form', ['mode' => 'edit', 'ecommerce' => $ecommerce]);
        return view("ecommerces.edit", ['mode' => 'edit', 'ecommerce' => $ecommerce]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ecommerce $ecommerce)
    {
        if (auth()->user()->role != 1 && auth()->user()->role != 2) {
            abort(403, "Unauthorize access");
        }
        $validatedData = $request->validate([
            'domain' => 'required|string',
            'auth_username' => 'required|string',
            'auth_password' => 'required|string',
            'email' => 'required|email',
            'tax_code' => 'required|string',
            'phone' => 'required|string',
            'rest_api_user' => 'required|string',
            'rest_api_password' => 'required|string',
            'business_type' => 'required|in:B2C,B2B,B2B Plus',
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

        $ecommerce->update($validatedData);
        return redirect()->route('ecommerce.index')->with('success', 'eCommerce updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ecommerce $ecommerce)
    {
        if (auth()->user()->role != 1) {
            abort(403, "Unauthorize access");
        }
        $ecommerce->delete();
        return redirect()->route('ecommerce.index')
            ->with('success', 'ecommerce deleted successfully');
    }

    // public function destroy($id)
    // {
    //     // Find the item by ID

    //     $user = auth()->user();
    //     dd($user->role);

    //     $ecommerce = Ecommerce::find($id);
    //     // Check if the item exists
    //     if (!$ecommerce) {
    //         // Item not found, return error response
    //         return response()->json(['message' => 'Item not found'], 404);
    //     }

    //     // Delete the item
    //     $ecommerce->delete();

    //     // Return success response
    //     return response()->json(['message' => 'Item deleted successfully']);
    // }
}
