@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <a href="{{ route('userbookings.index') }}" class="btn btn-secondary">
            <i class="bi bi-backspace me-1"></i> Volver
        </a>

        <div class="text-center mb-5">
            <h1>Historial de reservas</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <th scope="col" class="text-center align-middle">Nombre del turno</th>
                    <th scope="col" class="text-center align-middle">Fecha</th>
                    <th scope="col" class="text-center align-middle">Inicio</th>
                    <th scope="col" class="text-center align-middle">Fin</th>
                    <th scope="col" class="text-center align-middle">Descripción del turno</th>

                    <th scope="col" class="text-center align-middle">Comensales</th>

                    <th scope="col" class="text-center align-middle">Mesas</th>

                    <th scope="col" class="text-center align-middle">Status</th>
                </thead>

                <tbody>
                    @if (count($userbookings) === 0)
                        <tr>
                            <td colspan="9" class="text-center">No se ha encontrado ninguna reserva anterior</td>
                        </tr>
                    @else
                        @foreach ($userbookings as $userbooking)
                            <tr>
                                <td>{{ $userbooking['turn']['name'] }}</td>
                                <td>{{ $userbooking['turn']['date'] }}</td>
                                <td>{{ $userbooking['turn']['start'] }}</td>
                                <td>@ifNull($userbooking['turn']['end'])</td>
                                <td>@ifNull($userbooking['turn']['description'])</td>

                                <td>{{ $userbooking['bookingTables']->sum('guests') }}</td>

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
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $userbookings->links() }}
        </div>
    </div>
@endsection
