@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js', 'resources/js/checkboxValidation.js', 'resources/js/rowCheckbox.js'])
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
            <form action="{{ route('bookings.cancel') }}" method="POST" class="checkbox-validation">
                @csrf

                <p class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-danger btn-rounded">
                        <i class="bi bi-x-circle"></i> Cancelar seleccionados
                    </button>
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <th scope="col" class="text-center align-middle w-10">#</th>

                            <th scope="col" class="text-center align-middle">Descripción</th>
                            <th scope="col" class="text-center align-middle">Comensales</th>

                            <th scope="col" class="text-center align-middle">Nombre del turno</th>
                            <th scope="col" class="text-center align-middle">Fecha</th>
                            <th scope="col" class="text-center align-middle">Inicio</th>
                            <th scope="col" class="text-center align-middle">Fin</th>
                            <th scope="col" class="text-center align-middle">Descripción del turno</th>

                            <th scope="col" class="text-center align-middle">Mesas</th>
                        </thead>

                        <tbody>
                            @if (count($bookings) === 0)
                                <tr>
                                    <td colspan="9" class="text-center">No se ha encontrado ninguna reserva</td>
                                </tr>
                            @else
                                @foreach ($bookings as $booking)
                                    <tr class="selectable">
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
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                @include('layouts.confirmModal', [
                    'title' => 'Confirmar cancelación',
                    'content' => '¿Estás seguro de que quieres cancelar estas reservas?',
                ])
            </form>

            <div class="d-flex justify-content-center d-sm-block">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection
