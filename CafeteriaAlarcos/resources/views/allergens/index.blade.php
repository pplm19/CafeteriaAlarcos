@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/checkboxValidation.js', 'resources/js/rowCheckbox.js'])
@endPushOnce

@section('pagetitle')
    <h1>Alérgeneos</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('allergens.destroy') }}" method="POST" class="checkbox-validation">
                @csrf

                <p class="d-flex justify-content-end gap-2">
                    <a class="btn btn-theme" href="{{ route('allergens.create') }}">
                        <i class="bi bi-plus-circle"></i> Crear alérgeno
                    </a>
                    <button type="submit" class="btn btn-danger btn-rounded">
                        <i class="bi bi-trash"></i> Eliminar seleccionados
                    </button>
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <th scope="col" class="text-center align-middle w-10">#</th>
                            <th scope="col" class="text-center align-middle">Nombre</th>
                            <th scope="col" class="text-center align-middle w-10">Acciones</th>
                        </thead>

                        <tbody>
                            @if (count($allergens) === 0)
                                <tr>
                                    <td colspan="3" class="text-center">No se ha encontrado ningún alérgeno
                                    </td>
                                </tr>
                            @else
                                @foreach ($allergens as $allergen)
                                    <tr class="selectable">
                                        <td class="text-center align-middle">
                                            <input class="form-check-input" type="checkbox" name="select[]"
                                                value="{{ $allergen['id'] }}">
                                        </td>
                                        <td>{{ $allergen['name'] }}</td>
                                        <td class="text-center align-middle">
                                            <a class="btn btn-primary"
                                                href="{{ route('allergens.edit', $allergen['id']) }}">
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

            <div class="d-flex justify-content-center d-sm-block">
                {{ $allergens->links() }}
            </div>
        </div>
    </div>
@endsection
