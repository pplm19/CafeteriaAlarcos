@extends('layouts.app')

@section('content')
    <h1>Historial de reservas</h1>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Descripción</th>
            <th scope="col">Comensales</th>

            <th scope="col">Nombre del turno</th>
            <th scope="col">Fecha</th>
            <th scope="col">Inicio</th>
            <th scope="col">Fin</th>
            <th scope="col">Descripción del turno</th>

            <th scope="col">Mesas</th>
        </thead>

        <tbody>
            @foreach ($userbookings as $userbooking)
                <tr>
                    <th scope="row">{{ $userbooking['id'] }}</th>
                    <th>{{ $userbooking['description'] }}</th>
                    <td>{{ $userbooking['bookingTables']->sum('guests') }}</td>

                    <td>{{ $userbooking['turn']['name'] }}</td>
                    <td>{{ $userbooking['turn']['date'] }}</td>
                    <td>{{ $userbooking['turn']['start'] }}</td>
                    <td>{{ $userbooking['turn']['end'] }}</td>
                    <td>{{ $userbooking['turn']['description'] }}</td>

                    <td>
                        <ul>
                            @foreach ($userbooking['tables'] as $table)
                                <li>
                                    {{ $table['minNumber'] }} - {{ $table['maxNumber'] }} comensales
                                    @isset($table['description'])
                                        - {{ $table['description'] }}
                                    @endisset
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $userbookings->links() }}
@endsection
