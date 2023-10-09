@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <a href="{{ route('userbookings.available') }}" class="btn btn-secondary">
            <i class="bi bi-backspace me-1"></i> Volver
        </a>

        <div class="text-center mb-5">
            <h1>Realizar reserva</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-11 col-md-7 col-lg-6 col-xl-5 col-xxl-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <th scope="col" class="text-center align-middle">Nombre del turno</th>
                            <th scope="col" class="text-center align-middle">Fecha</th>
                            <th scope="col" class="text-center align-middle">Inicio</th>
                            <th scope="col" class="text-center align-middle">Fin</th>
                            <th scope="col" class="text-center align-middle">Descripción del turno</th>
                        </thead>

                        <tbody>
                            <tr>
                                <td>{{ $turn['name'] }}</td>
                                <td>{{ $turn['date'] }}</td>
                                <td>{{ $turn['start'] }}</td>
                                <td>{{ $turn['end'] }}</td>
                                <td>{{ $turn['description'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="pt-4 row justify-content-center">
            <div class="card col-11 col-md-7 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card-body">
                    <form action="{{ route('userbookings.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <input type="number" name="turn_id" value="{{ $turn['id'] }}" hidden>

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-xl-8">
                                <label for="table_id" class="form-label">Mesa</label>
                                <select name="table_id" id="table_id"
                                    class="form-select @error('table_id') is-invalid @enderror" required>
                                    <option selected disabled value="">Selecciona una mesa</option>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table['id'] }}" @selected($table['id'] == old('table_id', null))>
                                            Comensales: {{ $table['minNumber'] }} - {{ $table['maxNumber'] }}
                                            Disponibles: {{ $table['remaining_tables'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('table_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 col-xl-4">
                                <label for="guests" class="form-label">Comensales</label>
                                <input type="number" name="guests" id="guests"
                                    class="form-control @error('guests') is-invalid @enderror"
                                    value="{{ old('guests', 1) }}" required min="1" max="65535" />
                                @error('guests')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <input type="text" name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('description') }}" maxlength="255"
                                    placeholder="Alérgenos de los comensales" />

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @auth
                            <div class="text-center">
                                <button type="submit" class="btn btn-theme">Realizar reserva</button>
                            </div>
                        @endauth
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
