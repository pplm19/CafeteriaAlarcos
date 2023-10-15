@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-2 px-md-4 px-lg-5 row g-0">
        <div class="col-12 col-lg-4 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Platos</h1>

                    <form action="{{ route('userdishes.index') }}" method="GET" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-floating mt-3">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Nombre" maxlength="255" />
                            <label for="name">Nombre</label>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-control mt-3">
                            <p class="mb-2">Ingredientes</p>

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

                            @error('ingredients')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-control mt-3">
                            <p class="mb-2">Alérgenos</p>

                            @foreach ($allergens as $allergen)
                                <div class="form-check">
                                    <input type="checkbox" name="allergens[]" id="allergens" value="{{ $allergen['id'] }}"
                                        class="form-check-input" @checked(in_array($allergen['id'], old('allergens', [])))>
                                    <label for="allergens" class="form-check-label">
                                        {{ $allergen['name'] }}
                                    </label>
                                </div>
                            @endforeach

                            @error('allergens')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
                            <button type="submit" name="search" class="btn btn-theme">
                                <i class='bx bxs-search align-middle'></i> Buscar
                            </button>
                            @if (old('search', false))
                                <a href="{{ route('userdishes.index') }}" class="btn btn-theme">
                                    <i class="bi bi-eraser-fill"></i> Borrar búsqueda
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @if (count($dishes) === 0)
            <div class="col-12 col-lg-8 col-xl-9 ps-lg-3 pt-3 pt-lg-5 text-center align-middle">
                <h2>No se ha encontrado ningún plato</h2>
            </div>
        @else
            <div
                class="col-12 col-lg-8 col-xl-9 ps-lg-3 pt-3 pt-lg-0 row g-0 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                @foreach ($dishes as $dish)
                    <div class="col px-0 px-md-3 mb-4">
                        <div class="card h-100">
                            @php($imgUrl = asset('storage/images/dishes/' . $dish['image']))
                            @php($hasImg = strpos($imgUrl, $dish['image']))
                            @if ($hasImg)
                                <a href="">
                                    <img src="{{ $imgUrl }}" alt="Imagen de {{ $dish['name'] }}"
                                        class="card-img-top">
                                </a>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title mb-0">
                                    <a href="">{{ $dish['name'] }}</a>
                                </h3>

                                <p class="card-text"><small class="text-muted">{{ $dish['type']['name'] }}</small></p>

                                @isset($dish['description'])
                                    <p class="card-text">{{ $dish['description'] }}</p>
                                @endisset

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
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="w-100 ps-sm-4 pe-sm-3 d-flex justify-content-center d-sm-block">
                    {{ $dishes->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
