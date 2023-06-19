@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('users.update', $user['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" id="username" class="form-control" value="{{ $user['username'] }}" readonly />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" class="form-control" value="{{ $user['email'] }}" readonly />
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" id="name" class="form-control" value="{{ $user['name'] }}" readonly />
            </div>

            <div class="mb-3">
                <span>Roles</span>
                @foreach ($roles as $role)
                    <div class="form-check">
                        <input type="checkbox" name="roles[]" id="roles" value="{{ $role['id'] }}"
                            class="form-check-input" @checked($user['roles']->contains('id', $role['id']))>
                        <label for="roles" class="form-check-label">
                            {{ $role['name'] }}
                        </label>
                    </div>
                @endforeach
                @error('roles')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Editar permisos</button>
            </div>
        </form>
    </div>
@endsection
