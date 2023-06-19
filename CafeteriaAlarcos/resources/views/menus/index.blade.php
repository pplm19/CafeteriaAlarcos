@extends('layouts.app')

@section('content')
    <h1>Menú</h1>

    <a class="btn btn-primary" href="{{ route('menus.create') }}">Crear nuevo menú</a>

    <table class="table table-striped-columns">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripción</th>
            <th scope="col">Platos</th>
            <th scope="col">Acciones</th>
        </thead>

        <tbody>
            @foreach ($menus as $menu)
                <tr>
                    <th scope="row">{{ $menu['id'] }}</th>
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
    {{ $menus->links() }}
@endsection
