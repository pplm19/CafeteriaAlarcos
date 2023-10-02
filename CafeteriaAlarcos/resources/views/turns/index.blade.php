@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js', 'resources/js/checkboxValidation.js', 'resources/js/rowCheckbox.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-2 px-md-4 px-lg-5 row g-0">
        <div class="col-12 col-lg-4 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Turnos</h1>

                    <form action="{{ route('turns.index') }}" method="GET" class="needs-validation mt-3" novalidate>
                        @csrf

                        <div class="form-floating mt-3">
                            <select name="searchDate" id="searchDate"
                                class="form-select @error('searchDate') is-invalid @enderror" required>
                                <option selected disabled value="">Selecciona una fecha</option>
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

        <div class="col-12 col-lg-8 col-xl-9 ps-0 ps-lg-3 pt-3 pt-lg-0">
            @isset($turnsList)
                <form action="{{ route('turns.destroy') }}" method="POST" class="checkbox-validation">
                    @csrf

                    <input type="hidden" name="searchDate" value="{{ old('searchDate') }}">

                    <p class="d-flex justify-content-end gap-2">
                        <a href="{{ route('turns.create', ['date' => old('searchDate')]) }}" class="btn btn-theme">
                            <i class="bi bi-plus-circle"></i> Crear turno
                        </a>

                        @isset($turnsList)
                            <button type="submit" class="btn btn-danger btn-rounded">
                                <i class="bi bi-trash"></i> Eliminar seleccionados
                            </button>
                        @endisset
                    </p>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <th scope="col" class="text-center align-middle w-10">#</th>
                                <th scope="col" class="text-center align-middle">Nombre</th>
                                <th scope="col" class="text-center align-middle">Fecha</th>
                                <th scope="col" class="text-center align-middle">Inicio</th>
                                <th scope="col" class="text-center align-middle">Fin</th>
                                <th scope="col" class="text-center align-middle">Descripción</th>
                                <th scope="col" class="text-center align-middle">Menú</th>
                                <th scope="col" class="text-center align-middle w-10">Acciones</th>
                            </thead>

                            <tbody>
                                @if (count($turnsList) === 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No se ha encontrado ningún turno</td>
                                    </tr>
                                @else
                                    @foreach ($turnsList as $turn)
                                        <tr class="selectable">
                                            <td class="text-center align-middle">
                                                <input class="form-check-input" type="checkbox" name="select[]"
                                                    value="{{ $turn['id'] }}">
                                            </td>
                                            <td>{{ $turn['name'] }}</td>
                                            <td>{{ $turn['date'] }}</td>
                                            <td>{{ $turn['start'] }}</td>
                                            <td>{{ $turn['end'] }}</td>
                                            <td>{{ $turn['description'] }}</td>
                                            <td>{{ $turn['menu']['name'] }}</td>
                                            <td class="text-center align-middle">
                                                <a class="btn btn-primary" href="{{ route('turns.edit', $turn['id']) }}">
                                                    <i class='bx bxs-edit-alt'></i> Editar
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @include('layouts.confirmModal', [
                        'title' => 'Confirmar borrado',
                        'content' => '¿Estás seguro de que quieres borrar estos registros?',
                    ])
                </form>
            @else
                <div class="text-end">
                    <a href="{{ route('turns.create') }}" class="btn btn-theme">
                        <i class="bi bi-plus-circle"></i> Crear turno
                    </a>
                </div>
            @endisset
        </div>
    </div>
@endsection
