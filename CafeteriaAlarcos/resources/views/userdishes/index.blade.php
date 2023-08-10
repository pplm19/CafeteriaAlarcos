@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Platos</h1>

                        <form action="{{ route('userdishes.index') }}" method="GET" class="needs-validation" novalidate>
                            @csrf

                            <div class="form-floating mt-3">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Nombre" maxlength="255" />
                                <label for="name"><i class='bx bxs-food-menu'></i> Nombre</label>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-control mt-3">
                                <p class="mb-2">Ingredientes</p>
                                @error('ingredients')
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @foreach ($ingredients as $ingredient)
                                    <div class="form-check">
                                        <input type="checkbox" name="ingredients[]" id="ingredients"
                                            value="{{ $ingredient['id'] }}" class="form-check-input"
                                            @checked(in_array($ingredient['id'], old('ingredients', [])))>
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
                                            @checked(in_array($allergen['id'], old('allergens', [])))>
                                        <label for="allergens" class="form-check-label">
                                            {{ $allergen['name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" name="search" class="btn btn-theme">
                                    <i class='bx bxs-search align-middle'></i> Buscar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-center gap-4">
            @foreach ($dishes as $dish)
                <div class="card p-0" style="max-width: 540px;">
                    <div class="row g-0 h-100">
                        @php($imgUrl = asset('storage/images/dishes/' . $dish['image']))
                        @php($hasImg = strpos($imgUrl, $dish['image']))

                        @if ($hasImg)
                            <div class="col-md-4 d-flex justify-content-center">
                                <img src="{{ $imgUrl }}" alt="Imagen de {{ $dish['name'] }}"
                                    class="img-fluid rounded-start">
                            </div>
                        @endif

                        <div class="@if ($hasImg) col-md-8 @else col @endif">
                            <div class="card-body h-100 d-flex flex-column">
                                <h3 class="card-title mb-0">{{ $dish['name'] }}</h3>

                                <p class="card-text"><small class="text-muted">{{ $dish['type']['name'] }}</small></p>

                                <p class="card-text">{{ $dish['description'] }}</p>

                                <ul>
                                    @if (!$dish['dcategories']->isEmpty())
                                        <li class="mb-3">
                                            <h4>Categorías:</h4>
                                            <ul>
                                                @foreach ($dish['dcategories'] as $dcategory)
                                                    <li>{{ $dcategory['name'] }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif

                                    @if (!$dish['ingredients']->isEmpty())
                                        <li class="mb-3">
                                            <h4>Ingredientes:</h4>
                                            <ul>
                                                @foreach ($dish['ingredients'] as $ingredient)
                                                    <li>{{ $ingredient['name'] }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif

                                    @if (!$dish['allergens']->isEmpty())
                                        <li class="mb-3">
                                            <h4>Alérgenos:</h4>
                                            <ul>
                                                @foreach ($dish['allergens'] as $allergen)
                                                    <li>{{ $allergen['name'] }}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                </ul>

                                <div class="mt-auto d-flex justify-content-end">
                                    <a href="#" class="btn btn-primary">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $dishes->links() }}
    </div>
@endsection
