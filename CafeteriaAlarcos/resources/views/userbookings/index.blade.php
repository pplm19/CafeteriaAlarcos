@extends('layouts.app')

@section('content')
    <h1>Reservas</h1>

    <a class="btn btn-primary" href="{{ route('userbookings.create') }}">Crear nueva reserva</a>

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>

            <th scope="col">Nombre del turno</th>
            <th scope="col">Fecha</th>
            <th scope="col">Inicio</th>
            <th scope="col">Fin</th>
            <th scope="col">Descripción del turno</th>

            <th scope="col">Máximo</th>
            <th scope="col">Mínimo</th>
            <th scope="col">Descripción de la mesa</th>

            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($userbookings as $userbooking)
                <tr>
                    <th scope="row">{{ $userbooking['booking_id'] }}</th>

                    <td>{{ $userbooking['turn']['name'] }}</td>
                    <td>{{ $userbooking['turn']['date'] }}</td>
                    <td>{{ $userbooking['turn']['start'] }}</td>
                    <td>{{ $userbooking['turn']['end'] }}</td>
                    <td>{{ $userbooking['turn']['description'] }}</td>

                    <td>{{ $userbooking['table']['maxNumber'] }}</td>
                    <td>{{ $userbooking['table']['minNumber'] }}</td>
                    <td>{{ $userbooking['table']['description'] }}</td>

                    <td>
                        <form action="{{ route('userbookings.destroy', $userbooking['booking_id']) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $userbookings->links() }}
@endsection
