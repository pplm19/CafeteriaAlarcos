<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

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
                ],
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
                $query->whereHas('roles', function ($sq) use ($roles) {
                    $sq->whereIn('role_id', $roles);
                });
            }
        }

        if ($request->has('field')) {
            $orderField = $request->input('field');
            $orderDirection = $request->input('direction', 'ASC');
            $query->orderBy($orderField, $orderDirection);
        }

        if ($request->hasAny(['search', 'field'])) $request->flash();

        return view('users.index', ['users' => $query->paginate(15), 'roles' => Role::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

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
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user, 'roles' => Role::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => [
                'nullable',
                'array',
                Rule::exists(Role::class, 'id')
            ],
        ]);

        $roles = $request->input('roles');

        $user->syncRoles($roles);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
