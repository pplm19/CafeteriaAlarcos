@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <h1>Reservas</h1>

        <a class="btn btn-primary" href="{{ route('userbookings.available') }}">Realizar reserva</a>

        <table class="table table-striped-columns">
            <thead>
                <th scope="col">Descripción</th>
                <th scope="col">Comensales</th>

                <th scope="col">Nombre del turno</th>
                <th scope="col">Fecha</th>
                <th scope="col">Inicio</th>
                <th scope="col">Fin</th>
                <th scope="col">Descripción del turno</th>

                <th scope="col">Mesas</th>

                <th scope="col">Acciones</th>
            </thead>

            <tbody>
                @foreach ($userbookings as $userbooking)
                    <tr>
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

                        <td>
                            <form action="{{ route('userbookings.cancel', $userbooking['id']) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <button type="submit" class="btn btn-danger">Cancelar reserva</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $userbookings->links() }}
        </div>
    </div>
@endsection
