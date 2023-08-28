@extends('layouts.app')

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <div class="text-center mb-5">
            <h1>Alérgeneos</h1>
        </div>

        <p class="d-flex justify-content-end">
            <a class="btn btn-theme" href="{{ route('allergens.create') }}">Crear nuevo alérgeno</a>
        </p>
        <div class="table-responsive">
            <table class="table table-striped-columns">
                <thead>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </thead>

                <tbody>
                    @foreach ($allergens as $allergen)
                        <tr>
                            <td>{{ $allergen['name'] }}</td>
                            <td>
                                <form action="{{ route('allergens.destroy', $allergen['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <a class="btn btn-primary"
                                        href="{{ route('allergens.edit', $allergen['id']) }}">Editar</a>

                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center d-sm-block">
            {{ $allergens->links() }}
        </div>
    </div>
@endsection
