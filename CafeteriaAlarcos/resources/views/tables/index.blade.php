@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Mesas</h1>
        </div>

        <p class="d-flex justify-content-end">
            <a class="btn btn-theme" href="{{ route('tables.create') }}">Crear nueva mesa</a>
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Máximo</th>
                    <th scope="col">Mínimo</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Acciones</th>
                </thead>

                <tbody>
                    @foreach ($tables as $table)
                        <tr>
                            <td>{{ $table['quantity'] }}</td>
                            <td>{{ $table['maxNumber'] }}</td>
                            <td>{{ $table['minNumber'] }}</td>
                            <td>{{ $table['description'] }}</td>
                            <td>
                                <form action="{{ route('tables.destroy', $table['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <a class="btn btn-primary" href="{{ route('tables.edit', $table['id']) }}">Editar</a>

                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $tables->links() }}
        </div>
    </div>
@endsection
