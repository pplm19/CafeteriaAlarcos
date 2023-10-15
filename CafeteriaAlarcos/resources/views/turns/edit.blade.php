@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js'])
@endPushOnce

@section('pagetitle')
    <a href="{{ route('turns.index') }}" class="btn btn-secondary">
        <i class="bi bi-backspace me-1"></i> Volver
    </a>
@endsection

@section('content')
    <div class="justify-content-center row">
        <div class="col-11 col-md-10 col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                        Editar turno
                    </h3>

                    <form action="{{ route('turns.update', $turn['id']) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <div class="form-floating mt-3">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ $turn['name'] }}"
                                placeholder="Nombre" required maxlength="255" autofocus />
                            <label for="name">Nombre</label>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="date" name="date" id="date"
                                class="form-control @error('date') is-invalid @enderror" value="{{ $turn['date'] }}"
                                required />
                            <label for="date">Fecha</label>

                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="time" name="start" id="start"
                                class="form-control @error('start') is-invalid @enderror" value="{{ $turn['start'] }}"
                                placeholder="Inicio" required />
                            <label for="start">Inicio</label>

                            @error('start')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-floating mt-3">
                            <input type="time" name="end" id="end"
                                class="form-control @error('end') is-invalid @enderror" value="{{ $turn['end'] }}"
                                placeholder="Fin" />
                            <label for="end">Fin</label>

                            @error('end')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="text" name="description" id="description"
                                class="form-control @error('description') is-invalid @enderror"
                                value="{{ $turn['description'] }}" placeholder="Descripción" maxlength="255" />
                            <label for="description">Descripción</label>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <select name="menu_id" id="menu_id" class="form-select @error('menu_id') is-invalid @enderror"
                                required>
                                <option selected disabled value="">Selecciona un menú</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu['id'] }}" @selected($menu['id'] == $turn['menu']['id'])>
                                        {{ $menu['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="menu_id">Menú</label>

                            @error('menu_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-theme">
                                <i class='bx bxs-edit-alt'></i> Editar turno
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
