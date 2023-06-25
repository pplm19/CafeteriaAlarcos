@extends('layouts.app')

@section('content')
    <h1>Turnos disponibles</h1>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre del turno</th>
            <th scope="col">Fecha</th>
            <th scope="col">Inicio</th>
            <th scope="col">Fin</th>
            <th scope="col">Descripción del turno</th>

            <th scope="col">Aforo de local restante</th>
            <th scope="col">Tipos de mesas disponibles</th>

            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($turns as $turn)
                <tr>
                    <th scope="row">{{ $turn['id'] }}</th>

                    <td>{{ $turn['name'] }}</td>
                    <td>{{ $turn['date'] }}</td>
                    <td>{{ $turn['start'] }}</td>
                    <td>{{ $turn['end'] }}</td>
                    <td>{{ $turn['description'] }}</td>

                    <td>{{ $turn['turn_remaining_guests'] }}</td>
                    <td>{{ $turn['tables_remaining'] }}</td>

                    <td>
                        <a class="btn btn-primary" href="{{ route('userbookings.create', $turn['id']) }}">
                            Consultar mesas disponibles
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $turns->links() }}
@endsection
