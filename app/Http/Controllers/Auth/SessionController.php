<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function store(LoginRequest $request)
    {
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        request()->session()->regenerate();

        return response()->json(Auth::user());
    }

    public function destroy()
    {
        Auth::logout();
    }
}
