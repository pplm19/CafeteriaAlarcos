@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Categorías de ingredientes</h1>
        </div>

        <p class="d-flex justify-content-end">
            <a class="btn btn-theme" href="{{ route('icategories.create') }}">Crear nuevo ingrediente</a>
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </thead>

                <tbody>
                    @foreach ($icategories as $icategory)
                        <tr>
                            <td>{{ $icategory['name'] }}</td>
                            <td>
                                <form action="{{ route('icategories.destroy', $icategory['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <a class="btn btn-primary"
                                        href="{{ route('icategories.edit', $icategory['id']) }}">Editar</a>

                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $icategories->links() }}
    </div>
@endsection