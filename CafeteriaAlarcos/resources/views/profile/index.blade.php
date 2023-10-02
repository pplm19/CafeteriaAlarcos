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
                            Perfil
                        </h3>

                        <form action="{{ route('profile.update') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="form-floating mt-3">
                                <input type="text" name="username" id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ $user['username'] }}" autocomplete="username"
                                    placeholder="{{ __('Username') }}" required maxlength="255" autofocus />
                                <label for="username"><i class="bx bxs-user"></i> {{ __('Username') }}</label>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="email" name="email" class="form-control"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ $user['email'] }}"
                                    placeholder="{{ __('Email Address') }}" readonly />
                                <label for="email"><i class="bx bxs-envelope"></i> {{ __('Email Address') }}</label>
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ $user['name'] }}"
                                    placeholder="{{ __('Name') }}" readonly />
                                <label for="name"><i class="bx bxs-user"></i> {{ __('Name') }}</label>
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" name="lastname" id="lastname"
                                    class="form-control @error('lastname') is-invalid @enderror"
                                    value="{{ $user['lastname'] }}" placeholder="{{ __('Lastname') }}" readonly />
                                <label for="lastname"><i class="bx bxs-user"></i> {{ __('Lastname') }}</label>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="tel" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ $user['phone'] }}"
                                    autocomplete="phone" placeholder="{{ __('Phone') }}" pattern="^\d{9}$" />
                                <label for="phone"><i class="bx bxs-phone"></i> {{ __('Phone') }}</label>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
