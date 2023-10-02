@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('content')
    <div class="container content pt-10rem">
        <div class="row justify-content-center">
            <div class="col-11 col-md-10 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            Editar plato
                        </h3>

                        <form action="{{ route('dishes.update', $dish['id']) }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="form-floating mt-3">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ $dish['name'] }}"
                                    placeholder="Nombre" required maxlength="255" autofocus />
                                <label for="name"><i class='bx bxs-food-menu'></i> Nombre</label>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-control mt-3">
                                <label for="imageFile" accept="image/*" class="form-label">Imagen</label>
                                <input type="file" name="imageFile" id="imageFile"
                                    class="form-control @error('imageFile') is-invalid @enderror" />

                                @error('imageFile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-control mt-3">
                                <label for="recipe">Receta</label>
                                <input type="file" accept=".pdf" name="recipe" id="recipe"
                                    class="form-control @error('recipe') is-invalid @enderror"
                                    value="{{ $dish['recipe'] }}" />

                                @error('recipe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-floating mt-3">
                                <input type="text" name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    value="{{ $dish['description'] }}" placeholder="Descripción" maxlength="255" />
                                <label for="description"><i class='bx bxs-food-menu'></i> Descripción</label>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <select name="type_id" id="type_id"
                                    class="form-select @error('type_id') is-invalid @enderror" required>
                                    @foreach ($types as $type)
                                        <option value="{{ $type['id'] }}" @selected($dish['type_id'] == $type['id'])>
                                            {{ $type['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="type_id">Tipo de plato</label>

                                @error('type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-control mt-3">
                                <p class="mb-2">Categorías</p>

                                @error('dcategories')
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @foreach ($dcategories as $dcategory)
                                    <div class="form-check">
                                        <input type="checkbox" name="dcategories[]" id="dcategories"
                                            value="{{ $dcategory['id'] }}" class="form-check-input"
                                            @checked($dish['dcategories']->contains('id', $dcategory['id']))>
                                        <label for="dcategories" class="form-check-label">
                                            {{ $dcategory['name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-control mt-3">
                                <p class="mb-2">Ingredientes</p>

                                @error('roles')
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @foreach ($ingredients as $ingredient)
                                    <div class="form-check">
                                        <input type="checkbox" name="ingredients[]" id="ingredients"
                                            value="{{ $ingredient['id'] }}" class="form-check-input"
                                            @checked($dish['ingredients']->contains('id', $ingredient['id']))>
                                        <label for="ingredients" class="form-check-label">
                                            {{ $ingredient['name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-control mt-3">
                                <p class="mb-2">Alérgenos</p>

                                @error('allergens')
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @foreach ($allergens as $allergen)
                                    <div class="form-check">
                                        <input type="checkbox" name="allergens[]" id="allergens"
                                            value="{{ $allergen['id'] }}" class="form-check-input"
                                            @checked($dish['allergens']->contains('id', $allergen['id']))>
                                        <label for="allergens" class="form-check-label">
                                            {{ $allergen['name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme">
                                    <i class='bx bxs-edit-alt'></i> Editar plato
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
