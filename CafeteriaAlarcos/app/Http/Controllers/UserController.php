<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::has('roles');

        if ($request->has('search')) {
            $request->validate([
                'username' => ['nullable', 'string', 'max:255'],
                'email' => ['nullable', 'string', 'email', 'max:255'],
                'name' => ['nullable', 'string', 'max:255'],
                'lastname' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'string'],
                'roles' => [
                    'nullable',
                    'array',
                    Rule::exists(Role::class, 'id')
                ]
            ]);

            $username = $request->input('username');
            if (strlen($username) > 0) {
                $query->where('username', 'LIKE', '%' . $username . '%');
            }

            $email = $request->input('email');
            if (strlen($email) > 0) {
                $query->where('email', 'LIKE', '%' . $email . '%');
            }

            $name = $request->input('name');
            if (strlen($name) > 0) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            }

            $lastname = $request->input('lastname');
            if (strlen($lastname) > 0) {
                $query->where('lastname', 'LIKE', '%' . $lastname . '%');
            }

            $phone = $request->input('phone');
            if (strlen($phone) > 0) {
                $query->where('phone', 'LIKE', '%' . $phone . '%');
            }

            if ($request->has('roles')) {
                $roles = $request->input('roles');
                $query->whereHas('roles', function ($subQuery) use ($roles) {
                    $subQuery->whereIn('role_id', $roles);
                });
            }

            $request->merge(['search' => true]);
        }

        if ($request->has('field')) {
            $orderField = $request->input('field');
            $orderDirection = $request->input('direction', 'ASC');
            $query->orderBy($orderField, $orderDirection);
        }

        if ($request->hasAny(['search', 'field'])) $request->flash();
        else $request->flush();

        return view('users.index', ['users' => $query->paginate(15), 'roles' => Role::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^\+\d{2}\s\d{9}$/'],
        ]);

        $request->merge([
            'password' => Hash::make($request->input('password')),
        ]);

        $user = User::create($request->all());

        $user->assignRole(['User', 'SuperAdmin']);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    // public function show(User $user)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(User $user)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, User $user)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(User $user)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function toggleDisable(User $user)
    {
        $user->update([
            'disabled' => !$user['disabled']
        ]);

        return redirect()->route('users.index')->with('success', sprintf('El usuario %s ha sido %s.', $user->username, $user['disabled'] ? 'deshabilitado' : 'habilitado'));
    }

    public function registerRequests()
    {
        return view('users.registerRequests', ['users' => User::doesntHave('roles')->paginate(15)]);
    }

    public function accept(User $user)
    {
        $user->assignRole('User');

        return redirect()->route('users.registerRequests')->with('success', sprintf('El usuario %s ha sido aceptado.', $user->username));
    }
}
