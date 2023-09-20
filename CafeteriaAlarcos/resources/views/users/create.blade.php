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
                            {{ __('Register new admin') }}
                        </h3>

                        <form method="POST" action="{{ route('users.store') }}" class="needs-validation" novalidate>
                            @csrf

                            <div class="form-floating mt-3">
                                <input type="text" name="username" id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}" autocomplete="username" placeholder="{{ __('Username') }}"
                                    required maxlength="255" autofocus />
                                <label for="username"><i class="bx bxs-user"></i> {{ __('Username') }}</label>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="email" name="email" id="email" class="form-control"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    autocomplete="email" placeholder="{{ __('Email Address') }}" required maxlength="255" />
                                <label for="email"><i class="bx bxs-envelope"></i> {{ __('Email Address') }}</label>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    autocomplete="name" placeholder="{{ __('Name') }}" required maxlength="255" />
                                <label for="name"><i class="bx bxs-user"></i> {{ __('Name') }}</label>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" name="lastname" id="lastname"
                                    class="form-control @error('lastname') is-invalid @enderror"
                                    value="{{ old('lastname') }}" autocomplete="lastname"
                                    placeholder="{{ __('Lastname') }}" required maxlength="255" />
                                <label for="lastname"><i class="bx bxs-user"></i> {{ __('Lastname') }}</label>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="tel" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                    autocomplete="phone" placeholder="{{ __('Phone') }}" pattern="^\d{9}$" />
                                <label for="phone"><i class="bx bxs-phone"></i> {{ __('Phone') }}</label>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="current-password" placeholder="{{ __('Password') }}" required
                                    minlength="8" />
                                <label for="password"><i class="bx bxs-lock"></i> {{ __('Password') }}</label>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="password" name="password_confirmation" id="password-confirm"
                                    class="form-control" autocomplete="new-password"
                                    placeholder="{{ __('Confirm Password') }}" required minlength="8" />
                                <label for="password-confirm"><i class="bx bxs-lock"></i>
                                    {{ __('Confirm Password') }}</label>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme">
                                    <i class="bx bx-user-plus"></i> {{ __('Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
