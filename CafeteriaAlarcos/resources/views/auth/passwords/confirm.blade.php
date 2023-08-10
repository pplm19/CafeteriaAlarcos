@extends('layouts.app')

@section('content')
    <div class="container content pt-10rem">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            {{ __('Confirm Password') }}
                        </h3>

                        {{ __('Please confirm your password before continuing.') }}

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-floating mt-3">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="current-password" placeholder="{{ __('Password') }}" required
                                    minlength="8" autofocus />
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

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme">
                                    <i class="bi bi-shield-check"></i> {{ __('Confirm Password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
