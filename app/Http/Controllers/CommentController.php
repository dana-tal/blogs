<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'comment'  => ['required'],
            'user_id' => ['required'],
            'article_id' =>['required'],
            'page_id'=>['required']
            ]);

        Comment::create([
                'article_id' =>$attributes['article_id'],
                'user_id' => $attributes['user_id'],
                'comment' => $attributes['comment']
            ]);

            $page_id = $attributes['page_id'];
            $article_id = $attributes['article_id'];

            return redirect('/front/article/'.$article_id.'/'.$page_id);
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
