<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use Storage;
use Validator;

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
            return response()->json([
                'error' => $validator->errors()->first(),
                'code' => $validator->errors()->has('codice') ? 200 : 210,
            ]);
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
                'success' => true,
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'System error during update',
                'code' => 299,
                'extra_msg' => $e->getMessage()
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
