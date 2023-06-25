@extends('layouts.app')

@section('content')
    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre del turno</th>
            <th scope="col">Fecha</th>
            <th scope="col">Inicio</th>
            <th scope="col">Fin</th>
            <th scope="col">Descripción del turno</th>
        </thead>

        <tbody>
            <tr>
                <th scope="row">{{ $turn['id'] }}</th>

                <td>{{ $turn['name'] }}</td>
                <td>{{ $turn['date'] }}</td>
                <td>{{ $turn['start'] }}</td>
                <td>{{ $turn['end'] }}</td>
                <td>{{ $turn['description'] }}</td>
            </tr>
        </tbody>
    </table>

    <div class="w-25 mx-auto">
        <form action="{{ route('userbookings.store') }}" method="POST">
            @csrf

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <input type="number" name="turn_id" value="{{ $turn['id'] }}" hidden>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" />
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col">
                    <label for="table_id" class="form-label">Mesa</label>
                    <select name="table_id" id="table_id" class="form-select @error('table_id') is-invalid @enderror">
                        @if (old('table_id', null) === null)
                            <option selected></option>
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
                        class="form-control @error('guests') is-invalid @enderror" min="1"
                        value="{{ old('guests') }}" />
                    @error('guests')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            @auth
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Crear reserva</button>
                </div>
            @endauth
        </form>
    </div>
@endsection
