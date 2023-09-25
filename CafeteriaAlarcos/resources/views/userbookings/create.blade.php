@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Realizar reserva</h1>
        </div>

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

        <div class="w-25 mx-auto pt-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('userbookings.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <input type="number" name="turn_id" value="{{ $turn['id'] }}" hidden>

                        <div class="row g-3 mb-3">
                            <div class="col">
                                <label for="table_id" class="form-label">Mesa</label>
                                <select name="table_id" id="table_id"
                                    class="form-select @error('table_id') is-invalid @enderror" required>
                                    @if (old('table_id', null) === null)
                                        <option selected disabled value="">Selecciona una mesa</option>
                                    @endif
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

                            <div class="col-4">
                                <label for="guests" class="form-label">Número de comensales</label>
                                <input type="number" name="guests" id="guests"
                                    class="form-control @error('guests') is-invalid @enderror" value="{{ old('guests') }}"
                                    required min="1" max="65535" />
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
                                    value="{{ old('description') }}" maxlength="255" />
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @auth
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-theme">Realizar reserva</button>
                            </div>
                        @endauth
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
