<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => ['required', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^\d{9}$/'],
        ]);

        $user = Auth::user();

        $user->update($request->all());

        return redirect()->route('profile.index');
    }
}
