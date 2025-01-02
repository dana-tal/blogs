<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',[BlogController::class,'show_blogs'] );

Route::get('/front/blogs', [BlogController::class,'show_blogs']);
Route::get('/front/blog/{blog}/{page_id}',[BlogController::class,'show']);
Route::get('/front/blogs/search/',[BlogController::class,'search']);
Route::get('/front/article/{article}/{page_id}/{parent?}',[ArticleController::class,'show']);
Route::post('/front/add_comment',[CommentController::class,'store']);
Route::get('/front/articles',[ArticleController::class,'show_articles']);
Route::get('/front/articles/search/',[ArticleController::class,'search']);

//Route::get('/search',SearchController::class);

Route::middleware('guest')->group( function () { // each of the fallowing routes will go through the guest middleware
    Route::get('/register',[UserController::class,'display_registration_form']);
    Route::post('/register',[UserController::class,'store_registration_info']);
    Route::get('login',[UserController::class,'display_login_form'])->name('login');
    Route::post('login',[UserController::class,'perform_login']);
} );


Route::middleware('auth')->group( function () {
    Route::delete('logout',[UserController::class,'perform_logout']);
    Route::get('manage_blog',[ManageController::class,'index']);
    Route::get('/categories',[CategoryController::class,'index'])->can('viewAny',App\Models\Category::class);
    Route::get('/categories/add',[CategoryController::class,'create'])->can('create',App\Models\Category::class);
    Route::post('/categories',[CategoryController::class,'store'])->can('store',App\Models\Category::class);
    Route::get('/categories/edit/{cat}',[CategoryController::class,'edit'])->can('edit','cat');
    Route::patch('/categories/{cat}',[CategoryController::class,'update'])->can('update','cat');

    Route::get('/tags',[TagController::class,'index'])->can('viewAny',App\Models\Tag::class);
    Route::get('/tags/edit/{tag}',[TagController::class,'edit'])->can('edit', 'tag');
    Route::patch('/tags/{tag}',[TagController::class,'update'])->can('update','tag');
    Route::delete('/tags',[TagController::class,'destroy'])->can('delete',App\Models\Tag::class);


    Route::get('/blogs',[BlogController::class,'index']);
    Route::get('/blogs/add',[BlogController::class,'create']);
    Route::post('/blogs',[BlogController::class,'store']);
    Route::get('/blogs/edit/{blog}',[BlogController::class,'edit'])->can('edit','blog');
    Route::patch('/blogs/{blog}',[BlogController::class,'update'])->can('update','blog');
    Route::delete('/blogs/{blog}',[BlogController::class,'destroy'])->can('delete','blog');

    Route::get('/articles/{blog}',[ArticleController::class,'index']);
    Route::get('/articles/add/{blog}',[ArticleController::class,'create']);
    Route::post('/articles/{blog}',[ArticleController::class,'store']);
    Route::get('/articles/edit/{article}',[ArticleController::class,'edit']);
    Route::patch('/articles/{article}',[ArticleController::class,'update']);
    Route::delete('/articles/{blog}',[ArticleController::class,'destroy']);
});

Route::fallback(function () {
    return view('not_found');
});
