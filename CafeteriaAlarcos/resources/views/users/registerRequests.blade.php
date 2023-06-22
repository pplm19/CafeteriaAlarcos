@extends('layouts.app')

@section('content')
    <h1>Usuarios</h1>

    <a class="btn btn-primary" href="{{ route('users.create') }}">Crear administrador</a>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre de usuario</th>
            <th scope="col">Email</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user['id'] }}</th>
                    <td>{{ $user['username'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ isset($user['lastname']) ? $user['lastname'] : 'N/A' }}</td>
                    <td>{{ isset($user['phone']) ? $user['phone'] : 'N/A' }}</td>
                    <td>
                        <form action="{{ route('users.accept', $user['id']) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <button type="submit" class="btn btn-success">Aceptar usuario</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
