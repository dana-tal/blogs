<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
     public function display_registration_form()
     {
        return view ('auth.register');
     }

     public function store_registration_info(Request $request)
     {
        $userAttributes = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);
        $user = User::create($userAttributes);
        Auth::login($user);
        return redirect('/');
     }

     public function display_login_form()
     {
        return view('auth.login');
     }

     public function perform_login()
     {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (! Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.',
            ]);
        }
        request()->session()->regenerate();
        return redirect('/');
     }

     public function perform_logout()
     {
         Auth::logout();
         return redirect('/');
     }
}
