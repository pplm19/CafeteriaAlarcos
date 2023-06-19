@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('turns.storeCopyStructure') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="copyFrom" class="form-label">Fecha copia</label>
                <input type="date" name="copyFrom" id="copyFrom" value="{{ $copyFrom }}"
                    class="form-control @error('copyFrom') is-invalid @enderror" readonly>
                @error('copyFrom')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Nueva fecha</label>
                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                    value="{{ old('date') }}" />
                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Copiar estructura de turnos</button>
            </div>
        </form>
    </div>
@endsection
