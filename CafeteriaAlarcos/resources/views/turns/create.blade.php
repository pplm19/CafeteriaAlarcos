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
                            Crear estructura de turnos
                        </h3>

                        <form action="{{ route('turns.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="form-floating mt-3">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Nombre" required maxlength="255" autofocus />
                                <label for="name"><i class='bx bxs-food-menu'></i> Nombre</label>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                @isset($date)
                                    <input type="date" name="date" id="date"
                                        class="form-control @error('date') is-invalid @enderror" value="{{ $date }}"
                                        readonly />
                                @else
                                    <input type="date" name="date" id="date"
                                        class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}"
                                        required />
                                @endisset
                                <label for="date"><i class='bx bxs-food-menu'></i> Fecha</label>

                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="time" name="start" id="start"
                                    class="form-control @error('start') is-invalid @enderror" value="{{ old('start') }}"
                                    placeholder="Inicio" required />
                                <label for="start"><i class='bx bxs-food-menu'></i> Inicio</label>

                                @error('start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="time" name="end" id="end"
                                    class="form-control @error('end') is-invalid @enderror" value="{{ old('end') }}"
                                    placeholder="Fin" />
                                <label for="end"><i class='bx bxs-food-menu'></i> Fin</label>

                                @error('end')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('description') }}" placeholder="Descripción" maxlength="255" />
                                <label for="description"><i class='bx bxs-food-menu'></i> Descripción</label>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme">
                                    <i class='bx bxs-plus-circle'></i> Crear estructura de turnos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
