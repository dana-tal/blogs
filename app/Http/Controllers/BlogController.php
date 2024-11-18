<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('blogs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'subject'  => ['required'],
            'description' =>['required'],
            'image' => ['image','max:2048','unique:blogs,image',File::types(['png', 'jpg', 'jpeg','gif'])]
        ]);

        if ($request->image)
        {
            $image_path = $request->image->store('images');
        }
        else
        {
            $image_path = null;
        }


        Blog::create([
            'user_id' => Auth::user()->id,
            'subject' => $attributes['subject'],
            'description' => $attributes['description'],
            'image'=>$image_path
        ]);

        return redirect('/blogs');
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
