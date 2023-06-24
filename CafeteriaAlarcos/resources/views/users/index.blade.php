@extends('layouts.app')

@section('content')
    <h1>Usuarios</h1>

    <a class="btn btn-primary" href="{{ route('users.create') }}">Crear administrador</a>

    <div class="w-25 mx-auto mb-4">
        <form action="{{ route('users.index') }}" method="GET">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" name="username" id="username"
                    class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" />
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lastname" class="form-label">Apellidos</label>
                <input type="text" name="lastname" id="lastname"
                    class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname') }}" />
                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Número de teléfono</label>
                <input type="tel" name="phone" id="phone"
                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" />
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <span>Roles</span>
                @error('roles')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                @foreach ($roles as $role)
                    <div class="form-check">
                        <input type="checkbox" name="roles[]" id="roles" value="{{ $role['id'] }}"
                            class="form-check-input" @checked(in_array($role['id'], old('roles', [])))>
                        <label for="roles" class="form-check-label">
                            {{ $role['name'] }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" name="search" class="btn btn-primary">Buscar</button>
            </div>
        </form>
    </div>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">
                <a href="{{ route('users.index', ['field' => 'username', 'direction' => old('field') === 'username' ? (old('direction') === 'ASC' ? 'DESC' : 'ASC') : 'ASC']) }}"
                    class="text-decoration-none text-black">Nombre
                    de usuario</a>
            </th>
            <th scope="col">
                <a href="{{ route('users.index', ['field' => 'email', 'direction' => old('field') === 'email' ? (old('direction') === 'ASC' ? 'DESC' : 'ASC') : 'ASC']) }}"
                    class="text-decoration-none text-black">Email</a>
            </th>
            <th scope="col">
                <a href="{{ route('users.index', ['field' => 'name', 'direction' => old('field') === 'name' ? (old('direction') === 'ASC' ? 'DESC' : 'ASC') : 'ASC']) }}"
                    class="text-decoration-none text-black">Nombre</a>
            </th>
            <th scope="col">
                <a href="{{ route('users.index', ['field' => 'lastname', 'direction' => old('field') === 'lastname' ? (old('direction') === 'ASC' ? 'DESC' : 'ASC') : 'ASC']) }}"
                    class="text-decoration-none text-black">Apellido</a>
            </th>
            <th scope="col">
                <a href="{{ route('users.index', ['field' => 'phone', 'direction' => old('field') === 'phone' ? (old('direction') === 'ASC' ? 'DESC' : 'ASC') : 'ASC']) }}"
                    class="text-decoration-none text-black">Teléfono</a>
            </th>
            <th scope="col">
                Roles
            </th>
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
                        <ul>
                            @foreach ($user->getRoleNames() as $role)
                                <li>{{ $role }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <form action="{{ route('users.toggleDisable', $user['id']) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if ($user['disabled'])
                                <button type="submit" class="btn btn-success">Habilitar usuario</button>
                            @else
                                <button type="submit" class="btn btn-danger">Deshabilitar usuario</button>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
