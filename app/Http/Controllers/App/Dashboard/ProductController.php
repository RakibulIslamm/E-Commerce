<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Product::query();

        // Set the number of items per page, default to 12 if not provided
        $perPage = request()->input('limit', 50);

        if($perPage > 50){
            $perPage = 50;
            request()->merge(['limit' => 50]);
        }
        $products = $query->paginate($perPage);
        $products->appends(request()->all());

        foreach ($products as $product) {
            if (isset($product['FOTO'])) {
                $product['FOTO'] = json_decode($product['FOTO'], true);
                $product['FOTO'] = count($product['FOTO']) ? $product['FOTO'][0]:null;
            }

            $categoriesHierarchy = !empty($product['CATEGORIEESOTTOCATEGORIE']) && is_array($product['CATEGORIEESOTTOCATEGORIE']) 
            ? $product['CATEGORIEESOTTOCATEGORIE'] 
            : [];

            $product['category'] = $this->getCategoryInfo($categoriesHierarchy);
        }

        return view("app.pages.dashboard.products.index", ["products" => $products]);
    }

    function products_api()
    {
        try {
            $products = Product::all();
            foreach ($products as $product) {
                if (isset($product['FOTO'])) {
                    $product['FOTO'] = json_decode($product['FOTO'], true);
                    $product['FOTO'] = count($product['FOTO']) ? $product['FOTO'][0]:null;
                }
            }
            // dd($products);
            return response()->json([
                "codice" => "OK",
                "articolo" => $products,
                "msg" => "Products retrieved successfully",
                "numero"=> 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "codice" => "OK",
                "errore" => [
                    "numero" => $e->getCode(),
                    "msg" => $e->getMessage(),
                    "extra_msg" => ''
                ]
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view("app.pages.dashboard.products.create", ["categories_for_form" => $categories, "mode" => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'BARCODE' => 'required|string',
            'DESCRIZIONEBREVE' => 'required|string',
            'DESCRIZIONEESTESA' => 'required|string',
            'ALIQUOTAIVA' => 'required|numeric|min:0|max:100',
            'UNITAMISURA' => 'nullable|string|in:PZ,KG,L,CM,M',
            'PXC' => 'nullable|integer|min:1',
            'CODICELEGAME' => 'nullable|string',
            'MARCA' => 'nullable|string',
            'CATEGORIEESOTTOCATEGORIE' => 'required',
            'GIACENZA' => 'nullable|integer|min:0',
            'ARTICOLIALTERNATIVI' => 'nullable|string',
            'ARTICOLICORRELATI' => 'nullable|string',
            'NOVITA' => 'nullable|boolean',
            'PIUVENDUTI' => 'nullable|boolean',
            'VISIBILE' => 'nullable|boolean',
            'FOTO' => 'nullable|array|max:10',
            'PESOARTICOLO' => 'nullable|numeric|min:0',
            'TAGLIA' => 'nullable|string',
            'COLORE' => 'nullable|string',
            'PRE1IMP' => 'required|string|min:0',
            'PRE1IVA' => 'required|numeric|min:0',
            'PRE2IMP' => 'nullable|numeric|min:0',
            'PRE2IVA' => 'nullable|numeric|min:0',
            'PRE3IMP' => 'nullable|numeric|min:0',
            'PRE3IVA' => 'nullable|numeric|min:0',
            'PREPROMOIMP' => 'nullable|numeric|min:0',
            'PREPROMOIVA' => 'nullable|numeric|min:0',
            'DATAINIZIOPROMO' => 'nullable|date',
            'DATAFINEPROMO' => 'nullable|date',
        ]);


        if (!empty($validated['BARCODE'])) {
            if (Product::where('BARCODE', $validated['BARCODE'])->exists()) {
                Log::info("A product with this BARCODE already exists: ", ['payload' => [...$request->all()], 'url'=> request()->url()]);
                $bar = $validated['BARCODE'];
                return redirect()->route('app.dashboard.product.create')->with('error', "A product with this BARCODE: $bar already exists")->withInput(request()->all());
            }
        } else {
            if (Product::where('DESCRIZIONEBREVE', $validated['DESCRIZIONEBREVE'])
                ->whereJsonContains('CATEGORIEESOTTOCATEGORIE', $validated['CATEGORIEESOTTOCATEGORIE'])
                ->exists()) {
                Log::info("A similar product already exists in this category: ", ['payload' => [...$request->all()], 'url'=> request()->url()]);
                return redirect()->route('app.dashboard.product.create')->with('error', "A similar product already exists in the selected category")->withInput(request()->all());
            }
        }


        $validated['NOVITA'] = $request->input('NOVITA', false) ? true : false;
        $validated['PIUVENDUTI'] = $request->input('PIUVENDUTI', false) ? true : false;
        $validated['VISIBILE'] = $request->input('VISIBILE', true) ? true : false;
        $validated['PESOARTICOLO'] = $validated['PESOARTICOLO'] ? ['PESOARTICOLO'] : null;
        
        $validated['PRE1IMP'] = $validated['PRE1IMP'] ? floatval($validated['PRE1IMP']) : null;
        $validated['PRE1IVA'] = $validated['PRE1IVA'] ? floatval($validated['PRE1IVA']) : null;
        $validated['PRE2IMP'] = $validated['PRE2IMP'] ? floatval($validated['PRE2IMP']) : null;
        $validated['PRE2IVA'] = $validated['PRE2IVA'] ? floatval($validated['PRE2IVA']) : null;
        $validated['PRE3IMP'] = $validated['PRE3IMP'] ? floatval($validated['PRE3IMP']) : null;
        $validated['PRE3IVA'] = $validated['PRE3IVA'] ? floatval($validated['PRE3IVA']) : null;
        $validated['PREPROMOIMP'] = $validated['PREPROMOIMP'] ? floatval($validated['PREPROMOIMP']) : null;
        $validated['PREPROMOIVA'] = $validated['PREPROMOIVA'] ? floatval($validated['PREPROMOIVA']) : null;

        $validated['DATAINIZIOPROMO'] = $validated['DATAINIZIOPROMO'] ? $validated['DATAINIZIOPROMO'] : null;
        $validated['DATAFINEPROMO'] = $validated['DATAFINEPROMO'] ? $validated['DATAFINEPROMO'] : null;


        // Handle `CATEGORIEESOTTOCATEGORIE`
        $categorieHierarchy = [];
        $codice = $request->CATEGORIEESOTTOCATEGORIE;

        // Check for the current category
        $currentCategory = Category::where('codice', $codice)->first();
        if (!$currentCategory) {
            // return response()->json([
            //     "codice" => "OK",
            //     "errore" => [
            //         "numero" => 404,
            //         "msg" => "Category with code {$codice} not found",
            //         "extra_msg" => ''
            //     ]
            // ]);
        }
        $categorieHierarchy[] = $codice;

        // Check for the parent category
        if (substr($codice, -4) !== '0000') {
            $parentCode = substr($codice, 0, -4) . '0000';
            if (substr($codice, -2) !== '00') {
                $parentCode = substr($codice, 0, -2) . '00';
                $categorieHierarchy[] = $parentCode;
            }

            // Check for the grandparent category
            if (strlen($codice) > 4) {
                $grandParentCode = substr($parentCode, 0, -4) . '0000';
                $categorieHierarchy[] = $grandParentCode;
            }
        }
        $validated['CATEGORIEESOTTOCATEGORIE'] = json_encode($categorieHierarchy);
        

        try {
            $imagePaths = [];
            if ($request->hasFile('FOTO')) {
                foreach ($request->file('FOTO') as $image) {
                    $imgName = uniqid('product_') . '.png';$image->getClientOriginalName();
                    $path = $image->storeAs('public/uploads/products', $imgName);
                    $imagePaths[] = "uploads/products/{$imgName}";
                }
            }
            $validated['FOTO'] = json_encode($imagePaths);
            
            Product::create($validated);
            return redirect()->route('app.dashboard.products')->with('success', 'Product added');
        } catch (\Exception $e) {
            return redirect()->route('app.dashboard.product.create')->with('error', $e->getMessage())->withInput(request()->all());
        }
    }
    /* public function store(Request $request)
    {
        $validated = $request->validate([
            'BARCODE' => 'nullable|string',
            'DESCRIZIONEBREVE' => 'required|string',
            'DESCRIZIONEESTESA' => 'required|string',
            'ALIQUOTAIVA' => 'required|numeric|min:0|max:100',
            'UNITAMISURA' => 'nullable|string|in:PZ,KG,L,CM,M',
            'PXC' => 'nullable|integer|min:1',
            'CODICELEGAME' => 'nullable|string',
            'MARCA' => 'nullable|string',
            'CATEGORIEESOTTOCATEGORIE' => 'required',
            'GIACENZA' => 'nullable|integer|min:0',
            'ARTICOLIALTERNATIVI' => 'nullable|string',
            'ARTICOLICORRELATI' => 'nullable|string',
            'NOVITA' => 'nullable|boolean',
            'PIUVENDUTI' => 'nullable|boolean',
            'VISIBILE' => 'nullable|boolean',
            'FOTO' => 'nullable|array|max:10',
            'PESOARTICOLO' => 'nullable|numeric|min:0',
            'TAGLIA' => 'nullable|string',
            'COLORE' => 'nullable|string',
            'PRE1IMP' => 'required|string|min:0',
            'PRE1IVA' => 'nullable|numeric|min:0',
            'PRE2IMP' => 'nullable|numeric|min:0',
            'PRE2IVA' => 'nullable|numeric|min:0',
            'PRE3IMP' => 'nullable|numeric|min:0',
            'PRE3IVA' => 'nullable|numeric|min:0',
            'PREPROMOIMP' => 'nullable|numeric|min:0',
            'PREPROMOIVA' => 'nullable|numeric|min:0',
            'DATAINIZIOPROMO' => 'nullable|date',
            'DATAFINEPROMO' => 'nullable|date',
        ]);

        $validated['NOVITA'] = $request->input('NOVITA', false) ? true : false;
        $validated['PIUVENDUTI'] = $request->input('PIUVENDUTI', false) ? true : false;
        $validated['VISIBILE'] = $request->input('VISIBILE', true) ? true : false;
        $validated['PESOARTICOLO'] = $validated['PESOARTICOLO'] ? ['PESOARTICOLO'] : null;
        
        $validated['PRE1IMP'] = $validated['PRE1IMP'] ? floatval($validated['PRE1IMP']) : null;
        $validated['PRE1IVA'] = $validated['PRE1IVA'] ? floatval($validated['PRE1IVA']) : null;
        $validated['PRE2IMP'] = $validated['PRE2IMP'] ? floatval($validated['PRE2IMP']) : null;
        $validated['PRE2IVA'] = $validated['PRE2IVA'] ? floatval($validated['PRE2IVA']) : null;
        $validated['PRE3IMP'] = $validated['PRE3IMP'] ? floatval($validated['PRE3IMP']) : null;
        $validated['PRE3IVA'] = $validated['PRE3IVA'] ? floatval($validated['PRE3IVA']) : null;
        $validated['PREPROMOIMP'] = $validated['PREPROMOIMP'] ? floatval($validated['PREPROMOIMP']) : null;
        $validated['PREPROMOIVA'] = $validated['PREPROMOIVA'] ? floatval($validated['PREPROMOIVA']) : null;

        $validated['DATAINIZIOPROMO'] = $validated['DATAINIZIOPROMO'] ? $validated['DATAINIZIOPROMO'] : null;
        $validated['DATAFINEPROMO'] = $validated['DATAFINEPROMO'] ? $validated['DATAFINEPROMO'] : null;

        $images = [];

        try {
            if (isset($validated['FOTO'])) {
                foreach ($request->file('FOTO') as $image) {
                    // dd($image->getClientOriginalName());
                    $imgName = $image->getClientOriginalName();
                    if ($image->isValid()) {
                        $imageData = base64_encode(file_get_contents($image->path()));
                        $images[] = $imageData;
                    } else {
                        return redirect()->route('app.dashboard.product.create')->with('error', "Something went wrong with this image- '$imgName' to save as base64")->withInput(request()->all());
                    }
                }
                $validated['FOTO'] = json_encode($images);
            }
            // dd($validated);
            Product::create($validated);
            return redirect()->route('app.dashboard.products')->with('success', 'Product added');
        } catch (\Exception $e) {
            return redirect()->route('app.dashboard.product.create')->with('error', $e->getMessage())->withInput(request()->all());
        }
    } */

    public function store_api(Request $request)
    {
        // dd($request->all('FOTO'));

        $rules = [
            'BARCODE' => 'required|string',
            'DESCRIZIONEBREVE' => 'required|string',
            'DESCRIZIONEESTESA' => 'nullable|string',
            'ALIQUOTAIVA' => 'required|numeric|min:0|max:100',
            'UNITAMISURA' => 'nullable|string|in:PZ,KG,L,CM,M',
            'PXC' => 'nullable|integer|min:1',
            'CODICELEGAME' => 'nullable|string',
            'MARCA' => 'nullable|string',
            'CATEGORIEESOTTOCATEGORIE' => 'required|string',
            'GIACENZA' => 'nullable|integer|min:0',
            'ARTICOLIALTERNATIVI' => 'nullable|string',
            'ARTICOLICORRELATI' => 'nullable|string',
            'NOVITA' => 'nullable|boolean',
            'PIUVENDUTI' => 'nullable|boolean',
            'VISIBILE' => 'nullable|boolean',
            'FOTO' => 'nullable|string',
            'PESOARTICOLO' => 'nullable|numeric|min:0',
            'TAGLIA' => 'nullable|string',
            'COLORE' => 'nullable|string',
            'PRE1IMP' => 'required|numeric',
            'PRE1IVA' => 'required|numeric',
            'PRE2IMP' => 'nullable|numeric',
            'PRE2IVA' => 'nullable|numeric',
            'PRE3IMP' => 'nullable|numeric',
            'PRE3IVA' => 'nullable|numeric',
            'PREPROMOIMP' => 'nullable|numeric',
            'PREPROMOIVA' => 'nullable|numeric',
            'DATAINIZIOPROMO' => 'nullable|date',
            'DATAFINEPROMO' => 'nullable|date',
        ];
        Log::info("Start Add new product: ", ['payload' => [...$request->all(), 'FOTO'=>''], 'url'=> request()->url()]);

        $tenant = tenant();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Log::error("Error -> (Tenant ID: {$tenant->id}): Validation failed", ["errore" => [
                "numero" => 400,
                "msg" => "Validation failed",
                "errors" => $validator->errors(),
                "extra_msg" => ''
            ]]);
            return response()->json([
                "codice" => "OK",
                "errore" => [
                    "numero" => 400,
                    "msg" => "Validation failed",
                    "errors" => $validator->errors(),
                    "extra_msg" => ''
                ]
            ]);
        }
        
        $validated = $validator->validated();

        // Check if product exists
        $product = Product::where('BARCODE', $validated['BARCODE'])->first();

        if (!$product) {
            $product = Product::where('DESCRIZIONEBREVE', $validated['DESCRIZIONEBREVE'])
                ->whereJsonContains('CATEGORIEESOTTOCATEGORIE', $validated['CATEGORIEESOTTOCATEGORIE'])
                ->first();
        }

        /* if (!empty($validated['BARCODE'])) {
            if (Product::where('BARCODE', $validated['BARCODE'])->exists()) {
                Log::info("A product with this BARCODE already exists: ", ['payload' => [...$request->all()], 'url'=> request()->url()]);
                return response()->json([
                    "codice" => "OK",
                    "errore" => [
                        "numero" => 409,
                        "msg" => "A product with this BARCODE already exists.",
                        "extra_msg" => ''
                    ]
                ], 409);
            }
        } else {
            if (Product::where('DESCRIZIONEBREVE', $validated['DESCRIZIONEBREVE'])
                ->whereJsonContains('CATEGORIEESOTTOCATEGORIE', $validated['CATEGORIEESOTTOCATEGORIE'])
                ->exists()) {
                Log::info("A similar product already exists in this category: ", ['payload' => [...$request->all()], 'url'=> request()->url()]);
                return response()->json([
                    "codice" => "OK",
                    "errore" => [
                        "numero" => 409,
                        "msg" => "A similar product already exists in this category.",
                        "extra_msg" => ''
                    ]
                ], 409);
            }
        }  */       


        // Handle `CATEGORIEESOTTOCATEGORIE`
        $codice = $request->CATEGORIEESOTTOCATEGORIE;
        $categorieHierarchy = $this->getCategorieHierarchy($codice);

        
        $validated['CATEGORIEESOTTOCATEGORIE'] = json_encode($categorieHierarchy);
        // dd($validated['CATEGORIEESOTTOCATEGORIE']);

        $validated['NOVITA'] = $request->input('NOVITA', false) ? true : false;
        $validated['PIUVENDUTI'] = $request->input('PIUVENDUTI', false) ? true : false;
        $validated['VISIBILE'] = $request->input('VISIBILE', true) ? true : false;
        $validated['PESOARTICOLO'] = isset($validated['PESOARTICOLO']) ? $validated['PESOARTICOLO'] : null;
        $validated['DESCRIZIONEESTESA'] = isset($validated['DESCRIZIONEESTESA']) ? $validated['DESCRIZIONEESTESA'] : "";


        
        $validated['PRE1IMP'] = isset($validated['PRE1IMP']) ? floatval($validated['PRE1IMP']) : null;
        $validated['PRE1IVA'] = isset($validated['PRE1IVA']) ? floatval($validated['PRE1IVA']) : null;
        $validated['PRE2IMP'] = isset($validated['PRE2IMP']) ? floatval($validated['PRE2IMP']) : null;
        $validated['PRE2IVA'] = isset($validated['PRE2IVA']) ? floatval($validated['PRE2IVA']) : null;
        $validated['PRE3IMP'] = isset($validated['PRE3IMP']) ? floatval($validated['PRE3IMP']) : null;
        $validated['PRE3IVA'] = isset($validated['PRE3IVA']) ? floatval($validated['PRE3IVA']) : null;
        $validated['PREPROMOIMP'] = isset($validated['PREPROMOIMP']) ? floatval($validated['PREPROMOIMP']) : null;
        $validated['PREPROMOIVA'] = isset($validated['PREPROMOIVA']) ? floatval($validated['PREPROMOIVA']) : null;

        $validated['DATAINIZIOPROMO'] = isset($validated['DATAINIZIOPROMO']) ? $validated['DATAINIZIOPROMO'] : null;
        $validated['DATAFINEPROMO'] = isset($validated['DATAFINEPROMO']) ? $validated['DATAFINEPROMO'] : null;

        $photo = $request->input('FOTO');
        $imagePaths = [];
        
        if($photo){
            if($this->isBase64($photo)){
                $decodedImage = base64_decode($photo);
                $filename = uniqid('product_') . '.png';
                $filePath = "uploads/products/{$filename}";
                Storage::disk('public')->put($filePath, $decodedImage);
                $imagePaths[] = $filePath;
            }
            else{
                Log::error("Error -> (Tenant ID: {$tenant->id}): Invalid FOTO", ["errore" => [
                    "numero" => 400,
                    "msg" => "Invalid base64 FOTO",
                    "extra_msg" => ''
                ]]);
                return response()->json([
                    "codice" => "OK",
                    "errore" => [
                        "numero" => 400,
                        "msg" => "Invalid base64 FOTO",
                        "extra_msg" => ''
                    ]
                ]);
            }
        }
        $validated['FOTO'] = json_encode($imagePaths);
        try {
            if ($product) {
                $product->update($validated);
                Log::info("Product updated successfully");
            } else {
                $product = Product::create($validated);
                Log::info("New product added successfully");
            }
            
            return response()->json([
                "codice" => "OK",
                "articolo" => $product,
                "numero" => $product->wasRecentlyCreated ? 201 : 200
            ]);
        } catch (\Exception $e) {
            Log::error("Error -> (Tenant ID: {$tenant->id})", ["errore" => [
                    "numero" => $e->getCode(),
                    "msg" => $e->getMessage(),
                    "extra_msg" => ''
                ]]);
            return response()->json([
                "codice" => "OK",
                "errore" => [
                    "numero" => $e->getCode(),
                    "msg" => $e->getMessage(),
                    "extra_msg" => ''
                ]
            ]);
        }
    }
    
    /* public function store_api(Request $request)
    {
        // dd($request->all('FOTO'));

        $rules = [
            'BARCODE' => 'nullable|string',
            'DESCRIZIONEBREVE' => 'required|string',
            'DESCRIZIONEESTESA' => 'nullable|string',
            'ALIQUOTAIVA' => 'required|numeric|min:0|max:100',
            'UNITAMISURA' => 'nullable|string|in:PZ,KG,L,CM,M',
            'PXC' => 'nullable|integer|min:1',
            'CODICELEGAME' => 'nullable|string',
            'MARCA' => 'nullable|string',
            'CATEGORIEESOTTOCATEGORIE' => 'required',
            'GIACENZA' => 'nullable|integer|min:0',
            'ARTICOLIALTERNATIVI' => 'nullable|string',
            'ARTICOLICORRELATI' => 'nullable|string',
            'NOVITA' => 'nullable|boolean',
            'PIUVENDUTI' => 'nullable|boolean',
            'VISIBILE' => 'nullable|boolean',
            'FOTO' => 'nullable|string',
            'PESOARTICOLO' => 'nullable|numeric|min:0',
            'TAGLIA' => 'nullable|string',
            'COLORE' => 'nullable|string',
            'PRE1IMP' => 'nullable|string',
            'PRE1IVA' => 'nullable|string',
            'PRE2IMP' => 'nullable|string',
            'PRE2IVA' => 'nullable|string',
            'PRE3IMP' => 'nullable|string',
            'PRE3IVA' => 'nullable|string',
            'PREPROMOIMP' => 'nullable|string',
            'PREPROMOIVA' => 'nullable|string',
            'DATAINIZIOPROMO' => 'nullable|date',
            'DATAFINEPROMO' => 'nullable|date',
        ];

        $tenant = tenant();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            Log::error("Error -> (Tenant ID: {$tenant->id}): Validation failed", ["errore" => [
                "numero" => 400,
                "msg" => "Validation failed",
                "errors" => $validator->errors(),
                "extra_msg" => ''
            ]]);
            return response()->json([
                "codice" => "OK",
                "errore" => [
                    "numero" => 400,
                    "msg" => "Validation failed",
                    "errors" => $validator->errors(),
                    "extra_msg" => ''
                ]
            ]);
        }
        
        $validated = $validator->validated();
        $validated['NOVITA'] = $request->input('NOVITA', false) ? true : false;
        $validated['PIUVENDUTI'] = $request->input('PIUVENDUTI', false) ? true : false;
        $validated['VISIBILE'] = $request->input('VISIBILE', true) ? true : false;
        $validated['PESOARTICOLO'] = isset($validated['PESOARTICOLO']) ? $validated['PESOARTICOLO'] : null;
        $validated['DESCRIZIONEESTESA'] = isset($validated['DESCRIZIONEESTESA']) ? $validated['DESCRIZIONEESTESA'] : "";


        
        $validated['PRE1IMP'] = isset($validated['PRE1IMP']) ? floatval($validated['PRE1IMP']) : null;
        $validated['PRE1IVA'] = isset($validated['PRE1IVA']) ? floatval($validated['PRE1IVA']) : null;
        $validated['PRE2IMP'] = isset($validated['PRE2IMP']) ? floatval($validated['PRE2IMP']) : null;
        $validated['PRE2IVA'] = isset($validated['PRE2IVA']) ? floatval($validated['PRE2IVA']) : null;
        $validated['PRE3IMP'] = isset($validated['PRE3IMP']) ? floatval($validated['PRE3IMP']) : null;
        $validated['PRE3IVA'] = isset($validated['PRE3IVA']) ? floatval($validated['PRE3IVA']) : null;
        $validated['PREPROMOIMP'] = isset($validated['PREPROMOIMP']) ? floatval($validated['PREPROMOIMP']) : null;
        $validated['PREPROMOIVA'] = isset($validated['PREPROMOIVA']) ? floatval($validated['PREPROMOIVA']) : null;

        // $vatRate = $request->input('ALIQUOTAIVA');

        // $calculatedPrice1WithVAT = $validated['PRE1IMP'] * (1 + $vatRate / 100);
        // $calculatedPrice2WithVAT = $validated['PRE2IMP'] * (1 + $vatRate / 100);
        // $calculatedPrice3WithVAT = $validated['PRE3IMP'] * (1 + $vatRate / 100);

        // if (round($calculatedPrice1WithVAT, 2) !== round($validated['PRE1IVA'], 2)) {
        //     $expected = round($calculatedPrice1WithVAT, 2);
        //     $provided = round($validated['PRE1IVA'], 2);
        //     Log::error("Error -> (Tenant ID: {$tenant->id}): PRE1IMP and PRE1IVA mismatch", ["errore" => [
        //         "numero" => 422,
        //         "msg" => "PRE1IMP and PRE1IVA mismatch. Expected {$expected} but provided {$provided}",
        //         "extra_msg" => ''
        //     ]]);
        //     return response()->json([
        //         "codice" => "OK",
        //         "errore" => [
        //             "numero" => 422,
        //             "msg" => "PRE1IMP and PRE1IVA mismatch. Expected {$expected} but provided {$provided}",
        //             "extra_msg" => ''
        //         ]
        //     ]);
        // }

        $validated['DATAINIZIOPROMO'] = isset($validated['DATAINIZIOPROMO']) ? $validated['DATAINIZIOPROMO'] : null;
        $validated['DATAFINEPROMO'] = isset($validated['DATAFINEPROMO']) ? $validated['DATAFINEPROMO'] : null;

        $photo = $request->input('FOTO');
        $images = [];
        
        if($photo){
            if($this->isBase64($photo)){
                $images[] = $photo;
                $validated['FOTO'] = json_encode($images);
            }
            else{
                Log::error("Error -> (Tenant ID: {$tenant->id}): Invalid FOTO", ["errore" => [
                    "numero" => 400,
                    "msg" => "Invalid base64 FOTO",
                    "extra_msg" => ''
                ]]);
                return response()->json([
                    "codice" => "OK",
                    "errore" => [
                        "numero" => 400,
                        "msg" => "Invalid base64 FOTO",
                        "extra_msg" => ''
                    ]
                ]);
            }
        }
        
        try {
            $product = Product::create($validated);
            return response()->json([
                "codice" => "OK",
                "articolo" => $product,
                "numero"=> 201
            ]);
        } catch (\Exception $e) {
            Log::error("Error -> (Tenant ID: {$tenant->id})", ["errore" => [
                    "numero" => $e->getCode(),
                    "msg" => $e->getMessage(),
                    "extra_msg" => ''
                ]]);
            return response()->json([
                "codice" => "OK",
                "errore" => [
                    "numero" => $e->getCode(),
                    "msg" => $e->getMessage(),
                    "extra_msg" => ''
                ]
            ]);
        }
    } */

    public function articolo_esistente(Request $request)
    {
        Log::info("Start articolo_esistente() query: ", ['payload' => $request->all(), 'url'=> request()->url()]);
        
        $tenant = tenant();
        $validator = Validator::make($request->all(), [
            'id_articolo' => 'required|string',
        ]);
        

        if ($validator->fails()) {
            Log::error("Validation Error -> (Tenant ID: {$tenant->id}): id_articolo categoria mancante", ["errore" => [
                "numero" => 100,
                "msg" => "id_articolo categoria mancante",
                "extra_msg" => ""
            ]]);
            return response()->json([
                "codice" => "OK",
                "errore" => [
                    "numero" => 100,
                    "msg" => "id_articolo categoria mancante",
                    "extra_msg" => ""
                ]
            ]);
        }
        $validated = $validator->validated();
        $id_articolo = $validated['id_articolo'];

        try {
            $product = Product::where('id', $id_articolo)->exists();
            Log::info("Success articolo_esistente() query");
            return response()->json([
                'codice' => 'OK',
                'presente' => $product ? 1 : 0,
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error -> (Tenant ID: {$tenant->id}): Errore di sistema durante l'aggiornamento", ["errore" => [
                "numero" => 100,
                "msg" => "Errore di sistema durante l'aggiornamento",
                "extra_msg" => $e->getMessage()
            ]]);
            return response()->json([
                "codice" => "OK",
                "errore" => [
                    "numero" => 100,
                    "msg" => "Errore di sistema durante l'aggiornamento",
                    "extra_msg" => $e->getMessage()
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product['FOTO'] = json_decode($product['FOTO']);
        // dd($product);
        return view("app.pages.dashboard.products.edit", ["categories_for_form" => $categories, "mode" => 'edit', "product" => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // dd(request()->all('FOTO'));

        $validated = $request->validate([
            'BARCODE' => 'nullable|string',
            'DESCRIZIONEBREVE' => 'sometimes|required|string',
            'DESCRIZIONEESTESA' => 'sometimes|required|string',
            'ALIQUOTAIVA' => 'sometimes|required|numeric|min:0|max:100',
            'UNITAMISURA' => 'nullable|string|in:PZ,KG,L,CM,M',
            'PXC' => 'nullable|integer|min:1',
            'CODICELEGAME' => 'nullable|string',
            'MARCA' => 'nullable|string',
            'CATEGORIEESOTTOCATEGORIE' => 'nullable|string',
            'GIACENZA' => 'nullable|integer|min:0',
            'ARTICOLIALTERNATIVI' => 'nullable|string',
            'ARTICOLICORRELATI' => 'nullable|string',
            'NOVITA' => 'nullable|boolean',
            'PIUVENDUTI' => 'nullable|boolean',
            'VISIBILE' => 'nullable|boolean',
            'FOTO' => 'nullable|array|max:10',
            'FOTO.*' => 'nullable|file',
            'PESOARTICOLO' => 'nullable|numeric|min:0',
            'TAGLIA' => 'nullable|string',
            'COLORE' => 'nullable|string',
            'PRE1IMP' => 'sometimes|numeric|min:0',
            'PRE1IVA' => 'nullable|numeric|min:0',
            'PRE2IMP' => 'nullable|numeric|min:0',
            'PRE2IVA' => 'nullable|numeric|min:0',
            'PRE3IMP' => 'nullable|numeric|min:0',
            'PRE3IVA' => 'nullable|numeric|min:0',
            'PREPROMOIMP' => 'nullable|numeric|min:0',
            'PREPROMOIVA' => 'nullable|numeric|min:0',
            'DATAINIZIOPROMO' => 'nullable|date',
            'DATAFINEPROMO' => 'nullable|date',
        ]);

        // dd($validated['FOTO']);

        $validated['NOVITA'] = $request->input('NOVITA', false) ? true : false;
        $validated['PIUVENDUTI'] = $request->input('PIUVENDUTI', false) ? true : false;
        $validated['VISIBILE'] = $request->input('VISIBILE', true) ? true : false;
        $validated['PESOARTICOLO'] = $validated['PESOARTICOLO'] ? ['PESOARTICOLO'] : null;
        $validated['PRE1IMP'] = $validated['PRE1IMP'] ? $validated['PRE1IMP'] : null;
        $validated['PRE1IVA'] = $validated['PRE1IVA'] ? $validated['PRE1IVA'] : null;
        $validated['PRE2IMP'] = $validated['PRE2IMP'] ? $validated['PRE2IMP'] : null;
        $validated['PRE2IVA'] = $validated['PRE2IVA'] ? $validated['PRE2IVA'] : null;
        $validated['PRE3IMP'] = $validated['PRE3IMP'] ? $validated['PRE3IMP'] : null;
        $validated['PRE3IVA'] = $validated['PRE3IVA'] ? $validated['PRE3IVA'] : null;
        $validated['PREPROMOIMP'] = $validated['PREPROMOIMP'] ? $validated['PREPROMOIMP'] : null;
        $validated['PREPROMOIVA'] = $validated['PREPROMOIVA'] ? $validated['PREPROMOIVA'] : null;
        $validated['DATAINIZIOPROMO'] = $validated['DATAINIZIOPROMO'] ? $validated['DATAINIZIOPROMO'] : null;
        $validated['DATAFINEPROMO'] = $validated['DATAFINEPROMO'] ? $validated['DATAFINEPROMO'] : null;


        // Handle `CATEGORIEESOTTOCATEGORIE`
        $categorieHierarchy = [];
        $codice = $request->CATEGORIEESOTTOCATEGORIE;

        // Check for the current category
        $currentCategory = Category::where('codice', $codice)->first();
        $categorieHierarchy[] = $codice;
        // Check for the parent category
        if (substr($codice, -4) !== '0000') {
            $parentCode = substr($codice, 0, -4) . '0000';
            if (substr($codice, -2) !== '00') {
                $parentCode = substr($codice, 0, -2) . '00';
                $categorieHierarchy[] = $parentCode;
            }

            // Check for the grandparent category
            if (strlen($codice) > 4) {
                $grandParentCode = substr($parentCode, 0, -4) . '0000';
                $categorieHierarchy[] = $grandParentCode;
            }
        }
        $validated['CATEGORIEESOTTOCATEGORIE'] = json_encode($categorieHierarchy);
        // if ($currentCategory) {
            
        // }
        


        try {
            $imagePaths = [];
            if ($request->hasFile('FOTO')) {
                foreach ($request->file('FOTO') as $image) {
                    $imgName = uniqid('product_') . '.png';$image->getClientOriginalName();
                    $path = $image->storeAs('public/uploads/products', $imgName);
                    $imagePaths[] = "uploads/products/{$imgName}";
                }
                $validated['FOTO'] = json_encode($imagePaths);
            }
            $product->update($validated);
            return redirect()->route('app.dashboard.products')->with('success', 'Product updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput(request()->all());
        }

    }

    public function update_api(Request $request, $id)
    {
        Log::info("Start update product: ", ['payload' => [...$request->all(), 'FOTO'=>''], 'url'=> request()->url()]);

        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'BARCODE' => 'nullable|string',
            'DESCRIZIONEBREVE' => 'sometimes|required|string',
            'DESCRIZIONEESTESA' => 'sometimes|required|string',
            'ALIQUOTAIVA' => 'sometimes|required|numeric|min:0|max:100',
            'UNITAMISURA' => 'nullable|string|in:PZ,KG,L,CM,M',
            'PXC' => 'nullable|integer|min:1',
            'CODICELEGAME' => 'nullable|string',
            'MARCA' => 'nullable|string',
            'CATEGORIEESOTTOCATEGORIE' => 'nullable|string',
            'GIACENZA' => 'nullable|integer|min:0',
            'ARTICOLIALTERNATIVI' => 'nullable|string',
            'ARTICOLICORRELATI' => 'nullable|string',
            'NOVITA' => 'nullable|boolean',
            'PIUVENDUTI' => 'nullable|boolean',
            'VISIBILE' => 'nullable|boolean',
            'FOTO' => 'nullable|array|max:10',
            'FOTO.*' => 'nullable|string',
            'PESOARTICOLO' => 'nullable|numeric|min:0',
            'TAGLIA' => 'nullable|string',
            'COLORE' => 'nullable|string',
            'PRE1IMP' => 'sometimes|numeric|min:0',
            'PRE1IVA' => 'nullable|numeric|min:0',
            'PRE2IMP' => 'nullable|numeric|min:0',
            'PRE2IVA' => 'nullable|numeric|min:0',
            'PRE3IMP' => 'nullable|numeric|min:0',
            'PRE3IVA' => 'nullable|numeric|min:0',
            'PREPROMOIMP' => 'nullable|numeric|min:0',
            'PREPROMOIVA' => 'nullable|numeric|min:0',
            'DATAINIZIOPROMO' => 'nullable|date',
            'DATAFINEPROMO' => 'nullable|date',
        ]);

        $validated['NOVITA'] = $request->input('NOVITA', false) ? true : false;
        $validated['PIUVENDUTI'] = $request->input('PIUVENDUTI', false) ? true : false;
        $validated['VISIBILE'] = $request->input('VISIBILE', true) ? true : false;
        $validated['PESOARTICOLO'] = $validated['PESOARTICOLO'] ? ['PESOARTICOLO'] : null;
        $validated['PRE1IMP'] = $validated['PRE1IMP'] ? $validated['PRE1IMP'] : null;
        $validated['PRE1IVA'] = $validated['PRE1IVA'] ? $validated['PRE1IVA'] : null;
        $validated['PRE2IMP'] = $validated['PRE2IMP'] ? $validated['PRE2IMP'] : null;
        $validated['PRE2IVA'] = $validated['PRE2IVA'] ? $validated['PRE2IVA'] : null;
        $validated['PRE3IMP'] = $validated['PRE3IMP'] ? $validated['PRE3IMP'] : null;
        $validated['PRE3IVA'] = $validated['PRE3IVA'] ? $validated['PRE3IVA'] : null;
        $validated['PREPROMOIMP'] = $validated['PREPROMOIMP'] ? $validated['PREPROMOIMP'] : null;
        $validated['PREPROMOIVA'] = $validated['PREPROMOIVA'] ? $validated['PREPROMOIVA'] : null;
        $validated['DATAINIZIOPROMO'] = $validated['DATAINIZIOPROMO'] ? $validated['DATAINIZIOPROMO'] : null;
        $validated['DATAFINEPROMO'] = $validated['DATAFINEPROMO'] ? $validated['DATAFINEPROMO'] : null;

        // Handle `CATEGORIEESOTTOCATEGORIE`
        $categorieHierarchy = [];
        $codice = $request->CATEGORIEESOTTOCATEGORIE;

        // Check for the current category
        $currentCategory = Category::where('codice', $codice)->first();
        $categorieHierarchy[] = $codice;
        // Check for the parent category
        if (substr($codice, -4) !== '0000') {
            $parentCode = substr($codice, 0, -4) . '0000';
            if (substr($codice, -2) !== '00') {
                $parentCode = substr($codice, 0, -2) . '00';
                $categorieHierarchy[] = $parentCode;
            }

            // Check for the grandparent category
            if (strlen($codice) > 4) {
                $grandParentCode = substr($parentCode, 0, -4) . '0000';
                $categorieHierarchy[] = $grandParentCode;
            }
        }
        $validated['CATEGORIEESOTTOCATEGORIE'] = json_encode($categorieHierarchy);
        // if ($currentCategory) {
        // }


        $photo = $request->input('FOTO');
        $imagePaths = [];

        $tenant = tenant();
        
        if($photo){
            if($this->isBase64($photo)){
                $decodedImage = base64_decode($photo);
                $filename = uniqid('product_') . '.png';
                $filePath = "uploads/products/{$filename}";
                Storage::disk('public')->put($filePath, $decodedImage);
                $imagePaths[] = $filePath;
            }
            else{
                Log::error("Error -> (Tenant ID: {$tenant->id}): Invalid FOTO", ["errore" => [
                    "numero" => 400,
                    "msg" => "Invalid base64 FOTO",
                    "extra_msg" => ''
                ]]);
                return response()->json([
                    "codice" => "OK",
                    "errore" => [
                        "numero" => 400,
                        "msg" => "Invalid base64 FOTO",
                        "extra_msg" => ''
                    ]
                ]);
            }
        }
        $validated['FOTO'] = json_encode($imagePaths);

        try {
            $product->update($validated);
            Log::info("Success update product");
            return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
        } catch (\Exception $e) {
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            Product::where('id', $id)->delete();
            return redirect()->route('app.dashboard.products')->with('success', 'Product deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }

    private function isBase64($string)
    {
        // Check if the string matches the Base64 pattern
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) {
            // Attempt to decode the string
            $decoded = base64_decode($string, true);

            return $decoded !== false && base64_encode($decoded) === $string;
        }

        return false;
    }

    private function getCategoryInfo(array $categoriesHierarchy)
    {
        foreach ($categoriesHierarchy as $categoryCode) {
            $category = Category::where('codice', $categoryCode)->first();

            if ($category) {
                $children = $category->children;

                if ($children->isNotEmpty()) {
                    return $children;
                } else {
                    return $category;
                }
            }
        }

        return null; // No valid categories found
    }

    function getCategorieHierarchy(string $code): array
    {
        $hierarchy = [];

        $length = strlen($code);

        // Handle based on input length
        if ($length === 2) {
            $level1 = $code . '0000';
            $hierarchy[] = $level1;

        } elseif ($length === 4) {
            $level2 = $code . '00';
            $level1 = substr($code, 0, 2) . '0000';
            $hierarchy[] = $level2;
            $hierarchy[] = $level1;

        } elseif ($length === 6) {
            $level3 = $code;
            $level2 = substr($code, 0, 4) . '00';
            $level1 = substr($code, 0, 2) . '0000';
            $hierarchy[] = $level3;
            $hierarchy[] = $level2;
            $hierarchy[] = $level1;

        } else {
            $hierarchy[] = $code;
        }

        return $hierarchy;
    }
}
