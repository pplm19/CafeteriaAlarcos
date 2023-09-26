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

        <div class="col-12 col-lg-8 col-xl-9 ps-0 ps-lg-3 pt-3 pt-lg-0">
            <p class="d-flex justify-content-end gap-2">
                <a class="btn btn-theme" href="{{ route('turns.create') }}">
                    <i class="bi bi-plus-circle"></i> Crear estructura
                </a>
                @isset($turnsList)
                    <a href="{{ route('turns.copyStructure', ['date' => old('searchDate')]) }}"
                        class="btn btn-secondary btn-rounded">
                        <i class="bi bi-clipboard2-plus"></i> Copiar estructura
                    </a>

                    <a href="{{ route('turns.destroyStructure', ['date' => old('searchDate')]) }}"
                        class="btn btn-danger btn-rounded">
                        <i class="bi bi-trash"></i> Eliminar estructura
                    </a>
                @endisset

            </p>

            @isset($turnsList)
                <form action="{{ route('turns.destroy') }}" method="POST" class="checkbox-validation">
                    @csrf

                    <input type="hidden" name="searchDate" value="{{ old('searchDate') }}">

                    <div class="py-3 d-flex justify-content-end gap-2">
                        <a href="{{ route('turns.create', ['date' => old('searchDate')]) }}" class="btn btn-theme">
                            <i class="bi bi-plus-circle"></i> Crear turno
                        </a>

                        <button type="submit" class="btn btn-danger btn-rounded">
                            <i class="bi bi-trash"></i> Eliminar seleccionados
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <th scope="col" class="text-center align-middle w-10">#</th>
                                <th scope="col" class="text-center align-middle">Nombre</th>
                                <th scope="col" class="text-center align-middle">Fecha</th>
                                <th scope="col" class="text-center align-middle">Inicio</th>
                                <th scope="col" class="text-center align-middle">Fin</th>
                                <th scope="col" class="text-center align-middle">Descripción</th>
                                <th scope="col" class="text-center align-middle w-10">Acciones</th>
                            </thead>

                            <tbody>
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
                                        <td class="text-center align-middle">
                                            <a class="btn btn-primary" href="{{ route('turns.edit', $turn['id']) }}">
                                                <i class='bx bxs-edit-alt'></i> Editar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @include('layouts.confirmModal', [
                        'title' => 'Confirmar borrado',
                        'content' => '¿Estás seguro de que quieres borrar estos registros?',
                    ])
                </form>
            @endisset
        </div>
    </div>
@endsection
