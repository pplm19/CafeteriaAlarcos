@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/checkboxValidation.js'])
@endPushOnce

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Ingredientes</h1>
        </div>

        <form action="{{ route('ingredients.destroy') }}" method="POST" class="checkbox-validation">
            @csrf

            <p class="d-flex justify-content-end gap-2">
                <a class="btn btn-theme" href="{{ route('ingredients.create') }}">Crear ingrediente</a>
                <button type="submit" class="btn btn-danger btn-rounded">Eliminar seleccionados</button>
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-striped-columns table-hover align-middle">
                    <thead class="table-dark">
                        <th scope="col" class="text-center align-middle w-10">#</th>
                        <th scope="col" class="text-center align-middle">Nombre</th>
                        <th scope="col" class="text-center align-middle">Categoría</th>
                        <th scope="col" class="text-center align-middle w-10">Acciones</th>
                    </thead>

                    <tbody>
                        @foreach ($ingredients as $ingredient)
                            <tr>
                                <td class="text-center align-middle">
                                    <input class="form-check-input" type="checkbox" name="select[]"
                                        value="{{ $ingredient['id'] }}">
                                </td>
                                <td>{{ $ingredient['name'] }}</td>
                                <td>{{ $ingredient['icategory']['name'] }}</td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-primary"
                                        href="{{ route('ingredients.edit', $ingredient['id']) }}">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $ingredients->links() }}
        </div>
    </div>
@endsection
