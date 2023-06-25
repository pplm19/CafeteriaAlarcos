@extends('layouts.app')

@section('content')
    <h1>Reservas</h1>

    <a class="btn btn-primary" href="{{ route('userbookings.available') }}">Realizar reserva</a>

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

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

            <th scope="col">Acciones</th>
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
    {{ $userbookings->links() }}
@endsection
