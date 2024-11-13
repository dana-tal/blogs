<?php

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

Route::delete('logout',[UserController::class,'perform_logout']);
