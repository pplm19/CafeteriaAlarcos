@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('ingredients.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="i_category_id" class="form-label">Categoría</label>
                <select name="i_category_id" id="i_category_id"
                    class="form-select @error('i_category_id') is-invalid @enderror">
                    @if (old('i_category_id', null) === null)
                        <option selected></option>
                    @endif
                    @foreach ($icategories as $icategory)
                        <option value="{{ $icategory['id'] }}" @selected($icategory['id'] == old('i_category_id', null))>
                            {{ $icategory['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('i_category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Crear ingrediente</button>
            </div>
        </form>
    </div>
@endsection
