<?php

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

});

Route::fallback(function () {
    return view('not_found');
});
