@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('dishes.update', $dish['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $dish['name'] }}" />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="imageFile" class="form-label">Imagen</label>
                <input type="file" name="imageFile" id="imageFile"
                    class="form-control @error('imageFile') is-invalid @enderror"" />
                @error('imageFile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="recipe" class="form-label">Receta</label>
                <input type="text" name="recipe" id="recipe"
                    class="form-control @error('recipe') is-invalid @enderror" value="{{ $dish['recipe'] }}" />
                @error('recipe')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" value="{{ $dish['description'] }}" />
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type_id" class="form-label">Tipo</label>
                <select name="type_id" id="type_id" class="form-select @error('type_id') is-invalid @enderror">
                    @foreach ($types as $type)
                        <option value="{{ $type['id'] }}" @selected($dish['type_id'] == $type['id'])>
                            {{ $type['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('type_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <span>Categorías</span>
                @error('dcategories')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                @foreach ($dcategories as $dcategory)
                    <div class="form-check">
                        <input type="checkbox" name="dcategories[]" id="dcategories" value="{{ $dcategory['id'] }}"
                            class="form-check-input" @checked($dish['dcategories']->contains('id', $dcategory['id']))>
                        <label for="dcategories" class="form-check-label">
                            {{ $dcategory['name'] }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <span>Ingredientes</span>
                @error('ingredients')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                @foreach ($ingredients as $ingredient)
                    <div class="form-check">
                        <input type="checkbox" name="ingredients[]" id="ingredients" value="{{ $ingredient['id'] }}"
                            class="form-check-input" @checked($dish['ingredients']->contains('id', $ingredient['id']))>
                        <label for="ingredients" class="form-check-label">
                            {{ $ingredient['name'] }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <span>Alérgenos</span>
                @error('allergens')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                @foreach ($allergens as $allergen)
                    <div class="form-check">
                        <input type="checkbox" name="allergens[]" id="allergens" value="{{ $allergen['id'] }}"
                            class="form-check-input" @checked($dish['allergens']->contains('id', $allergen['id']))>
                        <label for="allergens" class="form-check-label">
                            {{ $allergen['name'] }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Editar plato</button>
            </div>
        </form>
    </div>
@endsection
