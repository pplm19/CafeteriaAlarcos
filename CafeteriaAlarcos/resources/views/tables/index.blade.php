@extends('layouts.admin')

{{-- @pushOnce('scripts')
    @vite(['resources/js/checkboxValidation.js', 'resources/js/rowCheckbox.js'])
@endPushOnce --}}

@section('pagetitle')
    <h1>Mesas</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- <form action="{{ route('tables.destroy') }}" method="POST" class="checkbox-validation">
                @csrf --}}

            <p class="d-flex justify-content-end gap-2">
                <a class="btn btn-theme" href="{{ route('tables.create') }}">
                    <i class="bi bi-plus-circle"></i> Crear mesa
                </a>
                <button type="submit" class="btn btn-danger btn-rounded">
                    <i class="bi bi-trash"></i> Eliminar seleccionados
                </button>
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        {{-- <th scope="col" class="text-center align-middle w-10">#</th> --}}
                        <th scope="col" class="text-center align-middle">Mínimo</th>
                        <th scope="col" class="text-center align-middle">Máximo</th>
                        <th scope="col" class="text-center align-middle">Cantidad</th>
                        <th scope="col" class="text-center align-middle">Descripción</th>
                        <th scope="col" class="text-center align-middle w-10">Acciones</th>
                    </thead>

                    <tbody>
                        @if (count($tables) === 0)
                            <tr>
                                <td colspan="6" class="text-center">No se ha encontrado ninguna mesa</td>
                            </tr>
                        @else
                            @foreach ($tables as $table)
                                <tr>
                                    {{-- <tr class="selectable"> --}}
                                    {{-- <td class="text-center align-middle">
                                        <input class="form-check-input" type="checkbox" name="select[]"
                                            value="{{ $table['id'] }}">
                                    </td> --}}
                                    <td>{{ $table['minNumber'] }}</td>
                                    <td>{{ $table['maxNumber'] }}</td>
                                    <td>{{ $table['quantity'] }}</td>
                                    <td>{{ $table['description'] }}</td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-primary" href="{{ route('tables.edit', $table['id']) }}">
                                            <i class='bx bxs-edit-alt'></i> Editar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- @include('layouts.confirmModal', [
                    'title' => 'Confirmar borrado',
                    'content' => '¿Estás seguro de que quieres borrar estos registros?',
                ]) --}}
            {{-- </form> --}}

            <div class="d-flex justify-content-center d-sm-block">
                {{ $tables->links() }}
            </div>
        </div>
    </div>
@endsection
