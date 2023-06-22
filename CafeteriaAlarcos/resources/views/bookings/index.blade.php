@extends('layouts.app')

@section('content')
    <h1>Reservas</h1>

    <div class="w-25 mx-auto">
        <form action="{{ route('bookings.index') }}" method="GET">
            @csrf

            <div class="mb-3">
                <label for="searchDate" class="form-label">Fecha copia</label>
                <select name="searchDate" id="searchDate" class="form-select @error('searchDate') is-invalid @enderror"
                    required>
                    @if (old('searchDate', null) === null)
                        <option selected></option>
                    @endif
                    @foreach ($turns as $turn)
                        <option value="{{ $turn['date'] }}" @selected($turn['date'] == old('searchDate', null))>
                            {{ $turn['date'] }}
                        </option>
                    @endforeach
                </select>
                @error('searchDate')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" name="search" class="btn btn-primary">Ver estructura</button>
            </div>
        </form>
    </div>

    @isset($bookings)
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

                <th scope="col">Nombre de usuario</th>
                <th scope="col">Email</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Teléfono</th>

                <th scope="col">Acciones</th>
            </thead>

            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <th scope="row">{{ $booking['id'] }}</th>

                        <td>{{ $booking['turn']['name'] }}</td>
                        <td>{{ $booking['turn']['date'] }}</td>
                        <td>{{ $booking['turn']['start'] }}</td>
                        <td>{{ $booking['turn']['end'] }}</td>
                        <td>{{ $booking['turn']['description'] }}</td>

                        <td>{{ $booking['table']['maxNumber'] }}</td>
                        <td>{{ $booking['table']['minNumber'] }}</td>
                        <td>{{ $booking['table']['description'] }}</td>

                        <td>{{ $booking['user']['username'] }}</td>
                        <td>{{ $booking['user']['email'] }}</td>
                        <td>{{ $booking['user']['name'] }}</td>
                        <td>{{ isset($booking['user']['lastname']) ? $booking['user']['lastname'] : 'N/A' }}</td>
                        <td>{{ isset($booking['user']['phone']) ? $booking['user']['phone'] : 'N/A' }}</td>

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
        {{ $bookings->links() }}
    @endisset
@endsection
