@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('menus.update', $menu['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $menu['name'] }}" />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" value="{{ $menu['description'] }}" />
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Editar menu</button>
            </div>
        </form>
    </div>
@endsection
