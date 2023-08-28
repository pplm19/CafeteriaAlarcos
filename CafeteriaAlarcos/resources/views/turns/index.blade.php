@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-2 px-md-4 px-lg-5 row g-0 gap-3">
        <div class="col-12 col-lg-4 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Turnos</h1>

                    <form action="{{ route('turns.index') }}" method="GET" class="needs-validation mt-3" novalidate>
                        @csrf

                        <div class="form-floating mt-3">
                            <select name="searchDate" id="searchDate"
                                class="form-select @error('searchDate') is-invalid @enderror" required>
                                @if (old('searchDate', null) === null)
                                    <option selected disabled value="">Selecciona una fecha</option>
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

                        <div class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
                            <button type="submit" name="search" class="btn btn-theme">
                                <i class='bx bxs-search align-middle'></i> Ver estructura
                            </button>
                            @if (old('search', false))
                                <a href="{{ route('turns.index') }}" class="btn btn-theme">
                                    <i class="bi bi-eraser-fill"></i> Borrar búsqueda
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col px-3">
            <p class="d-flex justify-content-end">
                <a class="btn btn-theme" href="{{ route('turns.create') }}">
                    <i class="bi bi-plus-circle-fill"></i> Crear nueva estructura de turnos
                </a>
            </p>

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
            @endisset
        </div>
    </div>
@endsection
