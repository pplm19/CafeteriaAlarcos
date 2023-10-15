@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js', 'resources/js/disabledUserModal.js'])
@endPushOnce

@section('pagetitle')
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="bi bi-backspace me-1"></i> Volver
    </a>
@endsection

@section('content')
    <div class="justify-content-center row">
        <div class="col-11 col-md-10 col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                        Perfil de {{ $user['name'] }}
                    </h3>

                    <div class="form-floating mt-3">
                        <input type="text" id="name" class="form-control " value="{{ $user['name'] }}"
                            placeholder="{{ __('Name') }}" readonly />
                        <label for="name"><i class="bx bxs-user"></i> {{ __('Name') }}</label>
                    </div>

                    <div class="form-floating mt-3">
                        <input type="text" id="lastname" class="form-control" value="{{ $user['lastname'] }}"
                            placeholder="{{ __('Lastname') }}" readonly />
                        <label for="lastname"><i class="bx bxs-user"></i> {{ __('Lastname') }}</label>
                    </div>

                    <div class="form-floating mt-3">
                        <input type="email" name="email" class="form-control" class="form-control"
                            value="{{ $user['email'] }}" placeholder="{{ __('Email Address') }}" readonly />
                        <label for="email"><i class="bx bxs-envelope"></i> {{ __('Email Address') }}</label>
                    </div>

                    <div class="form-floating mt-3">
                        <input type="tel" id="phone" class="form-control" value="{{ $user['phone'] }}"
                            placeholder="{{ __('Phone') }}" readonly />
                        <label for="phone"><i class="bx bxs-phone"></i> {{ __('Phone') }}</label>
                    </div>

                    <div class="text-center mt-3">
                        @if ($user['disabled'])
                            <form action="{{ route('users.toggleDisable') }}" method="POST">
                                @csrf

                                <input type="hidden" name="user_id" value="{{ $user['id'] }}">

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-toggle-on"></i> Habilitar
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-danger btn-disable-user" data-bs-toggle="modal"
                                data-bs-target="#disableModal" data-user-id="{{ $user['id'] }}">
                                <i class="bi bi-toggle-off"></i> Deshabilitar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="disableModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="disableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="disableModalLabel">Motivo de supensión</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('users.toggleDisable') }}" method="POST" class="needs-validation m-0" novalidate>
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="user_id">
                        <textarea type="text" name="disable_reason" id="disable_reason"
                            class="form-control @error('disable_reason') is-invalid @enderror"
                            placeholder="Tu cuenta ha sido deshabilitada, contacta con un administrador para obtener más información"
                            maxlength="255" style="resize: none"></textarea>

                        @error('disable_reason')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-theme">Suspender cuenta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
