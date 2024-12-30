<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.categories',['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name'       => ['required'],
        ]);

        Category::create($attributes);
        return redirect('/categories');
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
    public function edit(Category $cat)
    {
        //$cat = Category::find($id);
        return view('categories.edit',['cat'=>$cat]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $cat)
    {
        request()->validate([
            'name'=>['required']
           ]);
       // $cat = Category::find($id);
        $cat->update(['name'=>request('name')]);
        return redirect('/categories') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
