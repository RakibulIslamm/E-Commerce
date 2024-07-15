<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Str;
use Validator;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $product['FOTO'] = json_decode($product->FOTO, true);
            // $categoryName = $product->category->nome;
            // dd($categoryName);
        }
        // dd($products['FOTO']);
        // dd($products);

        return view("app.pages.dashboard.products.index", ["products" => $products]);
    }
    function products_api()
    {
        try {
            $products = Product::all();

            return response()->json([
                "products" => $products,
                "message" => "Products retrieved successfully",
                "status" => "success",
                "code" => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "code" => $e->getCode(),
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view("app.pages.dashboard.products.create", ["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
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
            'PRE1IMP' => 'required|numeric|min:0',
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
    }

    public function store_api(Request $request)
    {
        // dd($request->all('FOTO'));

        $rules = [
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
            'PRE1IMP' => 'required|numeric|min:0',
            'PRE1IVA' => 'nullable|numeric|min:0',
            'PRE2IMP' => 'nullable|numeric|min:0',
            'PRE2IVA' => 'nullable|numeric|min:0',
            'PRE3IMP' => 'nullable|numeric|min:0',
            'PRE3IVA' => 'nullable|numeric|min:0',
            'PREPROMOIMP' => 'nullable|numeric|min:0',
            'PREPROMOIVA' => 'nullable|numeric|min:0',
            'DATAINIZIOPROMO' => 'nullable|date',
            'DATAFINEPROMO' => 'nullable|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        $validated = $validator->validated();

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

        // dd($validated);


        $images = [];
        // dd($validated['FOTO']);
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
            $product = Product::create($validated);

            return response()->json([
                'message' => 'Product added successfully',
                'product' => $product,
                'code' => 201,
                'status' => 'success',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "code" => $e->getCode(),
                "message" => $e->getMessage()
            ], 400);
        }
    }

    public function articolo_esistente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_articolo' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }
        $validated = $validator->validated();
        $id_articolo = $validated['id_articolo'];

        try {
            $product = Product::where('id', $id_articolo)->exists();

            return response()->json([
                'codice' => 'OK',
                'presente' => $product ? 1 : 0,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'codice' => '100',
                'message' => $e->getMessage(),
            ], 500);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    public function update_api(Request $request, $id)
    {
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

        $product->update($validated);

        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route('app.dashboard.products')->with('success', 'Product deleted');
    }
}
