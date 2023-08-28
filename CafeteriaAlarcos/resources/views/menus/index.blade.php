@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Menú</h1>
        </div>

        <p class="d-flex justify-content-end">
            <a class="btn btn-theme" href="{{ route('menus.create') }}">Crear nuevo menú</a>
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Platos</th>
                    <th scope="col">Acciones</th>
                </thead>

                <tbody>
                    @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $menu['name'] }}</td>
                            <td>{{ $menu['description'] }}</td>
                            <td>
                                <ol>
                                    @foreach ($menu['dishes'] as $dish)
                                        <li>{{ $dish['name'] }}</li>
                                    @endforeach
                                </ol>
                            </td>
                            <td>
                                <form action="{{ route('menus.destroy', $menu['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <a class="btn btn-primary" href="{{ route('menus.edit', $menu['id']) }}">Editar</a>

                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $menus->links() }}
        </div>
    </div>
@endsection
