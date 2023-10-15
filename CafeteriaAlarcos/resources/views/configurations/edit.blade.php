@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('pagetitle')
    <a href="{{ route('configurations.index') }}" class="btn btn-secondary">
        <i class="bi bi-backspace me-1"></i> Volver
    </a>
@endsection

@section('content')
    <div class="justify-content-center row">
        <div class="col-11 col-md-10 col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                        Editar configuración
                    </h3>

                    <form action="{{ route('configurations.update', $configuration['id']) }}" method="POST"
                        class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="form-floating mt-3">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ $configuration['name'] }}" readonly />
                            <label for="name">Nombre</label>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="text" name="value" id="value"
                                class="form-control @error('value') is-invalid @enderror"
                                value="{{ $configuration['value'] }}" required maxlength="255" autofocus />
                            <label for="value">Valor</label>

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-theme">
                                <i class='bx bxs-edit-alt'></i> Editar configuración
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
