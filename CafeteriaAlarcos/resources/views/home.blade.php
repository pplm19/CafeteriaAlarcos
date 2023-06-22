@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <nav class="nav flex-column">
                            @hasrole('User')
                                <a class="nav-link" href="{{ route('profile.index') }}">Profile</a>
                                <a class="nav-link" href="{{ route('userbookings.create') }}">Realizar reserva</a>
                                <a class="nav-link" href="{{ route('userbookings.index') }}">Reservas realizadas</a>
                                <a class="nav-link" href="{{ route('userbookings.history') }}">Historial de reservas</a>
                            @else
                                <a class="nav-link" href="{{ route('userbookings.create') }}">Bookings</a>
                            @endhasrole

                            <a class="nav-link" href="{{ route('userdishes.index') }}">Dishes</a>

                            @hasrole('SuperAdmin')
                                <a class="nav-link" href="{{ route('admin') }}">Admin</a>
                            @endhasrole
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
