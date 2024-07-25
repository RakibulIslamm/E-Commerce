<?php

namespace App\Http\Controllers\CentralApp;

use App\Models\EcommerceRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EcommerceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        if ($user->role == 2) {
            return redirect('/dashboard');
        }
        $requested_ecommerces = ($user->role == 1 || $user->role == 3) ? EcommerceRequest::all() : EcommerceRequest::where('user_id', $user->id)->orderBy("created_at", "desc")->get();

        return view("central_app.ecommerce-request.index", ["requested_ecommerces" => $requested_ecommerces]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3) {
            return redirect('/ecommerce/requests');
        }
        return view("central_app.ecommerce-request.request-form");
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

        // dd($validatedData);

        try {
            $validatedData['user_id'] = auth()->user()->id;
            EcommerceRequest::create($validatedData);
            return redirect()->route('request.index')->with('success', 'Ecommerce requested successfully');
        } catch (ValidationException $error) {
            // return Inertia::render('EcommerceRequest/RequestForm', [
            //     'errors' => $error->errors(),
            //     'input' => $request->all(),
            // ])->withInput();
            return view("central_app.ecommerce-request.request-form", [
                'errors' => $error->errors(),
                'input' => $request->all(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EcommerceRequest $ecommerceRequest)
    {
        $user = request()->user();
        if ($user->role == 1 || $user->role == 3 || $user->id == $ecommerceRequest->user_id) {
            return view("central_app.ecommerce-request.show", ['ecommerceRequest' => $ecommerceRequest]);
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
