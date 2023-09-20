@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/checkboxValidation.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Mesas</h1>
        </div>

        <form action="{{ route('tables.destroy') }}" method="POST" class="checkbox-validation">
            @csrf

            <p class="d-flex justify-content-end gap-2">
                <a class="btn btn-theme" href="{{ route('tables.create') }}">
                    <i class="bi bi-plus-circle"></i> Crear mesa
                </a>
                <button type="submit" class="btn btn-danger btn-rounded">
                    <i class="bi bi-trash"></i> Eliminar seleccionados
                </button>
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-striped-columns table-hover align-middle">
                    <thead class="table-dark">
                        <th scope="col" class="text-center align-middle w-10">#</th>
                        <th scope="col" class="text-center align-middle">Cantidad</th>
                        <th scope="col" class="text-center align-middle">Máximo</th>
                        <th scope="col" class="text-center align-middle">Mínimo</th>
                        <th scope="col" class="text-center align-middle">Descripción</th>
                        <th scope="col" class="text-center align-middle w-10">Acciones</th>
                    </thead>

                    <tbody>
                        @foreach ($tables as $table)
                            <tr>
                                <td class="text-center align-middle">
                                    <input class="form-check-input" type="checkbox" name="select[]"
                                        value="{{ $table['id'] }}">
                                </td>
                                <td>{{ $table['quantity'] }}</td>
                                <td>{{ $table['maxNumber'] }}</td>
                                <td>{{ $table['minNumber'] }}</td>
                                <td>{{ $table['description'] }}</td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-primary" href="{{ route('tables.edit', $table['id']) }}">
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

        <div class="d-flex justify-content-center d-sm-block">
            {{ $tables->links() }}
        </div>
    </div>
@endsection
