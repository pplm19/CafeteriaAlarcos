@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('turns.update', $turn['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $turn['name'] }}" />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Fecha</label>
                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                    value="{{ $turn['date'] }}" />
                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start" class="form-label">Inicio</label>
                <input type="time" name="start" id="start"
                    class="form-control @error('start') is-invalid @enderror" value="{{ $turn['start'] }}" />
                @error('start')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end" class="form-label">Fin</label>
                <input type="time" name="end" id="end" class="form-control @error('end') is-invalid @enderror"
                    value="{{ $turn['end'] }}" />
                @error('end')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" value="{{ $turn['description'] }}" />
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Editar turno</button>
            </div>
        </form>
    </div>
@endsection
