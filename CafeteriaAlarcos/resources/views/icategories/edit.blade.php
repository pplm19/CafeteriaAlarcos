@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('pagetitle')
    <a href="{{ route('icategories.index') }}" class="btn btn-secondary">
        <i class="bi bi-backspace me-1"></i> Volver
    </a>
@endsection

@section('content')
    <div class="justify-content-center row">
        <div class="col-11 col-md-10 col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                        Editar categoría de ingrediente
                    </h3>

                    <form action="{{ route('icategories.update', $icategory['id']) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <div class="form-floating mt-3">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ $icategory['name'] }}"
                                placeholder="Nombre" required maxlength="255" autofocus />
                            <label for="name">Nombre</label>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-theme">
                                <i class='bx bxs-edit-alt'></i> Editar categoría
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
