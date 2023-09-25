@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <h1>Historial de reservas</h1>

        <table class="table table-striped">
            <thead>
                <th scope="col" class="text-center align-middle">#</th>
                <th scope="col" class="text-center align-middle">Descripción</th>
                <th scope="col" class="text-center align-middle">Comensales</th>

                <th scope="col" class="text-center align-middle">Nombre del turno</th>
                <th scope="col" class="text-center align-middle">Fecha</th>
                <th scope="col" class="text-center align-middle">Inicio</th>
                <th scope="col" class="text-center align-middle">Fin</th>
                <th scope="col" class="text-center align-middle">Descripción del turno</th>

                <th scope="col" class="text-center align-middle">Mesas</th>

                <th scope="col" class="text-center align-middle">Status</th>
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

                        <td>{{ $userbooking['cancelled'] ? 'Cancelada' : 'Realizada' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $userbookings->links() }}
        </div>
    </div>
@endsection
