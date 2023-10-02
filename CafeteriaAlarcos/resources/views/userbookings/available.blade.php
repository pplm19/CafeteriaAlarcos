@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <a href="{{ route('userbookings.index') }}" class="btn btn-secondary">
            <i class="bi bi-backspace me-1"></i> Volver
        </a>

        <div class="text-center mb-5">
            <h1>Turnos disponibles</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <th scope="col" class="text-center align-middle">Nombre del turno</th>
                    <th scope="col" class="text-center align-middle">Fecha</th>
                    <th scope="col" class="text-center align-middle">Inicio</th>
                    <th scope="col" class="text-center align-middle">Fin</th>
                    <th scope="col" class="text-center align-middle">Descripción del turno</th>

                    <th scope="col" class="text-center align-middle">Aforo de local restante</th>
                    <th scope="col" class="text-center align-middle">Tipos de mesas disponibles</th>

                    <th scope="col" class="text-center align-middle w-10">Acciones</th>
                </thead>

                <tbody>
                    @if (count($turns) === 0)
                        <tr>
                            <td colspan="9" class="text-center">No se ha encontrado ningún turno disponible</td>
                        </tr>
                    @else
                        @foreach ($turns as $turn)
                            <tr>
                                <td>{{ $turn['name'] }}</td>
                                <td>{{ $turn['date'] }}</td>
                                <td>{{ $turn['start'] }}</td>
                                <td>{{ $turn['end'] }}</td>
                                <td>{{ $turn['description'] }}</td>

                                <td>{{ $turn['turn_remaining_guests'] }}</td>
                                <td>{{ $turn['tables_remaining'] }}</td>

                                <td class="text-center align-middle">
                                    <a class="btn btn-primary" href="{{ route('userbookings.create', $turn['id']) }}">
                                        Disponibilidad
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $turns->links() }}
        </div>
    </div>
@endsection
