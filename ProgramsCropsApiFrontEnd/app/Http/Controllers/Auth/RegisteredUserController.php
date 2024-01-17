<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.Register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:8',
            'email' => 'required|string|email|max:255|min:8|unique:users',
            'password' => ['required', 'confirmed', Password::default()]
        ]);

        User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]
        );

        return redirect()->route('login');
    }
}
