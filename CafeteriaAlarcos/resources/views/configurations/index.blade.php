@extends('layouts.app')

@section('content')
    <h1>Configuración</h1>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Valor</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($configurations as $configuration)
                <tr>
                    <th scope="row">{{ $configuration['id'] }}</th>
                    <td>{{ $configuration['name'] }}</td>
                    <td>{{ $configuration['value'] }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('configurations.edit', $configuration['id']) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $configurations->links() }}
@endsection
