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
                            Cambiar contraseña
                        </h3>

                        <form action="{{ route('profile.updatePassword') }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf
                            @method('PUT')

                            <div class="form-floating mt-3">
                                <input type="password" name="oldPassword" id="oldPassword"
                                    class="form-control @error('oldPassword') is-invalid @enderror"
                                    autocomplete="current-password" placeholder="{{ __('Password') }} actual" required
                                    minlength="8" />
                                <label for="oldPassword"><i class="bx bxs-lock"></i> {{ __('Password') }} actual</label>

                                @error('oldPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="password" name="newPassword" id="newPassword"
                                    class="form-control @error('newPassword') is-invalid @enderror"
                                    autocomplete="current-password" placeholder="Nueva {{ __('Password') }}" required
                                    minlength="8" />
                                <label for="newPassword"><i class="bx bxs-lock"></i> Nueva {{ __('Password') }}</label>

                                @error('newPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="password" name="newPassword_confirmation" id="newPassword_confirmation"
                                    class="form-control" autocomplete="new-password"
                                    placeholder="{{ __('Confirm Password') }}" required minlength="8" />
                                <label for="newPassword_confirmation"><i class="bx bxs-lock"></i>
                                    {{ __('Confirm Password') }}</label>

                                @error('newPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-theme">
                                    <i class="bi bi-pencil-fill"></i> Cambiar contraseña
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
