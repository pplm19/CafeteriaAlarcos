@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Tipos de platos</h1>
        </div>

        <p class="d-flex justify-content-end">
            <a class="btn btn-theme" href="{{ route('types.create') }}">Crear nuevo tipo de plato</a>
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </thead>

                <tbody>
                    @foreach ($types as $type)
                        <tr>
                            <td>{{ $type['name'] }}</td>
                            <td>
                                <form action="{{ route('types.destroy', $type['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <a class="btn btn-primary" href="{{ route('types.edit', $type['id']) }}">Editar</a>

                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $types->links() }}
        </div>
    </div>
@endsection
