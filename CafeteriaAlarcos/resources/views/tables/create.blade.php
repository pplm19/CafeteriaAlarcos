@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('tables.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="quantity" class="form-label">Cantidad</label>
                <input type="number" min="1" name="quantity" id="quantity"
                    class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" />
                @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="maxNumber" class="form-label">Máximo</label>
                <input type="number" min="1" name="maxNumber" id="maxNumber"
                    class="form-control @error('maxNumber') is-invalid @enderror" value="{{ old('maxNumber') }}" />
                @error('maxNumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="minNumber" class="form-label">Mínimo</label>
                <input type="number" min="1" name="minNumber" id="minNumber"
                    class="form-control @error('minNumber') is-invalid @enderror" value="{{ old('minNumber') }}" />
                @error('minNumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" />
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Crear mesa</button>
            </div>
        </form>
    </div>
@endsection
