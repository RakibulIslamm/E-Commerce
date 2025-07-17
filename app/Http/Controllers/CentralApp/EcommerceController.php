<?php

namespace App\Http\Controllers\CentralApp;

use App\Models\Tenant;
use App\Services\PleskAPI;
use Exception;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{

    protected $plesk;
    // protected $databaseManager;

    public function __construct(PleskAPI $plesk)
    {
        $this->plesk = $plesk;
        // $this->databaseManager = $databaseManager;
    }

    public function index(Request $request)
    {
        $this->checkCentralDomain($request);
        if (auth()->user()->role != 1 && auth()->user()->role != 2 && auth()->user()->role != 3) {
            abort(404);
        }
        // $ecommerces = Ecommerce::all();

        $ecommerces = Tenant::with('domains')->get();
        // dd($ecommerces);
        foreach ($ecommerces as $ecommerce) {
            if ($ecommerce->accepted_payments !== null) {
                $ecommerce->accepted_payments = json_decode($ecommerce->accepted_payments, true);
            }
        }

        return view("central_app.ecommerces.index", ['ecommerces' => $ecommerces]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role != 1 && auth()->user()->role != 3) {
            abort(403, "Unauthorized access");
        }
        return view("central_app.ecommerces.create", ['mode' => 'create']);
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
            'business_name' => 'required|string',
            'domain' => 'required|string|unique:domains,domain',
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



        $full_domain = $validatedData['domain'];
        $domain_name = strtok($full_domain, ".");
        $brand_info = [
            "logo_height" => "56",
            "name" => "",
            "tagline" => "",
            "description" => ""
        ];

        try {
            // Creating plesk db for tenant
            $this->plesk->createDatabase($full_domain, 'mysql', 'asefecommerce.space', 62, 1);

            $tenant = Tenant::create([...$validatedData, 'tenancy_db_name' => $full_domain, 'brand_info'=> $brand_info]);

            $tenant->domains()->create([
                'domain' => $domain_name . '.' . config('app.domain')
            ]);
            $tenant->domains()->create([
                'domain' => $full_domain
            ]);

            return redirect()->route('ecommerce.index')->with('success', 'Nuovo eCommerce creato con successo');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $ecommerce)
    {
        if (auth()->user()->role != 1 && auth()->user()->role != 2 && auth()->user()->role != 3) {
            abort(404);
        }
        $ecommerce->accepted_payments = json_decode($ecommerce->accepted_payments, true);
        return view("central_app.ecommerces.show", ['ecommerce' => $ecommerce, 'mode' => 'view']);
    }

    public function edit(Tenant $ecommerce)
    {
        if (auth()->user()->role != 1 && auth()->user()->role != 2) {
            abort(403, "Unauthorize access");
        }
        $ecommerce->accepted_payments = json_decode($ecommerce->accepted_payments, true);
        return view("central_app.ecommerces.edit", ['mode' => 'edit', 'ecommerce' => $ecommerce]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $ecommerce)
    {
        if (auth()->user()->role != 1 && auth()->user()->role != 2) {
            abort(403, "Unauthorize access");
        }
        $validatedData = $request->validate([
            'business_name' => 'nullable|string',
            'domain' => 'nullable|string',
            'auth_username' => 'nullable|string',
            'auth_password' => 'required|string',
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
        return redirect()->route('ecommerce.index')->with('success', 'eCommerce aggiornato con successo');
    }

    public function suspend(Request $request, Tenant $ecommerce)
    {
        if ($request->all('suspend_tenant')['suspend_tenant'] == 'on') {
            $request->merge(['suspend_tenant' => false]);
        } else {
            $request->merge(['suspend_tenant' => true]);
        }
        if (auth()->user()->role != 1 && auth()->user()->role != 2) {
            abort(403, "Unauthorize access");
        }
        
        $validatedData = $request->validate([
            'suspend_tenant' => 'required|boolean',
        ]);

        $str = $validatedData['suspend_tenant'] ? "sospeso con successo":"autorizzato con successo";

        $ecommerce->update($validatedData);
        return redirect()->route('ecommerce.index')->with('success', $str);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $ecommerce)
    {
        if (auth()->user()->role != 1) {
            abort(403, "Unauthorize access");
        }


        try {
            // Go to app/Services/PleskAPI and set delete logic of plesk api
            // $this->plesk->deleteDatabase();
            $ecommerce->delete();
            return redirect()->route('ecommerce.index')
                ->with('success', 'e-commerce eliminato con successo');

        } catch (Exception $e) {
            return redirect()->route('ecommerce.index')->with('error', $e->getMessage());
        }
    }

    private function checkCentralDomain(Request $request)
    {
        $allowedDomains = config('tenancy.central_domains', []);
        $requestDomain = $request->getHost();

        if (!in_array($requestDomain, $allowedDomains)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
