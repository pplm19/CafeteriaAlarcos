@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('profile.updatePassword') }}" method="POST">
            @csrf
            @method('PUT')

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row mb-3">
                <label for="oldPassword" class="form-label">Contraseña actual</label>
                <input type="password" name="oldPassword" id="oldPassword"
                    class="form-control @error('oldPassword') is-invalid @enderror">
                @error('oldPassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row mb-3">
                <label for="newPassword" class="form-label">Nueva contraseña</label>
                <input type="password" name="newPassword" id="newPassword"
                    class="form-control @error('newPassword') is-invalid @enderror">
                @error('newPassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row mb-3">
                <label for="newPassword_confirmation" class="form-label">Confirmar nueva contraseña</label>
                <input type="password" name="newPassword_confirmation" id="newPassword_confirmation" class="form-control">
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Editar perfil</button>
            </div>
        </form>
    </div>
@endsection
