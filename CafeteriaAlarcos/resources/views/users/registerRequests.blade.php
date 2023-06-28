@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Solicitudes de registro</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
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
        </div>

        {{ $users->links() }}
    </div>
@endsection
