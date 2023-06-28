@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Configuración</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <th scope="col">Nombre</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Acciones</th>
                </thead>

                <tbody>
                    @foreach ($configurations as $configuration)
                        <tr>
                            <td>{{ $configuration['name'] }}</td>
                            <td>{{ $configuration['value'] }}</td>
                            <td>
                                <a class="btn btn-primary"
                                    href="{{ route('configurations.edit', $configuration['id']) }}">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $configurations->links() }}
        </div>
    </div>
@endsection
