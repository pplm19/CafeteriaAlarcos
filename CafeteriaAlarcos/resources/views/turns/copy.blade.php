@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('content')
    <div class="container content pt-10rem">
        <div class="row justify-content-center">
            <div class="col-11 col-md-10 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            Copiar estructura de turnos
                        </h3>

                        <form action="{{ route('turns.storeCopyStructure') }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf

                            <div class="form-floating mt-3">
                                <input type="date" name="copyFrom" id="copyFrom" value="{{ $copyFrom }}"
                                    class="form-control @error('copyFrom') is-invalid @enderror" readonly>
                                <label for="copyFrom"><i class='bx bxs-food-menu'></i> Fecha de copia</label>

                                @error('copyFrom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="date" name="date" id="date" value="{{ old('date') }}"
                                    class="form-control @error('date') is-invalid @enderror" required>
                                <label for="date"><i class='bx bxs-food-menu'></i> Nueva fecha</label>

                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme">
                                    <i class='bx bxs-copy'></i> Copiar estructura
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
