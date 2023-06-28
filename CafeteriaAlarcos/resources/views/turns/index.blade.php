@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Turnos</h1>

                        <p class="d-flex justify-content-end">
                            <a class="btn btn-theme" href="{{ route('turns.create') }}">
                                Crear nueva estructura de turnos
                            </a>
                        </p>

                        <form action="{{ route('turns.index') }}" method="GET" class="mt-3">
                            @csrf

                            <div class="form-floating mt-3">
                                <select name="searchDate" id="searchDate"
                                    class="form-select @error('searchDate') is-invalid @enderror" required>
                                    @if (old('searchDate', null) === null)
                                        <option selected></option>
                                    @endif
                                    @foreach ($turns as $turn)
                                        <option value="{{ $turn['date'] }}" @selected($turn['date'] == old('searchDate', null))>
                                            {{ $turn['date'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="searchDate">Fecha</label>

                                @error('searchDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" name="search" class="btn btn-theme">
                                    <i class='bx bxs-search align-middle'></i> Ver estructura
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @isset($turnsList)
            <div class="py-3 d-flex justify-content-end gap-2">
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

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th scope="col">Nombre</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Inicio</th>
                        <th scope="col">Fin</th>
                        <th scope="col">Descripción</th>
                    </thead>

                    <tbody>
                        @foreach ($turnsList as $turn)
                            <tr>
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
            </div>

            {{ $turnsList->links() }}
        @endisset
    </div>
@endsection
