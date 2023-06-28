@extends('layouts.app')

@section('content')
    <div class="container content pt-10rem">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            Editar ingrediente
                        </h3>

                        <form action="{{ route('ingredients.update', $ingredient['id']) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-floating mt-3">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ $ingredient['name'] }}" required autofocus />
                                <label for="name"><i class='bx bxs-food-menu'></i> Nombre</label>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <select name="i_category_id" id="i_category_id"
                                    class="form-select @error('i_category_id') is-invalid @enderror">
                                    @foreach ($icategories as $icategory)
                                        <option value="{{ $icategory['id'] }}" @selected($ingredient['i_category_id'] == $icategory['id'])>
                                            {{ $icategory['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="i_category_id">Categoría</label>

                                @error('i_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme">
                                    <i class='bx bxs-edit-alt'></i> Editar ingrediente
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
