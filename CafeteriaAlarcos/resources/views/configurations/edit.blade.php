@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('configurations.update', $configuration['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $configuration['name'] }}"
                    readonly />
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Valor</label>
                <input type="text" name="value" id="value"
                    class="form-control @error('value') is-invalid @enderror" value="{{ $configuration['value'] }}" />
                @error('value')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Editar configuración</button>
            </div>
        </form>
    </div>
@endsection
