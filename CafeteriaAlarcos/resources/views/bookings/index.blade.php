@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/checkboxValidation.js', 'resources/js/rowCheckbox.js', 'resources/js/adminCalendar.js'])
@endPushOnce

<script>
    const baseUrl = {{ Js::from(route('bookings.index')) }};
    const date = {{ Js::from(old('date', null)) }};
    const turns = {{ Js::from($turns) }};
</script>

@section('content')
    <div class="content py-5 px-2 px-md-4 px-lg-5 row g-0">
        <div class="col-12 col-lg-5 col-xxl-4 row">
            <div class="card col-12 col-md-8 col-lg-12 mx-auto">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7 col-xxl-8 ps-0 ps-lg-3 pt-3 pt-lg-0">
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
