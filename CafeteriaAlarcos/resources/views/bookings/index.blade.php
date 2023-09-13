@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-2 px-md-4 px-lg-5 row g-0">
        <div class="col-12 col-lg-4 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Reservas</h1>

                    <form action="{{ route('bookings.index') }}" method="GET" class="needs-validation" novalidate>
                        @csrf

                        <div class="mt-3">
                            <label for="date" class="form-label">Fecha de las reservas</label>
                            <input type="date" name="date" id="date"
                                class="form-control @error('username') is-invalid @enderror" value="{{ old('date') }}"
                                required>

                            @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
                            <button type="submit" name="search" class="btn btn-theme">
                                <i class='bx bxs-search align-middle'></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8 col-xl-9 ps-0 ps-lg-3 pt-3 pt-lg-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th scope="col" class="text-center align-middle">Descripción</th>
                        <th scope="col" class="text-center align-middle">Comensales</th>

                        <th scope="col" class="text-center align-middle">Nombre del turno</th>
                        <th scope="col" class="text-center align-middle">Fecha</th>
                        <th scope="col" class="text-center align-middle">Inicio</th>
                        <th scope="col" class="text-center align-middle">Fin</th>
                        <th scope="col" class="text-center align-middle">Descripción del turno</th>

                        <th scope="col" class="text-center align-middle">Mesas</th>

                        <th scope="col" class="text-center align-middle">Acciones</th>
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

            <div class="d-flex justify-content-center d-sm-block">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection
