@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Categorías de platos</h1>
        </div>


        <p class="d-flex justify-content-end">
            <a class="btn btn-theme" href="{{ route('dcategories.create') }}">Crear nuevo ingrediente</a>
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <th scope="col" class="text-center align-middle">Nombre</th>
                    <th scope="col" class="text-center align-middle">Acciones</th>
                </thead>

                <tbody>
                    @foreach ($dcategories as $dcategory)
                        <tr>
                            <td>{{ $dcategory['name'] }}</td>
                            <td>
                                <form action="{{ route('dcategories.destroy', $dcategory['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <a class="btn btn-primary"
                                        href="{{ route('dcategories.edit', $dcategory['id']) }}">Editar</a>

                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center d-sm-block">
                {{ $dcategories->links() }}
            </div>
        </div>
    </div>
@endsection
