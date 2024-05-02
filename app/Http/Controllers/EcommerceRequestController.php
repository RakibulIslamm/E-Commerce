<?php

namespace App\Http\Controllers;

use App\Models\EcommerceRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class EcommerceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();

        // dd($user->id);
        // $requested_ecommerces = EcommerceRequest::all();
        $requested_ecommerces = $user->role == 1 ? EcommerceRequest::all() : EcommerceRequest::where('user_id', $user->id)->orderBy("created_at", "desc")->get();

        return Inertia::render("EcommerceRequest/EcommerceRequest", ["requested_ecommerces" => $requested_ecommerces]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3) {
            redirect('/ecommerce/requests');
        }
        return Inertia::render("EcommerceRequest/RequestForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3) {
            abort(403, 'Unauthorize access');
        }

        $validatedData = $request->validate([
            'domain' => 'required|string',
            'email' => 'required|email',
            'vat_number' => 'required|string',
            'company_name' => 'required|string',
            'business_type' => 'required|in:B2C,B2B,B2B Plus',
        ]);

        try {
            $validatedData['user_id'] = auth()->user()->id;
            EcommerceRequest::create($validatedData);
            return redirect()->route('home')->with('success', 'Request for an e-commerce posted successfully');
        } catch (ValidationException $error) {
            return Inertia::render('EcommerceRequest/RequestForm', [
                'errors' => $error->errors(),
                'input' => $request->all(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EcommerceRequest $ecommerceRequest)
    {
        $user = request()->user();
        if ($user->id == 1 || $user->id == $ecommerceRequest->user_id) {
            return Inertia::render('EcommerceRequest/Show', ['ecommerceRequest' => $ecommerceRequest]);
        } else {
            abort(404);
            // return redirect()->route('home');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EcommerceRequest $ecommerceRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EcommerceRequest $ecommerceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EcommerceRequest $ecommerceRequest)
    {
        //
    }
}
