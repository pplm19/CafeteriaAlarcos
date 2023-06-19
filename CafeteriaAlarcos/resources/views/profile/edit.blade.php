@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" name="username" id="username"
                    class="form-control @error('username') is-invalid @enderror" value="{{ $user['username'] }}" />
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $user['name'] }}" />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lastname" class="form-label">Apellidos</label>
                <input type="text" name="lastname" id="lastname"
                    class="form-control @error('lastname') is-invalid @enderror" value="{{ $user['lastname'] }}" />
                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Número de teléfono</label>
                <input type="tel" name="phone" id="phone"
                    class="form-control @error('phone') is-invalid @enderror" value="{{ $user['phone'] }}" />
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Editar perfil</button>
            </div>
        </form>
    </div>
@endsection
