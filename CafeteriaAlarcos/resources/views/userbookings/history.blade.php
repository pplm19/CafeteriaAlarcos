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

            <th scope="col">Máximo</th>
            <th scope="col">Mínimo</th>
            <th scope="col">Descripción de la mesa</th>
        </thead>

        <tbody>
            @foreach ($userbookings as $userbooking)
                <tr>
                    <th scope="row">{{ $userbooking['booking_id'] }}</th>
                    <th>{{ $userbooking['booking_description'] }}</th>
                    <th>{{ $userbooking['guests'] }}</th>

                    <td>{{ $userbooking['turn']['name'] }}</td>
                    <td>{{ $userbooking['turn']['date'] }}</td>
                    <td>{{ $userbooking['turn']['start'] }}</td>
                    <td>{{ $userbooking['turn']['end'] }}</td>
                    <td>{{ $userbooking['turn']['description'] }}</td>

                    <td>{{ $userbooking['table']['maxNumber'] }}</td>
                    <td>{{ $userbooking['table']['minNumber'] }}</td>
                    <td>{{ $userbooking['table']['description'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $userbookings->links() }}
@endsection
