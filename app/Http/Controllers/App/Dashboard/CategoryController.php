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
        // dd($validated);

        // $parentId = null;
        // if (strlen($request->codice) > 2) {
        //     $parentCode = substr($request->codice, 0, -2);
    
        //     // Find the parent category
        //     $parent = Category::where('codice', $parentCode)->first();
    
        //     if (!$parent) {
        //         return redirect()->route('app.dashboard.categories.create')
        //         ->withErrors(['error' => "Parent category start with code '{$parentCode}' not found, Please create parent category first"])
        //         ->withInput();
        //     }
    
        //     $parentId = $parent->id;
        // }

        try {
            // Update or create category
            if (isset($validated['img'])) {
                $path = $request->file('img')->store('categories', 'public');
                $validated['img'] = $path;
            }

            Category::updateOrCreate(
                ['codice' => $request->codice],
                [...$validated]
                // [...$validated, "parent_id"=> $parentId]
            );

            

            return redirect()->route('app.dashboard.categories')->with('success', 'Success');
        } catch (\Exception $e) {
            return redirect()->route('app.dashboard.categories.create')
                ->withErrors(['error' => 'System error during update: ' . $e->getMessage()])
                ->withInput();
        }
    }


    public function update_api(Request $request)
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
                    'codice' => "KO",
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
                    'codice' => "KO",
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
                    'codice' => "KO",
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
                $path = $request->file('img')->store('categories', 'public');
                $validated['img'] = $path;
            }
            // dd([...$validator->getData(), "parent_id"=> $parentId]);

            $category = Category::updateOrCreate(
                ['codice' => $request->codice],
                [...$validator->getData(), "parent_id"=> $parentId]
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

        $path = $request->file('img')->store('categories', 'public');
        $validated['img'] = $path;

        if ($category->img) {
            $path = $category->img;
            Storage::disk('public')->delete($path);
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
