<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            'field' => ['nullable', Rule::in('username', 'email', 'name', 'lastname', 'phone')],
            'direction' => ['nullable', Rule::in('ASC', 'DESC')],
        ]);

        if ($request->has('search')) {
            $searched = false;

            $username = $request->input('username');
            if (strlen($username) > 0) {
                $query->where('username', 'LIKE', '%' . $username . '%');
                $searched = true;
            }

            $email = $request->input('email');
            if (strlen($email) > 0) {
                $query->where('email', 'LIKE', '%' . $email . '%');
                $searched = true;
            }

            $name = $request->input('name');
            if (strlen($name) > 0) {
                $query->where('name', 'LIKE', '%' . $name . '%');
                $searched = true;
            }

            $lastname = $request->input('lastname');
            if (strlen($lastname) > 0) {
                $query->where('lastname', 'LIKE', '%' . $lastname . '%');
                $searched = true;
            }

            $phone = $request->input('phone');
            if (strlen($phone) > 0) {
                $query->where('phone', 'LIKE', '%' . $phone . '%');
                $searched = true;
            }

            if ($request->has('roles')) {
                $roles = $request->input('roles');
                $query->whereHas('roles', function ($subQuery) use ($roles) {
                    $subQuery->whereIn('role_id', $roles);
                });
                $searched = true;
            }

            if ($searched) {
                $request->merge(['search' => true]);

                $request->flash();
            }
        }

        if ($request->has('field')) {
            $orderField = $request->input('field');
            $orderDirection = $request->input('direction', 'ASC');
            $query->orderBy($orderField, $orderDirection);

            $request->flash();
        }

        if (!$request->hasAny(['search', 'field'])) $request->flush();

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
            'phone' => ['nullable', 'string', 'regex:/^\d{9}$/'],
        ]);

        $request->merge([
            'password' => Hash::make($request->input('password')),
        ]);

        $user = User::create($request->all());

        $user->assignRole(['User', 'SuperAdmin']);

        event(new Registered($user));

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

    public function toggleDisable(Request $request)
    {
        $request->validate([
            'user_id' => ['required', Rule::exists(User::class, 'id')],
            'disable_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $userId = $request->input('user_id');
        $disableReason = $request->input('disable_reason');

        $user = User::find($userId);

        $user->update([
            'disabled' => !$user['disabled'],
            'disabled_reason' => $disableReason,
        ]);

        if (count($user['roles']) == 0) {
            if ($user['disabled']) {
                Cache::decrement('userRequests');
            } else {
                Cache::increment('userRequests');
            }
        }

        return back()->with('success', sprintf('El usuario %s ha sido %s.', $user->username, $user['disabled'] ? 'deshabilitado' : 'habilitado'));
    }

    public function registerRequests()
    {
        return view('users.registerRequests', ['users' => User::doesntHave('roles')->paginate(15)]);
    }

    public function accept(User $user)
    {
        $user->assignRole('User');

        Cache::decrement('userRequests');

        return redirect()->route('users.registerRequests')->with('success', sprintf('El usuario %s ha sido aceptado.', $user->username));
    }
}
