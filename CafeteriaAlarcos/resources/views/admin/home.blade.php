@extends('layouts.app')

@section('content')
    <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('home') }}">Home</a>

        <a class="nav-link" href="{{ route('users.registerRequests') }}">Solicitudes de registro</a>
        <a class="nav-link" href="{{ route('users.index') }}">Users</a>

        <a class="nav-link" href="{{ route('icategories.index') }}">ICategories</a>
        <a class="nav-link" href="{{ route('ingredients.index') }}">Ingredients</a>
        <a class="nav-link" href="{{ route('dishes.index') }}">Dishes</a>
        <a class="nav-link" href="{{ route('types.index') }}">Types</a>
        <a class="nav-link" href="{{ route('dcategories.index') }}">DCategories</a>
        <a class="nav-link" href="{{ route('allergens.index') }}">Allergens</a>
        <a class="nav-link" href="{{ route('menus.index') }}">Menus</a>

        <a class="nav-link" href="{{ route('turns.index') }}">Turns</a>
        <a class="nav-link" href="{{ route('tables.index') }}">Tables</a>
        <a class="nav-link" href="{{ route('bookings.index') }}">Bookings</a>

        <a class="nav-link" href="{{ route('configurations.index') }}">Configuración</a>
    </nav>
@endsection
