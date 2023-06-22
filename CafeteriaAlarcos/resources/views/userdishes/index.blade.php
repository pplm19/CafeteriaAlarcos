@extends('layouts.app')

@section('content')
    <h1>Platos</h1>

    <div class="w-25 mx-auto mb-4">
        <form action="{{ route('userdishes.index') }}" method="GET">
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
                <span>Ingredientes</span>
                @foreach ($ingredients as $ingredient)
                    <div class="form-check">
                        <input type="checkbox" name="ingredients[]" id="ingredients" value="{{ $ingredient['id'] }}"
                            class="form-check-input" @checked(in_array($ingredient['id'], old('ingredients', [])))>
                        <label for="ingredients" class="form-check-label">
                            {{ $ingredient['name'] }}
                        </label>
                    </div>
                @endforeach
                @error('ingredients')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <span>Alérgenos</span>
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
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" name="search" class="btn btn-primary">Buscar</button>
            </div>
        </form>
    </div>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Imagen</th>
            <th scope="col">Receta</th>
            <th scope="col">Descripción</th>
            <th scope="col">Tipo</th>
            <th scope="col">Categorías</th>
            <th scope="col">Ingredientes</th>
            <th scope="col">Alérgenos</th>
        </thead>

        <tbody>
            @foreach ($dishes as $dish)
                <tr>
                    <th scope="row">{{ $dish['id'] }}</th>
                    <td>{{ $dish['name'] }}</td>
                    <td>
                        @php($imgUrl = asset('storage/images/dishes/' . $dish['image']))
                        @if (strpos($imgUrl, $dish['image']))
                            <img src="{{ $imgUrl }}" alt="Imagen de {{ $dish['name'] }}">
                        @else
                            No hay ninguna imagen asignada a este plato
                        @endif
                    </td>
                    <td>{{ $dish['recipe'] }}</td>
                    <td>{{ $dish['description'] }}</td>
                    <td>{{ $dish['type']['name'] }}</td>
                    <td>
                        <ul>
                            @foreach ($dish['dcategories'] as $dcategory)
                                <li>{{ $dcategory['name'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @foreach ($dish['ingredients'] as $ingredient)
                                <li>{{ $ingredient['name'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @foreach ($dish['allergens'] as $allergen)
                                <li>{{ $allergen['name'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('userdishes.show', $dish['id']) }}">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dishes->links() }}
@endsection
