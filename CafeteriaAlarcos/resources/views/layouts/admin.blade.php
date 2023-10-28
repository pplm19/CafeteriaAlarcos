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

    <!-- Google Fonts -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/admin.css', 'resources/css/custom.css', 'resources/js/bootstrap.js', 'resources/js/admin.js', 'resources/js/alerts.js'])
    @stack('scripts')
</head>

<body>
    <div id="app">
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
                <i class="bi bi-list toggle-sidebar-btn"></i>
                <a href="{{ route('admin.index') }}" class="logo d-flex align-items-center">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo de la cafetería" class="img-fluid">
                    <span class="d-none d-lg-block"> Cafetería Alarcos</span>
                </a>
            </div><!-- End Logo -->

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon me-3" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            @if (Cache::get('userRequests') > 0)
                                <span class="badge bg-primary badge-number">{{ Cache::get('userRequests') }}</span>
                            @endif
                        </a><!-- End Notification Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                            @if (Cache::get('userRequests') > 0)
                                <li class="notification-item">
                                    <i class="bi bi-info-circle text-primary"></i>
                                    <div>
                                        <h4>Verificación de usuarios</h4>
                                        <p>Hay usuarios pendientes de verificación</p>
                                        <a href="{{ route('users.registerRequests') }}">Ir a solicitudes</a>
                                    </div>
                                </li>
                            @else
                                <li class="dropdown-header">
                                    No hay ninguna notificación
                                </li>
                            @endif
                        </ul><!-- End Notification Dropdown Items -->
                    </li><!-- End Notification Nav -->

                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href=""
                            data-bs-toggle="dropdown">
                            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()['username'] }}</span>
                            <span class="d-block d-md-none dropdown-toggle ps-2 fs-1"></span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>{{ Auth::user()['username'] }}</h6>
                                @php
                                    $userRoles = Auth::user()['roles'];
                                    $lastPos = count($userRoles) - 1;
                                @endphp
                                <span>{{ $userRoles[$lastPos]['name'] }}</span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center justify-content-center"
                                    href="">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </span>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </a>
                            </li>

                        </ul><!-- End Profile Dropdown Items -->
                    </li><!-- End Profile Nav -->

                </ul>
            </nav><!-- End Icons Navigation -->
        </header><!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">
            <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-item">
                    <a @class(['nav-link', 'collapsed' => !request()->is('admin')]) href="{{ route('admin.index') }}">
                        <i class="bi bi-grid"></i>
                        <span>Inicio</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" @class(['nav-link', 'collapsed' => !request()->is('admin/users*')]) data-bs-target="#users-nav" data-bs-toggle="collapse"
                        @if (request()->is('admin/users*'))
                        aria-expanded="true"
                        @endif>
                        <i class="bi bi-people"></i>
                        <span>Usuarios</span>
                        @if (Cache::get('userRequests') > 0)
                            <span class="badge text-bg-danger ms-2">{{ Cache::get('userRequests') }}</span>
                        @endif
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="users-nav" @class([
                        'nav-content',
                        'collapse' => !request()->is('admin/users*'),
                        'show' => request()->is('admin/users*'),
                    ]) data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('users.index') }}" @class([
                                'active' =>
                                    request()->path() !== 'admin/users/registerRequests' &&
                                    request()->is('admin/users*'),
                            ])>
                                <i class="bi bi-circle"></i>
                                Gestionar usuarios
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.registerRequests') }}" @class(['active' => request()->is('admin/users/registerRequests')])>
                                <i class="bi bi-circle"></i>
                                Solicitudes de registro
                                @if (Cache::get('userRequests') > 0)
                                    <span class="badge text-bg-danger ms-2">{{ Cache::get('userRequests') }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a @class([
                        'nav-link',
                        'collapsed' => !request()->is('admin/icategories*'),
                    ]) href="{{ route('icategories.index') }}">
                        <i class="bi bi-bookmark"></i>
                        <span>Categorías de ingredientes</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a @class(['nav-link', 'collapsed' => !request()->is('admin/types*')]) href="{{ route('types.index') }}">
                        <i class="bi bi-journal-bookmark"></i>
                        <span>Tipos de platos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a @class([
                        'nav-link',
                        'collapsed' => !request()->is('admin/dcategories*'),
                    ]) href="{{ route('dcategories.index') }}">
                        <i class="bi bi-tag"></i>
                        <span>Categorías de platos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a @class([
                        'nav-link',
                        'collapsed' => !request()->is('admin/allergens*'),
                    ]) href="{{ route('allergens.index') }}">
                        <i class="bi bi-file-medical"></i>
                        <span>Alérgeneos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a @class(['nav-link', 'collapsed' => !request()->is('admin/dishes*')]) href="{{ route('dishes.index') }}">
                        <i class="bi bi-cup-hot"></i>
                        <span>Platos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a @class(['nav-link', 'collapsed' => !request()->is('admin/menus*')]) href="{{ route('menus.index') }}">
                        <i class="bi bi-file-text"></i>
                        <span>Menús</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a @class(['nav-link', 'collapsed' => !request()->is('admin/turns*')]) href="{{ route('turns.index') }}">
                        <i class="bi bi-calendar-plus"></i>
                        <span>Turnos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a @class(['nav-link', 'collapsed' => !request()->is('admin/tables*')]) href="{{ route('tables.index') }}">
                        <i class="bi bi-card-list"></i>
                        <span>Mesas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a @class(['nav-link', 'collapsed' => !request()->is('admin/bookings*')]) href="{{ route('bookings.index') }}">
                        <i class="bi bi-calendar3"></i>
                        <span>Reservas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a @class([
                        'nav-link',
                        'collapsed' => !request()->is('admin/configurations*'),
                    ]) href="{{ route('configurations.index') }}">
                        <i class="bi bi-gear"></i>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </aside>
        <!-- End Sidebar-->

        @include('layouts.alerts')

        <main id="main">

            <div class="pagetitle">
                @yield('pagetitle')
            </div><!-- End Page Title -->

            <section class="section dashboard pt-2">
                {{-- <div class="row">
                    <!-- Left side columns -->
                    <div class="col-lg-8">
                        <div class="row">

                            <!-- Sales Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card sales-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sales <span>| Today</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-cart"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>145</h6>
                                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                                    class="text-muted small pt-2 ps-1">increase</span>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Sales Card -->

                            <!-- Revenue Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card revenue-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Revenue <span>| This Month</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-currency-dollar"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>$3,264</h6>
                                                <span class="text-success small pt-1 fw-bold">8%</span> <span
                                                    class="text-muted small pt-2 ps-1">increase</span>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Revenue Card -->

                            <!-- Customers Card -->
                            <div class="col-xxl-4 col-xl-12">
                                <div class="card info-card customers-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Customers <span>| This Year</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>1244</h6>
                                                <span class="text-danger small pt-1 fw-bold">12%</span> <span
                                                    class="text-muted small pt-2 ps-1">decrease</span>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div><!-- End Customers Card -->

                            <!-- Reports -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Reports <span>/Today</span></h5>

                                        <!-- Line Chart -->
                                        <div id="reportsChart"></div>
                                        <!-- End Line Chart -->
                                    </div>

                                </div>
                            </div><!-- End Reports -->
                        </div>
                    </div><!-- End Left side columns -->

                    <!-- Right side columns -->
                    <div class="col-lg-4">

                        <!-- Recent Activity -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Recent Activity <span>| Today</span></h5>

                                <div class="activity">

                                    <div class="activity-item d-flex">
                                        <div class="activite-label">32 min</div>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <div class="activity-content">
                                            Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo
                                                officiis</a> beatae
                                        </div>
                                    </div><!-- End activity item-->

                                    <div class="activity-item d-flex">
                                        <div class="activite-label">56 min</div>
                                        <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                        <div class="activity-content">
                                            Voluptatem blanditiis blanditiis eveniet
                                        </div>
                                    </div><!-- End activity item-->

                                    <div class="activity-item d-flex">
                                        <div class="activite-label">2 hrs</div>
                                        <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                        <div class="activity-content">
                                            Voluptates corrupti molestias voluptatem
                                        </div>
                                    </div><!-- End activity item-->

                                    <div class="activity-item d-flex">
                                        <div class="activite-label">1 day</div>
                                        <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                        <div class="activity-content">
                                            Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati
                                                voluptatem</a> tempore
                                        </div>
                                    </div><!-- End activity item-->

                                    <div class="activity-item d-flex">
                                        <div class="activite-label">2 days</div>
                                        <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                                        <div class="activity-content">
                                            Est sit eum reiciendis exercitationem
                                        </div>
                                    </div><!-- End activity item-->

                                    <div class="activity-item d-flex">
                                        <div class="activite-label">4 weeks</div>
                                        <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                        <div class="activity-content">
                                            Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                                        </div>
                                    </div><!-- End activity item-->

                                </div>

                            </div>
                        </div><!-- End Recent Activity -->

                        <!-- Budget Report -->
                        <div class="card">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Budget Report <span>| This Month</span></h5>

                                <div id="budgetChart" style="min-height: 400px;" class="echart"></div>
                            </div>
                        </div><!-- End Budget Report -->
                    </div><!-- End Right side columns -->
                </div> --}}

                @yield('content')
            </section>

        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>{{ config('app.name') }}</span></strong>. Todos los derechos reservados
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
            <i class="bi bi-arrow-up-short"></i>
        </a>
    </div>
</body>

</html>
