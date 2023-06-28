@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Reservas</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
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
                    @foreach ($bookings as $booking)
                        <tr>
                            <th>{{ $booking['description'] }}</th>
                            <td>{{ $booking['bookingTables']->sum('guests') }}</td>

                            <td>{{ $booking['turn']['name'] }}</td>
                            <td>{{ $booking['turn']['date'] }}</td>
                            <td>{{ $booking['turn']['start'] }}</td>
                            <td>{{ $booking['turn']['end'] }}</td>
                            <td>{{ $booking['turn']['description'] }}</td>

                            <td>
                                <ul>
                                    @foreach ($booking['tables'] as $table)
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
                                <form action="{{ route('bookings.cancel', $booking['id']) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-danger">Cancelar reserva</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $bookings->links() }}
    </div>
@endsection
