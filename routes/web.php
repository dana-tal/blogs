<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',[BlogController::class,'show_blogs'] );

Route::get('/front/blogs', [BlogController::class,'show_blogs']);
Route::get('/front/blog/{blog}/{page_id}',[BlogController::class,'show']);
Route::get('/front/blogs/search/',[BlogController::class,'search']);
Route::get('/front/article/{article}/{page_id}/{parent?}',[ArticleController::class,'show']);
Route::post('/front/add_comment',[CommentController::class,'store']);
Route::get('/front/articles',[ArticleController::class,'show_articles']);

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
    Route::get('/categories',[CategoryController::class,'index']);
    Route::get('/categories/add',[CategoryController::class,'create']);
    Route::post('/categories',[CategoryController::class,'store']);
    Route::get('/categories/edit/{id}',[CategoryController::class,'edit']);
    Route::patch('/categories/{id}',[CategoryController::class,'update']);

    Route::get('/blogs',[BlogController::class,'index']);
    Route::get('/blogs/add',[BlogController::class,'create']);
    Route::post('/blogs',[BlogController::class,'store']);
    Route::get('/blogs/edit/{id}',[BlogController::class,'edit']);
    Route::patch('/blogs/{id}',[BlogController::class,'update']);
    Route::delete('/blogs/{id}',[BlogController::class,'destroy']);

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
