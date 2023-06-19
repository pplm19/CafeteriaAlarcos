@extends('layouts.app')

@section('content')
    <h1>Mesas</h1>

    <a class="btn btn-primary" href="{{ route('tables.create') }}">Crear nueva mesa</a>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Máximo</th>
            <th scope="col">Mínimo</th>
            <th scope="col">Descripción</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($tables as $table)
                <tr>
                    <th scope="row">{{ $table['id'] }}</th>
                    <td>{{ $table['quantity'] }}</td>
                    <td>{{ $table['maxNumber'] }}</td>
                    <td>{{ $table['minNumber'] }}</td>
                    <td>{{ $table['description'] }}</td>
                    <td>
                        <form action="{{ route('tables.destroy', $table['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a class="btn btn-primary" href="{{ route('tables.edit', $table['id']) }}">Editar</a>

                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tables->links() }}
@endsection
