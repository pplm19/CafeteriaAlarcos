@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('content')
    <div class="container content pt-10rem">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            Editar mesa
                        </h3>

                        <form action="{{ route('tables.update', $table['id']) }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf
                            @method('PUT')

                            <div class="form-floating mt-3">
                                <input type="number" min="1" name="quantity" id="quantity"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ $table['quantity'] }}" placeholder="Cantidad" required min="1"
                                    max="65535" autofocus />
                                <label for="quantity"><i class='bx bxs-food-menu'></i> Cantidad</label>

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="number" min="1" name="maxNumber" id="maxNumber"
                                    class="form-control @error('maxNumber') is-invalid @enderror"
                                    value="{{ $table['maxNumber'] }}" placeholder="Máximo" required min="1"
                                    max="65535" />
                                <label for="maxNumber"><i class='bx bxs-food-menu'></i> Máximo</label>

                                @error('maxNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="number" min="1" name="minNumber" id="minNumber"
                                    class="form-control @error('minNumber') is-invalid @enderror"
                                    value="{{ $table['minNumber'] }}" placeholder="Mínimo" required min="1"
                                    max="65535" />
                                <label for="minNumber"><i class='bx bxs-food-menu'></i> Mínimo</label>

                                @error('minNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    value="{{ $table['description'] }}" placeholder="Descripción" maxlength="255" />
                                <label for="description"><i class='bx bxs-food-menu'></i> Descripción</label>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme">
                                    <i class='bx bxs-edit-alt'></i> Editar mesa
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
