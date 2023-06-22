@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('userbookings.create') }}" method="GET">
            <div class="mb-3">
                <label for="turn_id" class="form-label">Turno</label>
                <select name="turn_id" id="turn_id" class="form-select @error('turn_id') is-invalid @enderror">
                    @if (old('turn_id', null) === null)
                        <option selected></option>
                    @endif
                    @foreach ($turns as $turn)
                        <option value="{{ $turn['id'] }}" @selected($turn['id'] == old('turn_id', null))>
                            {{ $turn['name'] }} - {{ $turn['date'] }} - {{ $turn['start'] }} : {{ $turn['end'] }}
                        </option>
                    @endforeach
                </select>
                @error('turn_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" name="search" class="btn btn-primary">Ver disponibilidad</button>
            </div>
        </form>

        @if (old('turn_id', null) !== null)
            <form action="{{ route('userbookings.store') }}" method="POST">
                @csrf

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <input type="number" name="turn_id" value="{{ old('turn_id') }}" hidden>

                <div class="mb-3">
                    <label for="table_id" class="form-label">Mesa</label>
                    <select name="table_id" id="table_id" class="form-select @error('table_id') is-invalid @enderror">
                        @if (old('table_id', null) === null)
                            <option selected></option>
                        @endif
                        @foreach ($tables as $table)
                            <option value="{{ $table['id'] }}" @selected($table['id'] == old('table_id', null))>
                                {{ $table['minNumber'] }} - {{ $table['maxNumber'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('table_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

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

                <div class="mb-3">
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

                @auth
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Crear reserva</button>
                    </div>
                @endauth
            </form>
        @endif
    </div>
@endsection
