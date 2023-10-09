@extends('layouts.app')

@pushOnce('scripts')
    @vite(['resources/js/bookingsCalendar.js'])
@endPushOnce

<script>
    const baseUrl = {{ Js::from(route('userbookings.create', '')) }};
    const turns = {{ Js::from($turns) }};
</script>

@section('content')
    <div class="content py-5 px-1 px-md-5">
        <a href="{{ route('userbookings.index') }}" class="btn btn-secondary">
            <i class="bi bi-backspace me-1"></i> Volver
        </a>

        <div class="text-center mb-5">
            <h1>Turnos disponibles</h1>
        </div>

        <div class="row">
            <div class="col-11 col-md-9 col-lg-7 col-xl-6 mx-auto">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection
