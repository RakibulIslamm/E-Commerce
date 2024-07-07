<?php

namespace App\Http\Controllers\App;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return view("app.pages.dashboard.articles.index", ["articles" => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("app.pages.dashboard.articles.create", ["mode" => 'create']);
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
            $path = $request->file('cover_img')->store('articles', 'public');
            $validated['cover_img'] = $path;
        }
        Article::create($validated);
        return redirect()->route('app.dashboard.articles')->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view("app.pages.dashboard.articles.edit", ["mode" => 'edit', 'article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
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
            $path = $request->file('cover_img')->store('articles', 'public');
            $validated['cover_img'] = $path;
        }
        $article->update($validated);

        return redirect()->route('app.dashboard.articles')->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
