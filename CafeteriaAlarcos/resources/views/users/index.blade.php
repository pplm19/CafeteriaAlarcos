@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Usuarios</h1>

                        <form action="{{ route('userdishes.index') }}" method="GET">
                            @csrf

                            <div class="form-floating mt-3">
                                <input type="text" name="username" id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}" placeholder="Nombre de usuario" />
                                <label for="username"><i class="bx bxs-user"></i> Nombre de usuario</label>

                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="Email" />
                                <label for="email"><i class="bx bxs-envelope"></i> Email</label>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Nombre" />
                                <label for="name"><i class="bx bxs-user"></i> Nombre</label>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" name="lastname" id="lastname"
                                    class="form-control @error('lastname') is-invalid @enderror"
                                    value="{{ old('lastname') }}" placeholder="Nombre" />
                                <label for="lastname"><i class="bx bxs-user"></i> Apellidos</label>

                                @error('lastname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="tel" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                    placeholder="Número de teléfono" />
                                <label for="phone"><i class="bx bxs-phone"></i> Número de teléfono</label>

                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-control mt-3">
                                <p class="mb-2">Roles</p>

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

                            <div class="text-center mt-3">
                                <button type="submit" name="search" class="btn btn-theme">
                                    <i class='bx bxs-search align-middle'></i> Buscar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <p class="d-flex justify-content-end">
            <a class="btn btn-theme" href="{{ route('users.create') }}">Crear administrador</a>
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
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
        </div>

        {{ $users->links() }}
    </div>
@endsection
