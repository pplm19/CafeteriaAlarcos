@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/checkboxValidation.js', 'resources/js/rowCheckbox.js', 'resources/js/adminCalendar.js'])
@endPushOnce

<script>
    const baseUrl = {{ Js::from(route('turns.index')) }};
    const date = {{ Js::from(old('date', null)) }};
    const turns = {{ Js::from($turns) }};
</script>

@section('pagetitle')
    <h1>Turnos</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div id="calendar" class="reverse"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('turns.destroy') }}" method="POST" class="checkbox-validation">
                        @csrf

                        <input type="hidden" name="searchDate" value="{{ old('searchDate') }}">

                        <p class="d-flex justify-content-end gap-2">
                            <a href="{{ route('turns.create') }}" class="btn btn-theme">
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
                                    @if (!isset($turnsList) || count($turnsList) === 0)
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
                                                    <a class="btn btn-primary"
                                                        href="{{ route('turns.edit', $turn['id']) }}">
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
                </div>
            </div>
        </div>
    </div>
@endsection
