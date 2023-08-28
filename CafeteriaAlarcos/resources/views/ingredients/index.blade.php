@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Ingredientes</h1>
        </div>


        <p class="d-flex justify-content-end">
            <a class="btn btn-theme" href="{{ route('ingredients.create') }}">Crear nuevo ingrediente</a>
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <th scope="col">Nombre</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Acciones</th>
                </thead>

                <tbody>
                    @foreach ($ingredients as $ingredient)
                        <tr>
                            <td>{{ $ingredient['name'] }}</td>
                            <td>{{ $ingredient['icategory']['name'] }}</td>
                            <td>
                                <form action="{{ route('ingredients.destroy', $ingredient['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <a class="btn btn-primary"
                                        href="{{ route('ingredients.edit', $ingredient['id']) }}">Editar</a>

                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $ingredients->links() }}
        </div>
    </div>
@endsection
