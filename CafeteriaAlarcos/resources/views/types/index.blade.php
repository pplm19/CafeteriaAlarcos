@extends('layouts.app')

@section('content')
    <h1>Categorías de ingredientes</h1>

    <a class="btn btn-primary" href="{{ route('types.create') }}">Crear nuevo ingrediente</a>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($types as $type)
                <tr>
                    <th scope="row">{{ $type['id'] }}</th>
                    <td>{{ $type['name'] }}</td>
                    <td>
                        <form action="{{ route('types.destroy', $type['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a class="btn btn-primary" href="{{ route('types.edit', $type['id']) }}">Editar</a>

                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $types->links() }}
@endsection
