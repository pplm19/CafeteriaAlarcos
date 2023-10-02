@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Categorías de ingredientes</h1>
        </div>

        <p class="text-end">
            <a class="btn btn-theme" href="{{ route('icategories.create') }}">
                <i class="bi bi-plus-circle"></i> Crear categoría
            </a>
        </p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <th scope="col" class="text-center align-middle">Nombre</th>
                    <th scope="col" class="text-center align-middle w-10">Acciones</th>
                </thead>

                <tbody>
                    @if (count($icategories) === 0)
                        <tr>
                            <td colspan="2" class="text-center">No se ha encontrado ninguna categoría</td>
                        </tr>
                    @else
                        @foreach ($icategories as $icategory)
                            <tr>
                                <td>{{ $icategory['name'] }}</td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-primary" href="{{ route('icategories.edit', $icategory['id']) }}">
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
            {{ $icategories->links() }}
        </div>
    </div>
@endsection
