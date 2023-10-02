@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Tipos de platos</h1>
        </div>

        <p class="text-end">
            <a class="btn btn-theme" href="{{ route('types.create') }}">
                <i class="bi bi-plus-circle"></i> Crear tipo
            </a>
        </p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <th scope="col" class="text-center align-middle">Nombre</th>
                    <th scope="col" class="text-center align-middle w-10">Acciones</th>
                </thead>

                <tbody>
                    @if (count($types) === 0)
                        <tr>
                            <td colspan="2" class="text-center">No se ha encontrado ningún tipo</td>
                        </tr>
                    @else
                        @foreach ($types as $type)
                            <tr>
                                <td>{{ $type['name'] }}</td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-primary" href="{{ route('types.edit', $type['id']) }}">
                                        <i class='bx bxs-edit-alt'></i> Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $types->links() }}
        </div>
    </div>
@endsection
