@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/checkboxValidation.js', 'resources/js/rowCheckbox.js', 'resources/js/adminCalendar.js'])
@endPushOnce

<script>
    const baseUrl = {{ Js::from(route('bookings.index')) }};
    const date = {{ Js::from(old('date', null)) }};
    const turns = {{ Js::from($turns) }};
</script>

@section('pagetitle')
    <h1>Reservas</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div id="calendar" class="reverse"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @isset($turnData)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <th scope="col" class="text-center align-middle">Nombre del turno</th>
                                    <th scope="col" class="text-center align-middle">Descripción del turno</th>
                                    <th scope="col" class="text-center align-middle">Fecha</th>
                                    <th scope="col" class="text-center align-middle">Inicio</th>
                                    <th scope="col" class="text-center align-middle">Fin</th>
                                </thead>
                                <tbody>
                                    <td>{{ $turnData['name'] }}</td>
                                    <td>{{ $turnData['description'] }}</td>
                                    <td>{{ $turnData['date'] }}</td>
                                    <td>{{ $turnData['start'] }}</td>
                                    <td>@ifNull($turnData['end'])</td>
                                </tbody>
                            </table>
                        </div>
                    @endisset

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
                                    <th scope="col" class="text-center align-middle">Usuario</th>
                                    <th scope="col" class="text-center align-middle">Descripción</th>
                                    <th scope="col" class="text-center align-middle">Comensales</th>
                                    <th scope="col" class="text-center align-middle">Mesas</th>
                                </thead>

                                <tbody>
                                    @isset($bookings)
                                        @foreach ($bookings as $booking)
                                            <tr class="selectable">
                                                <td class="text-center align-middle">
                                                    <input class="form-check-input" type="checkbox" name="select[]"
                                                        value="{{ $booking['id'] }}">
                                                </td>
                                                <td>
                                                    <a href="{{ route('users.profile', ['user' => $booking['user']['id']]) }}"
                                                        class="text-theme">
                                                        {{ $booking['user']['name'] }}
                                                    </a>
                                                </td>
                                                <td>@ifNull($booking['description'])</td>
                                                <td>{{ $booking['bookingTables']->sum('guests') }}</td>

                                                <td>
                                                    <ul>
                                                        @foreach ($booking['tables'] as $table)
                                                            <li>
                                                                {{ $table['minNumber'] }} - {{ $table['maxNumber'] }}
                                                                comensales
                                                                @isset($table['description'])
                                                                    - {{ $table['description'] }}
                                                                @endisset
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">No se ha encontrado ninguna reserva</td>
                                        </tr>
                                    @endisset
                                </tbody>
                            </table>
                        </div>

                        @include('layouts.confirmModal', [
                            'title' => 'Confirmar cancelación',
                            'content' => '¿Estás seguro de que quieres cancelar estas reservas?',
                        ])
                    </form>

                    @isset($bookings)
                        <div class="d-flex justify-content-center d-sm-block">
                            {{ $bookings->links() }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endsection
