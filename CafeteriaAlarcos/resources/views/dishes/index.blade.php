@extends('layouts.app')

@section('content')
    <h1>Platos</h1>

    <a class="btn btn-primary" href="{{ route('dishes.create') }}">Crear nuevo ingrediente</a>

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
                        <form action="{{ route('dishes.destroy', $dish['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a class="btn btn-primary" href="{{ route('dishes.edit', $dish['id']) }}">Editar</a>

                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dishes->links() }}
@endsection
