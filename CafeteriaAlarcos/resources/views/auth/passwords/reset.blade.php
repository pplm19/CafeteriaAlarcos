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
                            {{ __('Reset Password') }}
                        </h3>

                        <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate>
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-floating mt-3">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ $email ?? old('email') }}" autocomplete="email"
                                    placeholder="{{ __('Email Address') }}" required maxlength="255" autofocus />
                                <label for="email"><i class="bx bxs-envelope"></i> {{ __('Email Address') }}</label>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" autocomplete="new-password"
                                    placeholder="{{ __('Password') }}" required minlength="8" />
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
                                    <i class="bi bi-arrow-counterclockwise"></i> {{ __('Reset Password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
