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
    public function edit(Article $article)
    {
        $blog = $article->blog;
        return view('articles.edit',['article'=>$article,'blog'=>$blog]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {

        $attributes = $request->validate([
            'title'  => ['required'],
            'body' =>['required'],
        ]);

        $article->update([
            'title' => $attributes['title'],
            'body' => $attributes['body'],
        ]);

        $blog_id = $article->blog->id;
        return redirect('/articles/'.$blog_id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Blog $blog)
    {
       // dd($request->delete_articles);

        if (is_array( $request->delete_articles) && !empty($request->delete_articles))
        {
            Article::whereIn('id', $request->delete_articles)->delete();
        }
        return redirect('/articles/'.$blog->id);
        /*
          $blog = Blog::find($id);
        if ($blog->image)
        {
            Storage::delete($blog->image);
        }
        $blog->delete();
        return redirect('/blogs');
        */
    }
}
