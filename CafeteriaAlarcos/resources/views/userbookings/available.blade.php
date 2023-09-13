@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <h1>Turnos disponibles</h1>

        <table class="table table-striped-columns">
            <thead>
                <th scope="col" class="text-center align-middle">#</th>
                <th scope="col" class="text-center align-middle">Nombre del turno</th>
                <th scope="col" class="text-center align-middle">Fecha</th>
                <th scope="col" class="text-center align-middle">Inicio</th>
                <th scope="col" class="text-center align-middle">Fin</th>
                <th scope="col" class="text-center align-middle">Descripción del turno</th>

                <th scope="col" class="text-center align-middle">Aforo de local restante</th>
                <th scope="col" class="text-center align-middle">Tipos de mesas disponibles</th>

                <th scope="col" class="text-center align-middle">Acciones</th>
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

        <div class="d-flex justify-content-center d-sm-block">
            {{ $turns->links() }}
        </div>
    </div>
@endsection
