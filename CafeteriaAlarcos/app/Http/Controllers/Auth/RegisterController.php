<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Notifications\MailNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^\d{9}$/'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
        ]);

        session()->flash('success', 'Tu cuenta ha sido creada, revisa tu correo para verificar el email.');

        Cache::increment('userRequests');

        $admins = User::role('SuperAdmin')->get();

        $notification = new MailNotification([
            'subject' => 'Nuevo usuario por verificar en la aplicación',
            'greeting' => 'Estimado administrador,',
            'line' => 'Le informamos que un nuevo usuario se ha registrado en nuestra aplicación y está pendiente de verificación.',
            'action' => ['text' => 'Verificar Usuario', 'url' => route('users.registerRequests')],
            'salutation' => "En servicio,  \r\n " . config('app.name'),
        ]);

        foreach ($admins as $admin) {
            $admin->notify($notification);
        }

        return $user;
    }
}
