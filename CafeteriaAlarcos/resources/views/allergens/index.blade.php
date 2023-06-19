@extends('layouts.app')

@section('content')
    <h1>Alérgenos</h1>

    <a class="btn btn-primary" href="{{ route('allergens.create') }}">Crear nuevo ingrediente</a>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($allergens as $allergen)
                <tr>
                    <th scope="row">{{ $allergen['id'] }}</th>
                    <td>{{ $allergen['name'] }}</td>
                    <td>
                        <form action="{{ route('allergens.destroy', $allergen['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a class="btn btn-primary" href="{{ route('allergens.edit', $allergen['id']) }}">Editar</a>

                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $allergens->links() }}
@endsection
