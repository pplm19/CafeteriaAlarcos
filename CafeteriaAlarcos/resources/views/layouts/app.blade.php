<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cafetería Sta María de Alarcos</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="icon" type="image/jpg" href="{{ asset('img/favicon.png') }}">

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Google Fonts -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>

<body>
    <div id="app">
        <section id="topbar"
            class="d-flex align-items-center fixed-top {{ request()->is('/') ? 'topbar-transparent' : '' }}">
            <div
                class="container-fluid container-xl d-flex align-items-center justify-content-center justify-content-lg-start">
                <i class="bi bi-phone d-flex align-items-center"><span>926 23 06 47</span></i>
                <i class="bi bi-clock ms-4 d-none d-lg-flex align-items-center"><span>Lunes-Viernes: 14:00 -
                        15:30</span></i>
            </div>
        </section>

        <!-- ======= Header ======= -->
        <header id="header"
            class="fixed-top d-flex align-items-center {{ request()->is('/') ? 'header-transparent' : '' }}">
            <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

                <div class="logo me-auto">
                    <h1><a href="{{ route('index') }}"><img src="{{ asset('img/logo.png') }}" alt=""
                                class="img-fluid"><span> Cafetería</span> Alarcos</a></h1>
                </div>

                <nav id="navbar" class="navbar order-last order-lg-0">
                    <ul>
                        <li><a class="nav-link scrollto" href="{{ route('index') }}#carouselS">Inicio</a></li>
                        <li><a class="nav-link scrollto" href="{{ route('index') }}#about">Sobre nosotros</a></li>
                        <li><a class="nav-link scrollto" href="{{ route('index') }}#gallery">Galería</a></li>
                        <li><a class="nav-link @if (request()->is('userdishes')) active @endif"
                                href="{{ route('userdishes.index') }}">Platos</a></li>
                        <li><a class="nav-link scrollto" href="{{ route('index') }}#contact">Contacto</a></li>
                        @auth
                            <li><a class="nav-link @if (request()->is('profile*')) active @endif"
                                    href="{{ route('profile.index') }}">Perfil</a></li>
                        @endauth
                        @hasrole('SuperAdmin')
                            <li class="dropdown">
                                <a href="" @class(['active' => request()->is('admin*')])><span>Administración</span>
                                    <i class="bi bi-chevron-down"></i></a>
                                <ul>
                                    <li class="dropdown">
                                        <a href="" @class(['active' => request()->is('admin/users*')])><span>Usuarios</span>
                                            <i class="bi bi-chevron-right"></i></a>
                                        <ul>
                                            <li>
                                                <a href="{{ route('users.index') }}" @class([
                                                    'active' =>
                                                        request()->path() !== 'admin/users/registerRequests' &&
                                                        request()->is('admin/users*'),
                                                ])>Gestionar
                                                    usuarios</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('users.registerRequests') }}"
                                                    @class(['active' => request()->is('admin/users/registerRequests')])>Solicitudes de registro</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('icategories.index') }}" @class(['active' => request()->is('admin/icategories*')])>Categorías
                                            de ingredientes</a></li>
                                    <li><a href="{{ route('ingredients.index') }}"
                                            @class(['active' => request()->is('admin/ingredients*')])>Ingredientes</a></li>
                                    <li><a href="{{ route('types.index') }}" @class(['active' => request()->is('admin/types*')])>Tipos de
                                            platos</a></li>
                                    <li><a href="{{ route('dcategories.index') }}" @class(['active' => request()->is('admin/dcategories*')])>Categorías
                                            de platos</a></li>
                                    <li><a href="{{ route('allergens.index') }}"
                                            @class(['active' => request()->is('admin/allergens*')])>Alérgeneos</a></li>
                                    <li><a href="{{ route('dishes.index') }}" @class(['active' => request()->is('admin/dishes*')])>Platos</a></li>
                                    <li><a href="{{ route('menus.index') }}" @class(['active' => request()->is('admin/menus*')])>Menús</a></li>
                                    <li><a href="{{ route('turns.index') }}" @class(['active' => request()->is('admin/turns*')])>Turnos</a></li>
                                    <li><a href="{{ route('tables.index') }}" @class(['active' => request()->is('admin/tables*')])>Mesas</a></li>
                                    <li><a href="{{ route('bookings.index') }}" @class(['active' => request()->is('admin/bookings*')])>Reservas</a>
                                    </li>
                                    <li><a href="{{ route('configurations.index') }}"
                                            @class(['active' => request()->is('admin/configurations*')])>Configuración</a></li>
                                </ul>
                            </li>
                        @endhasrole
                    </ul>

                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->

                @auth
                    <a href="{{ route('logout') }}" class="book-a-table-btn scrollto"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    {{-- Config value --}}
                    @if (Cookie::get('laravel_cookie_consent') !== null)
                        <a href="{{ route('login') }}" class="book-a-table-btn scrollto">Iniciar sesión</a>
                    @else
                        <a href="{{ route('register') }}" class="book-a-table-btn scrollto">Regístrate</a>
                    @endif
                @endauth

            </div>
        </header><!-- End Header -->

        <main>
            @yield('content')
        </main>

        <!-- ======= Footer ======= -->
        <footer id="footer" class="fixed-bottom">
            <div class="container">
                <h3><a href="{{ route('index') }}">Cafetería Alarcos</a></h3>
                <p>Frase interesante.</p>
                <div class="social-links">
                    <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                    <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                </div>
                <div class="copyright">
                    &copy; Copyright <strong><span>Cafetería Alarcos</span></strong>. Todos los derechos reservados
                </div>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/delicious-free-restaurant-bootstrap-theme/ -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top scrollto d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        {{-- @include('cookie-consent::index') --}}
    </div>
</body>

</html>