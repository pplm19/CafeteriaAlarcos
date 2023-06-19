@extends('layouts.app')

@section('content')
    <div class="w-25 mx-auto">
        <form action="{{ route('userbookings.store') }}" method="POST">
            @csrf

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

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

            @auth
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Crear reserva</button>
                </div>
            @endauth
        </form>
    </div>
@endsection
