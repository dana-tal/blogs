<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        //$jobs = Job::with('employer')->latest()->simplePaginate(50);
        //return view('jobs.index',['jobs'=>$jobs ]);

        $categories = Category::latest()->paginate(10);
        return view('blogs.categories',['categories'=>$categories]);
    }
}
