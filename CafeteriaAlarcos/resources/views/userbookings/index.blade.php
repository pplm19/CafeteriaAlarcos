@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Reservas</h1>
        </div>

        <div class="pb-3 d-flex justify-content-end gap-2">
            <a class="btn btn-primary btn-rounded" href="{{ route('userbookings.available') }}">
                Disponibilidad
            </a>
            <a class="btn btn-secondary btn-rounded" href="{{ route('userbookings.history') }}">
                Historial
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <th scope="col" class="text-center align-middle">Descripción</th>
                    <th scope="col" class="text-center align-middle">Comensales</th>

                    <th scope="col" class="text-center align-middle">Nombre del turno</th>
                    <th scope="col" class="text-center align-middle">Fecha</th>
                    <th scope="col" class="text-center align-middle">Inicio</th>
                    <th scope="col" class="text-center align-middle">Fin</th>
                    <th scope="col" class="text-center align-middle">Descripción del turno</th>

                    <th scope="col" class="text-center align-middle">Mesas</th>

                    <th scope="col" class="text-center align-middle w-10">Acciones</th>
                </thead>

                <tbody>
                    @if (count($userbookings) === 0)
                        <tr>
                            <td colspan="9" class="text-center">No se ha encontrado ninguna reserva pendiente</td>
                        </tr>
                    @else
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

                                <td class="text-center align-middle">
                                    <form action="{{ route('userbookings.cancel', $userbooking['id']) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit" class="btn btn-danger">Cancelar reserva</button>
                                    </form>
                                </td>
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
