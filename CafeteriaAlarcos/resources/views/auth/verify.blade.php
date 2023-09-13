@extends('layouts.app')

@section('content')
    <div class="container content pt-10rem">
        <div class="row justify-content-center">
            <div class="col-11 col-md-10 col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            {{ __('Verify Your Email Address') }}
                        </h3>

                        <div class="card-text mt-3">
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                    {{ __('click here to request another') }}
                                </button>.
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
