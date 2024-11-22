<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController
{
    public function index()
    {
        $categories = Category::all();
        return view('app.pages.dashboard.categories.index', ['categories' => $categories]);
    }

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
            'codice' => 'required|string|max:6',
            'nome' => 'required|string|max:255',
            'img' => 'nullable||image|max:2048',
        ]);
        // dd($validated);

        try {
            // Update or create category
            if (isset($validated['img'])) {
                $path = $request->file('img')->store('categories', 'public');
                $validated['img'] = $path;
            }
            $codice = $validated['codice'];
            Category::updateOrCreate(
                ['codice' => $codice],
                $validated
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


        $validator = Validator::make($request->all(), [
            'codice' => 'required|regex:/^\d{2}(\d{2})?(\d{2})?$/',
            'nome' => 'required|string|max:255',
            'img' => 'nullable||image|max:2048',
        ]);
        // dd($validator);

        if ($validator->fails()) {
            if($validator->errors()->has('codice')){
                return response()->json([
                    'codice' => "KO",
                    'errore' => [
                        'numero' => 200,
                        'msg' => "Codice categoria mancante",
                        'extra_msg' => ""
                    ]
                ]);
            }
            if($validator->errors()->has('nome')){
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

        try {
            // Update or create category
            if (isset($validated['img'])) {
                $path = $request->file('img')->store('categories', 'public');
                $validated['img'] = $path;
            }

            $category = Category::updateOrCreate(
                ['codice' => $request->codice],
                $validator->getData()
            );

            return response()->json([
                'codice' => "OK",
                'categorie' => $category
            ]);
        } catch (\Exception $e) {
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
        $name = $category->nome;
        $category->delete();
        return redirect()->route('app.dashboard.categories')->with('success', "$name Deleted");
    }
}
