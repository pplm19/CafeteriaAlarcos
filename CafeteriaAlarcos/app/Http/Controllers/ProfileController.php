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

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => ['required', 'max:255'],
            'name' => ['nullable', 'max:255'],
            'lastname' => ['nullable', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^\+\d{2}\s\d{9}$/'],
        ]);

        $user = Auth::user();

        $user->update($request->all());

        return redirect()->route('profile.index');
    }

    public function editPassword()
    {
        return view('profile.editPassword');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => ['required', 'string', 'min:8'],
            'newPassword' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->input('oldPassword'), $user['password'])) {
            return back()->with('error', 'La contraseña actual no coincide');
        }

        $user->update([
            'password' => Hash::make($request->input('newPassword')),
        ]);

        return redirect()->route('profile.index');
    }
}