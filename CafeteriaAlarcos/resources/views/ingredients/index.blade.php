@extends('layouts.app')

@section('content')
    <h1>Ingredientes</h1>

    <a class="btn btn-primary" href="{{ route('ingredients.create') }}">Crear nuevo ingrediente</a>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Categoría</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($ingredients as $ingredient)
                <tr>
                    <th scope="row">{{ $ingredient['id'] }}</th>
                    <td>{{ $ingredient['name'] }}</td>
                    <td>{{ $ingredient['icategory']['name'] }}</td>
                    <td>
                        <form action="{{ route('ingredients.destroy', $ingredient['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a class="btn btn-primary" href="{{ route('ingredients.edit', $ingredient['id']) }}">Editar</a>

                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $ingredients->links() }}
@endsection
