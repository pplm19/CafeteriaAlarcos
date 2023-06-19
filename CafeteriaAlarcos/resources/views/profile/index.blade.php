@extends('layouts.app')

@section('content')
    <h1>Perfil</h1>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre de usuario</th>
            <th scope="col">Email</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Roles</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            <tr>
                <th scope="row">{{ $user['id'] }}</th>
                <td>{{ $user['username'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['name'] }}</td>
                <td>{{ isset($user['lastname']) ? $user['lastname'] : 'N/A' }}</td>
                <td>{{ isset($user['phone']) ? $user['phone'] : 'N/A' }}</td>
                <td>
                    <ul>
                        @foreach ($user->getRoleNames() as $role)
                            <li>{{ $role }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a class="btn btn-primary" href="{{ route('profile.edit') }}">Editar</a>
                    <a class="btn btn-primary" href="{{ route('profile.editPassword') }}">Cambiar contraseña</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
