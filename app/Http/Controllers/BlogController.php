<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::where('user_id',Auth::user()->id)->latest()->paginate(10);
        return view('blogs.index',['blogs'=>$blogs]);
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
    public function show(Blog $blog,$page_id)
    {
       // dd("page_id=".$page_id);
        $articles = $blog->articles()->paginate(10);
        return view('blogs.show',['blog'=>$blog,'articles'=>$articles,'page_id'=>$page_id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::find($id);
        return view('blogs.edit',['blog'=>$blog]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // get the original filename
        // $file = $request->file('image');
       // $name = $file->getClientOriginalName();

        // when image is present the $request->image is an object of type UploadedFile
        // when image is not present $request->image is null

        $attributes = $request->validate([
            'subject'  => ['required'],
            'description' =>['required'],
            'image' => ['image','max:2048','unique:blogs,image',File::types(['png', 'jpg', 'jpeg','gif'])]
        ]);

        $blog = Blog::find($id);
        if ($request->image)
        {
            if ( $blog->image)
            {
                Storage::delete($blog->image);
            }
            $image_path = $request->image->store('images');
            $props = [
                'subject' => $attributes['subject'],
                'description' => $attributes['description'],
                'image'=>$image_path
            ];
        }
        else
        {
            $image_path = null;
            $props = [
                'subject' => $attributes['subject'],
                'description' => $attributes['description']
            ];
        }


        $blog->update($props);

        return redirect('/blogs');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        if ($blog->image)
        {
            Storage::delete($blog->image);
        }
        $blog->delete();
        return redirect('/blogs');
    }

    public function show_blogs()
    {
        $blogs = Blog::with('user')->latest()->paginate(5);
        //$jobs = Job::with('employer')->get();
        return view('blogs.front_blogs',['blogs'=>$blogs]);
    }
}
