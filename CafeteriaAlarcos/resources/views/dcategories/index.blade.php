@extends('layouts.app')

@section('content')
    <h1>Categorías de platos</h1>

    <a class="btn btn-primary" href="{{ route('dcategories.create') }}">Crear nuevo ingrediente</a>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($dcategories as $dcategory)
                <tr>
                    <th scope="row">{{ $dcategory['id'] }}</th>
                    <td>{{ $dcategory['name'] }}</td>
                    <td>
                        <form action="{{ route('dcategories.destroy', $dcategory['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a class="btn btn-primary" href="{{ route('dcategories.edit', $dcategory['id']) }}">Editar</a>

                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dcategories->links() }}
@endsection
