<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return view('tags.index',['tags'=>$tags]);
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
    public function edit(Tag $tag)
    {
      //  $tag = Tag::find($id);
        return view('tags.edit',['tag'=>$tag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        request()->validate([
            'name'=>['required']
           ]);
        $tag->update(['name'=>request('name')]);
        return redirect('/tags') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $tag_ids = request('tags') ;
        foreach($tag_ids as $tag_id)
        {
            $tag = Tag::find($tag_id);
            Tag::remove_tag($tag);
        }
        return redirect('/tags');
    }
}
