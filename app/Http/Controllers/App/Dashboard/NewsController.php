<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Models\News;
use Illuminate\Http\Request;
use Storage;

class NewsController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
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
        // dd($request->file('cover_img'));
        $validated = $request->validate([
            "title" => "required|string",
            "body" => "required|string",
            "published" => "required|boolean",
            "publication_date" => "required|date",
            "start_date" => "required|date",
            "end_date" => "required|date",
            'cover_img' => 'required|image',
        ]);

        // dd($validated['cover_img']);

        if ($request->hasFile('cover_img')) {
            $path = $request->file('cover_img')->store('news', 'public');
            $validated['cover_img'] = $path;
        }
        News::create($validated);
        return redirect()->route('app.dashboard.news')->with('success', 'Success');
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
        if ($request->all('published')['published'] == 'on') {
            $request->merge(['published' => true]);
        } else {
            $request->merge(['published' => false]);
        }
        // dd($request->all());
        $validated = $request->validate([
            "title" => "required|string",
            "body" => "required|string",
            "published" => "required|boolean",
            "publication_date" => "required|date",
            "start_date" => "required|date",
            "end_date" => "required|date",
            "cover_img" => "image",
        ]);
        // dd($validated);

        if ($request->hasFile('cover_img')) {

            $path = $request->file('cover_img')->store('news', 'public');
            $validated['cover_img'] = $path;

            if ($news->cover_img) {
                $path = $news->img;
                Storage::disk('public')->delete($path);
            }
        }
        $news->update($validated);

        return redirect()->route('app.dashboard.news')->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
