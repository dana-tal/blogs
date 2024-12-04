<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Blog;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        $articles = $blog->articles()->latest()->paginate(10);
       return view('articles.index',['articles'=>$articles,'blog'=>$blog]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Blog $blog)
    {
        return view('articles.create',['blog'=>$blog]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Blog $blog)
    {
        $attributes = $request->validate([
            'title'  => ['required'],
            'body' =>['required']
        ]);

        Article::create([
            'blog_id'=> $blog->id,
            'title'=>$attributes['title'],
            'body'=>$attributes['body']
        ]);

        return redirect('/articles/'.$blog->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
