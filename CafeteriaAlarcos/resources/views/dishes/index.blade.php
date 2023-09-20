@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/checkboxValidation.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Platos</h1>
        </div>

        <form action="{{ route('dishes.destroy') }}" method="POST" class="checkbox-validation">
            @csrf

            <p class="d-flex justify-content-end gap-2">
                <a class="btn btn-theme" href="{{ route('dishes.create') }}">
                    <i class="bi bi-plus-circle"></i> Crear plato
                </a>
                <button type="submit" class="btn btn-danger btn-rounded">
                    <i class="bi bi-trash"></i> Eliminar seleccionados
                </button>
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-striped-columns table-hover align-middle">
                    <thead class="table-dark">
                        <th scope="col" class="text-center align-middle w-10">#</th>
                        <th scope="col" class="text-center align-middle">Nombre</th>
                        <th scope="col" class="text-center align-middle">Imagen</th>
                        <th scope="col" class="text-center align-middle">Receta</th>
                        <th scope="col" class="text-center align-middle">Descripción</th>
                        <th scope="col" class="text-center align-middle">Tipo</th>
                        <th scope="col" class="text-center align-middle">Categorías</th>
                        <th scope="col" class="text-center align-middle">Ingredientes</th>
                        <th scope="col" class="text-center align-middle">Alérgenos</th>
                        <th scope="col" class="text-center align-middle w-10">Acciones</th>
                    </thead>

                    <tbody>
                        @foreach ($dishes as $dish)
                            <tr>
                                <td class="text-center align-middle">
                                    <input class="form-check-input" type="checkbox" name="select[]"
                                        value="{{ $dish['id'] }}">
                                </td>
                                <td>{{ $dish['name'] }}</td>
                                <td class="text-center">
                                    @php($imgUrl = asset('storage/images/dishes/' . $dish['image']))
                                    @if (strpos($imgUrl, $dish['image']))
                                        <img src="{{ $imgUrl }}" alt="Imagen de {{ $dish['name'] }}"
                                            class="img-fluid rounded tdImg">
                                    @else
                                        No hay ninguna imagen asignada a este plato
                                    @endif
                                </td>
                                <td>{{ $dish['recipe'] }}</td>
                                <td>{{ $dish['description'] }}</td>
                                <td>{{ $dish['type']['name'] }}</td>
                                <td>
                                    <ul>
                                        @foreach ($dish['dcategories'] as $dcategory)
                                            <li>{{ $dcategory['name'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($dish['ingredients'] as $ingredient)
                                            <li>{{ $ingredient['name'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($dish['allergens'] as $allergen)
                                            <li>{{ $allergen['name'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-primary" href="{{ route('dishes.edit', $dish['id']) }}">
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
            {{ $dishes->links() }}
        </div>
    </div>
@endsection
