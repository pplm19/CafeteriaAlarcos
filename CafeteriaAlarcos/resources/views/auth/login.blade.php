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
                            {{ __('Login') }}
                        </h3>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                            @csrf

                            <div class="form-floating mt-3">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    autofocus autocomplete="email" placeholder="{{ __('Email Address') }}" required
                                    maxlength="255" />
                                <label for="email"><i class="bx bxs-envelope"></i> {{ __('Email Address') }}</label>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="current-password" placeholder="{{ __('Password') }}" required
                                    minlength="8" />
                                <label for="password"><i class="bx bxs-lock"></i> {{ __('Password') }}</label>

                                <a class="btn btn-link text-decoration-none text-theme p-0 mt-2"
                                    href="{{ route('password.request') }}">
                                    <i class="bx bx-reset align-middle"></i> {{ __('Forgot Your Password?') }}
                                </a>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme"><i
                                        class="bi bi-door-open-fill align-middle"></i>
                                    {{ __('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mt-2">
                            <a class="btn btn-link text-decoration-none text-theme" href="{{ route('register') }}">
                                <i class="bx bx-user-plus align-middle"></i> ¿No tienes una cuenta? Regístrate
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
