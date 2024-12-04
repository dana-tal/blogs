<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('guest')->group( function () { // each of the fallowing routes will go through the guest middleware
    Route::get('/register',[UserController::class,'display_registration_form']);
    Route::post('/register',[UserController::class,'store_registration_info']);
    Route::get('login',[UserController::class,'display_login_form']);
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

});

Route::fallback(function () {
    return view('not_found');
});
