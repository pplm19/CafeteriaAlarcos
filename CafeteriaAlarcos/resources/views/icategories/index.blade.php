@extends('layouts.app')

@section('content')
    <h1>Categorías de ingredientes</h1>

    <a class="btn btn-primary" href="{{ route('icategories.create') }}">Crear nuevo ingrediente</a>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($icategories as $icategory)
                <tr>
                    <th scope="row">{{ $icategory['id'] }}</th>
                    <td>{{ $icategory['name'] }}</td>
                    <td>
                        <form action="{{ route('icategories.destroy', $icategory['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a class="btn btn-primary" href="{{ route('icategories.edit', $icategory['id']) }}">Editar</a>

                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $icategories->links() }}
@endsection
