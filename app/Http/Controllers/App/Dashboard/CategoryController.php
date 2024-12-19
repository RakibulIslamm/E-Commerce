<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController
{
    public function index()
    {
        $categories = Category::all();
        return view('app.pages.dashboard.categories.index', ['dashboard_categories' => $categories]);
    }

    // public function index()
    // {
    //     $categories = Category::with('children')->whereNull('parent_id')->get();

    //     // dd($categories[1]->children[0]->children);

    //     return view('app.pages.dashboard.categories.index', ['categories' => $categories]);
    // }

    public function create()
    {
        return view('app.pages.dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = request()->validate([
            'codice' => 'required|regex:/^\d{2}(\d{2})?(\d{2})?$/',
            'nome' => 'required|string|max:255',
            'img' => 'nullable||image|max:2048',
        ]);

        $parentId = null;
        $codice = $request->codice;

        if (substr($codice, -4) !== '0000') {
            $parentCode = substr($codice, 0, -4) . '0000'; // For second-level or third-level codes
            if (substr($codice, -2) !== '00') {
                $parentCode = substr($codice, 0, -2) . '00';
            }

            // Check if the parent exists
            $parent = Category::where('codice', $parentCode)->first();

            if (!$parent) {
                return redirect()->route('app.dashboard.categories.create')
                ->withErrors(['error' => "La categoria principale inizia con il codice {$parentCode} non trovato. Crea prima la categoria principale"])
                ->withInput();
            }

            $parentId = $parent->id;
        }

        try {
            if (isset($validated['img']) && $request->hasFile('img')) {
                $image = $request->file('img');
                if (!$image->isValid()) {
                    throw new \Exception("The uploaded file is not valid.");
                }
                $imgName = uniqid('category_') . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/category', $imgName);
                $validated['img'] = "uploads/category/{$imgName}";
            }
            Category::updateOrCreate(
                ['codice' => $request->codice],
                [...$validated, "parent_id"=> $parentId]
            );

            

            return redirect()->route('app.dashboard.categories')->with('success', 'Success');
        } catch (\Exception $e) {
            return redirect()->route('app.dashboard.categories.create')
                ->withErrors(['error' => 'System error during update: ' . $e->getMessage()])
                ->withInput();
        }
    }


    /* public function update_api(Request $request)
    {

        $tenant = tenant();
        $validator = Validator::make($request->all(), [
            'codice' => 'required|regex:/^\d{2}(\d{2})?(\d{2})?$/',
            'nome' => 'required|string|max:255',
            'img' => 'nullable||image|max:2048',
        ]);
        // dd($validator);

        if ($validator->fails()) {
            if($validator->errors()->has('codice')){
                Log::error("Validation Error: ", ['request' => $request->all(), 'errore' => [
                        'numero' => 200,
                        'msg' => "Codice categoria mancante",
                        'extra_msg' => $validator->errors()->messages()
                    ]]);
                return response()->json([
                    'codice' => "OK",
                    'errore' => [
                        'numero' => 200,
                        'msg' => "Codice categoria mancante",
                        'extra_msg' => $validator->errors()->messages()
                    ]
                ]);
            }
            
            if($validator->errors()->has('nome')){
                Log::error("Validation Error (Tenant ID: {$tenant->id}): Missing nome.", ['request' => $request->all(), 'errore' => [
                        'numero' => 210,
                        'msg' => "Nome categoria mancante",
                        'extra_msg' => ""
                    ]]);
                return response()->json([
                    'codice' => "OK",
                    'errore' => [
                        'numero' => 210,
                        'msg' => "Nome categoria mancante",
                        'extra_msg' => ""
                    ]
                ]);
            }
        }

        $parentId = null;
        if (strlen($request->codice) > 2) {
            $parentCode = substr($request->codice, 0, -2);
    
            // Find the parent category
            $parent = Category::where('codice', $parentCode)->first();
    
            if (!$parent) {
                return response()->json([
                    'codice' => "OK",
                    'errore' => [
                        'numero' => 210,
                        'msg' => "Parent category start with code '{$parentCode}' not found",
                        'extra_msg' => ""
                    ]
                ]);
            }
    
            $parentId = $parent->id;
        }

        
        try {
            // Update or create category
            if (isset($validated['img'])) {
                $path = $request->file('img')->store('categories', 'public/uploads');
                $validated['img'] = $path;
            }

            $category = Category::updateOrCreate(
                ['codice' => $request->codice],
                [...$validator->getData(), "parent_id"=> $parentId]
                // [...$validator->getData()]
            );

            return response()->json([
                'codice' => "OK",
                'categorie' => $category
            ]);
        } catch (\Exception $e) {
            Log::error("Error (Tenant ID: {$tenant->id}): ", ['request' => $request->all(), 'errore' => [
                'numero' => 299,
                'msg' => "Errore di sistema durante l'aggiornamento",
                'extra_msg' => $e->getMessage()
            ]]);
            return response()->json([
                'codice' => 'KO',
                'errore'=>[
                    "numero" => 299,
                    "msg" => "Errore di sistema durante l'aggiornamento",
                    "extra_msg" => $e->getMessage()
                ]
            ]);
        }
    } */

    public function update_api(Request $request)
    {
        $tenant = tenant();
        $validator = Validator::make($request->all(), [
            'codice' => 'required|regex:/^\d{6}$/',
            'nome' => 'required|string|max:255',
            'img' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('codice')) {
                Log::error("Validation Error: ", ['request' => $request->all(), 'errore' => [
                    'numero' => 200,
                    'msg' => "Codice categoria non valido o mancante",
                    'extra_msg' => $validator->errors()->messages()
                ]]);
                return response()->json([
                    'codice' => "OK",
                    'errore' => [
                        'numero' => 200,
                        'msg' => "Codice categoria non valido o mancante",
                        'extra_msg' => $validator->errors()->messages()
                    ]
                ]);
            }
            
            if ($validator->errors()->has('nome')) {
                Log::error("Validation Error (Tenant ID: {$tenant->id}): Missing nome.", ['request' => $request->all(), 'errore' => [
                    'numero' => 210,
                    'msg' => "Nome categoria mancante",
                    'extra_msg' => ""
                ]]);
                return response()->json([
                    'codice' => "OK",
                    'errore' => [
                        'numero' => 210,
                        'msg' => "Nome categoria mancante",
                        'extra_msg' => ""
                    ]
                ]);
            }
        }

        $parentId = null;
        $codice = $request->codice;

        // Determine if this is a subcategory
        if (substr($codice, -4) !== '0000') {
            $parentCode = substr($codice, 0, -4) . '0000'; // For second-level or third-level codes
            if (substr($codice, -2) !== '00') {
                $parentCode = substr($codice, 0, -2) . '00'; // For third-level codes
            }

            // Check if the parent exists
            $parent = Category::where('codice', $parentCode)->first();

            if (!$parent) {
                Log::error("Error: ", ['request' => $request->all(), 'errore' => [
                    'numero' => 210,
                    'msg' => "Categoria principale con codice '{$parentCode}' non trovata",
                    'extra_msg' => ""
                ]]);
                return response()->json([
                    'codice' => "OK",
                    'errore' => [
                        'numero' => 210,
                        'msg' => "Categoria principale con codice '{$parentCode}' non trovata",
                        'extra_msg' => ""
                    ]
                ]);
            }
            $parentId = $parent->id;
        }

        try {
            // Handle image upload
            $data = $validator->validated();
            if (isset($data['img']) && $request->hasFile('img')) {
                $image = $request->file('img');
                if (!$image->isValid()) {
                    throw new \Exception("The uploaded file is not valid.");
                }
                $imgName = uniqid('category_') . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/category', $imgName);
                $data['img'] = "uploads/category/{$imgName}";
            }

            // Update or create category
            $category = Category::updateOrCreate(
                ['codice' => $codice],
                [...$data, 'parent_id' => $parentId]
            );

            return response()->json([
                'codice' => "OK",
                'categorie' => $category
            ]);
        } catch (\Exception $e) {
            Log::error("Error (Tenant ID: {$tenant->id}): ", ['request' => $request->all(), 'errore' => [
                'numero' => 299,
                'msg' => "Errore di sistema durante l'aggiornamento",
                'extra_msg' => $e->getMessage()
            ]]);
            return response()->json([
                'codice' => 'KO',
                'errore'=>[
                    "numero" => 299,
                    "msg" => "Errore di sistema durante l'aggiornamento",
                    "extra_msg" => $e->getMessage()
                ]
            ]);
        }
    }


    public function edit(Category $category)
    {
        return view('app.pages.dashboard.categories.edit');
    }

    public function update_img(Request $request, Category $category)
    {
        $validated = request()->validate([
            'img' => 'required|image|max:2048'
        ]);

        if (isset($validated['img']) && $request->hasFile('img')) {
            $image = $request->file('img');
            if (!$image->isValid()) {
                throw new \Exception("The uploaded file is not valid.");
            }
            $imgName = uniqid('category_') . '.' . $image->getClientOriginalExtension();
            // dd($imgName);
            $image->storeAs('public/uploads/category', $imgName);
            $validated['img'] = "uploads/category/{$imgName}";
        }
        else{
            return redirect()->back()
            ->withErrors(['error' => 'Invalid Image'])
            ->withInput();
        }

        try {
            // Update or create category
            $category->update($validated);
            return redirect()->route('app.dashboard.categories')->with('success', 'Updated');
        } catch (\Exception $e) {
            return redirect()->route('app.dashboard.categories.edit')
                ->withErrors(['error' => 'System error during update: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $name = $category->nome;
            $category->delete();
            return redirect()->route('app.dashboard.categories')->with('success', "$name Deleted");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error: ' . $e->getMessage()])
                ->withInput();
        }
    }


    private function getCategoryHierarchy($parentId = null)
    {
        return Category::where('parent_id', $parentId)
            ->with('children') // Automatically includes nested children
            ->get();
    }
}
