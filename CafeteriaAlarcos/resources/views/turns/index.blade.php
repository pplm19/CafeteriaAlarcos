@extends('layouts.app')

@section('content')
    <h1>Turnos</h1>

    <a class="btn btn-primary" href="{{ route('turns.create') }}">
        Crear nueva estructura de turnos
    </a>

    <div class="w-25 mx-auto">
        <form action="{{ route('turns.index') }}" method="GET">
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

    @isset($turnsList)
        <div class="py-3 d-flex gap-2">
            <a class="btn btn-primary" href="{{ route('turns.create', ['date' => old('searchDate')]) }}">
                Crear turno
            </a>
            <a class="btn btn-secondary" href="{{ route('turns.copyStructure', ['date' => old('searchDate')]) }}">
                Copiar estructura de turnos
            </a>
            <form action="{{ route('turns.destroyStructure') }}" method="POST">
                @csrf

                <input type="date" name="date" value="{{ old('searchDate') }}" hidden>

                <button type="submit" class="btn btn-danger">Eliminar estructura de turnos</button>
            </form>
        </div>

        <table class="table table-striped-columns">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Fecha</th>
                <th scope="col">Inicio</th>
                <th scope="col">Fin</th>
                <th scope="col">Descripción</th>
            </thead>

            <tbody>
                @foreach ($turnsList as $turn)
                    <tr>
                        <th scope="row">{{ $turn['id'] }}</th>
                        <td>{{ $turn['name'] }}</td>
                        <td>{{ $turn['date'] }}</td>
                        <td>{{ $turn['start'] }}</td>
                        <td>{{ $turn['end'] }}</td>
                        <td>{{ $turn['description'] }}</td>
                        <td>
                            <form action="{{ route('turns.destroy', $turn['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <a class="btn btn-primary" href="{{ route('turns.edit', $turn['id']) }}">Editar</a>

                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $turnsList->links() }}
    @endisset
@endsection
