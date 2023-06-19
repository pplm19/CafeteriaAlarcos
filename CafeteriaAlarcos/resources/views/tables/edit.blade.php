@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('tables.update', $table['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="quantity" class="form-label">Cantidad</label>
                <input type="number" min="1" name="quantity" id="quantity"
                    class="form-control @error('quantity') is-invalid @enderror" value="{{ $table['quantity'] }}" />
                @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="maxNumber" class="form-label">Máximo</label>
                <input type="number" min="1" name="maxNumber" id="maxNumber"
                    class="form-control @error('maxNumber') is-invalid @enderror" value="{{ $table['maxNumber'] }}" />
                @error('maxNumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="minNumber" class="form-label">Mínimo</label>
                <input type="number" min="1" name="minNumber" id="minNumber"
                    class="form-control @error('minNumber') is-invalid @enderror" value="{{ $table['minNumber'] }}" />
                @error('minNumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" value="{{ $table['description'] }}" />
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Editar mesa</button>
            </div>
        </form>
    </div>
@endsection
