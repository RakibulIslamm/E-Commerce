<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = News::query();
        $perPage = request()->input('limit', 50);

        if($perPage > 50){
            $perPage = 50;
            request()->merge(['limit' => 50]);
        }
        $news = $query->paginate($perPage);
        $news->appends(request()->all());

        return view("app.pages.dashboard.news.index", ["news" => $news]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("app.pages.dashboard.news.create", ["mode" => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->all('published')['published'] == 'on') {
            $request->merge(['published' => true]);
        } else {
            $request->merge(['published' => false]);
        }

        $validated = $request->validate([
            "title" => "required|string",
            "body" => "required|string",
            "published" => "required|boolean",
            "publication_date" => "required|date",
            "start_date" => "required|date",
            "end_date" => "required|date",
            'cover_img' => 'required|image',
        ]);
        try {

            if ($request->hasFile('cover_img')) {
                $path = $request->file('cover_img')->store('news', 'public');
                $validated['cover_img'] = $path;
            }

            News::create($validated);
            return redirect()->route('app.dashboard.news')->with('success', 'Success');
        } catch (\Exception $e) {
            return back()->with(['error' => 'An error occurred: ' . $e->getMessage()])->withInput(request()->all());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view("app.pages.dashboard.news.edit", ["mode" => 'edit', 'news' => $news]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        try {
            if ($request->all('published')['published'] == 'on') {
                $request->merge(['published' => true]);
            } else {
                $request->merge(['published' => false]);
            }

            $validated = $request->validate([
                "title" => "required|string",
                "body" => "required|string",
                "published" => "required|boolean",
                "publication_date" => "required|date",
                "start_date" => "required|date",
                "end_date" => "required|date",
                "cover_img" => "image",
            ]);

            if ($request->hasFile('cover_img')) {
                $path = $request->file('cover_img')->store('news', 'public');
                $validated['cover_img'] = $path;

                if ($news->cover_img) {
                    Storage::disk('public')->delete($news->cover_img);
                }
            }

            $news->update($validated);

            return redirect()->route('app.dashboard.news')->with('success', 'Updated');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
