@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('pagetitle')
    <a href="{{ route('tables.index') }}" class="btn btn-secondary">
        <i class="bi bi-backspace me-1"></i> Volver
    </a>
@endsection

@section('content')
    <div class="justify-content-center row">
        <div class="col-11 col-md-10 col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                        Crear mesa
                    </h3>

                    <form action="{{ route('tables.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-floating mt-3">
                            <input type="number" min="1" name="quantity" id="quantity"
                                class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}"
                                placeholder="Cantidad" required min="1" max="65535" autofocus />
                            <label for="quantity">Cantidad</label>

                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="number" min="1" name="maxNumber" id="maxNumber"
                                class="form-control @error('maxNumber') is-invalid @enderror" value="{{ old('maxNumber') }}"
                                placeholder="Máximo" required min="1" max="65535" />
                            <label for="maxNumber">Máximo</label>

                            @error('maxNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="number" min="1" name="minNumber" id="minNumber"
                                class="form-control @error('minNumber') is-invalid @enderror" value="{{ old('minNumber') }}"
                                placeholder="Mínimo" required min="1" max="65535" />
                            <label for="minNumber">Mínimo</label>

                            @error('minNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="text" name="description" id="description"
                                class="form-control @error('description') is-invalid @enderror"
                                value="{{ old('description') }}" placeholder="Descripción" maxlength="255" />
                            <label for="description">Descripción</label>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-theme">
                                <i class="bi bi-plus-circle"></i> Crear mesa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
