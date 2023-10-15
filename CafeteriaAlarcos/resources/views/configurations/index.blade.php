@extends('layouts.admin')

@section('pagetitle')
    <h1>Configuración</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <th scope="col" class="text-center align-middle">Nombre</th>
                        <th scope="col" class="text-center align-middle">Valor</th>
                        <th scope="col" class="text-center align-middle w-10">Acciones</th>
                    </thead>

                    <tbody>
                        @foreach ($configurations as $configuration)
                            <tr>
                                <td>{{ $configuration['name'] }}</td>
                                <td>{{ $configuration['value'] }}</td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-primary"
                                        href="{{ route('configurations.edit', $configuration['id']) }}">
                                        <i class='bx bxs-edit-alt'></i> Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center d-sm-block">
                    {{ $configurations->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
