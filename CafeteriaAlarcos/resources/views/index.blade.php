@extends('layouts.app')

@section('content')
    <!-- ======= Carousel Section ======= -->
    <section id="carouselS">
        <div class="carouselS-container">
            <div id="carousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true"
                        aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner" role="group">

                    <!-- Slide 1 -->
                    <div class="carousel-item active" style="background-image: url({{ asset('img/slide/slide-1.jpg') }});">
                        <div class="carousel-container">
                            <div class="carousel-content">
                                <h2 class="animate__animated animate__fadeInDown"><span>Cafetería</span> Alarcos</h2>
                                <p class="animate__animated animate__fadeInUp">La cafetería Alarcos es el lugar donde
                                    los alumnos de restauración del IES Sta María de Alarcos realizan sus prácticas.</p>
                                @auth
                                    @hasrole('User')
                                        <a href="{{ route('userbookings.available') }}"
                                            class="btn-menu animate__animated animate__fadeInUp">Realizar una reserva</a>
                                    @endhasrole
                                @else
                                    <div>
                                        <a href="{{ route('login') }}" class="btn-menu animate__animated animate__fadeInUp">
                                            Iniciar sesión
                                        </a>
                                        <a href="{{ route('register') }}"
                                            class="btn-book animate__animated animate__fadeInUp">Regístrate</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item" style="background-image: url({{ asset('img/slide/slide-2.jpg') }});">
                        <div class="carousel-container">
                            <div class="carousel-content">
                                <h2 class="animate__animated animate__fadeInDown">Reservas</h2>
                                <p class="animate__animated animate__fadeInUp">Para poder reservar una mesa debes
                                    registrate previamente en la aplicación. Para poder registrarte debes ser miembro de
                                    la comunidad educativa.</p>
                                @auth
                                    @hasrole('User')
                                        <a href="{{ route('userbookings.available') }}"
                                            class="btn-menu animate__animated animate__fadeInUp">Realizar una reserva</a>
                                    @endhasrole
                                @else
                                    <div>
                                        <a href="{{ route('login') }}"
                                            class="btn-menu animate__animated animate__fadeInUp">Inicia
                                            sesión</a>
                                        <a href="{{ route('register') }}"
                                            class="btn-book animate__animated animate__fadeInUp">Regístrate</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item" style="background-image: url({{ asset('img/slide/slide-3.jpg') }});">
                        <div class="carousel-container">
                            <div class="carousel-content">
                                <h2 class="animate__animated animate__fadeInDown">Comida sana y equilibrada</h2>
                                <p class="animate__animated animate__fadeInUp">Todos nuestros menús están elaborados con
                                    productos de primera calidad. Nuestras recetas son sanas y equilibradas.</p>
                                @auth
                                    @hasrole('User')
                                        <a href="{{ route('userbookings.available') }}"
                                            class="btn-menu animate__animated animate__fadeInUp">Realizar una reserva</a>
                                    @endhasrole
                                @else
                                    <div>
                                        <a href="{{ route('login') }}"
                                            class="btn-menu animate__animated animate__fadeInUp">Inicia
                                            sesión</a>
                                        <a href="{{ route('register') }}"
                                            class="btn-book animate__animated animate__fadeInUp">Regístrate</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>

                </div>

                <a class="carousel-control-prev" href="#carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                </a>

                <a class="carousel-control-next" href="#carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-5 align-items-stretch video-box"
                        style='background-image: url("{{ asset('img/about.jpg') }}");'>
                        <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="venobox play-btn mb-4"
                            data-vbtype="video" data-autoplay="true"></a>
                    </div>

                    <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch">

                        <div class="content">
                            <h3>Sobre <strong>nosotros</strong></h3>
                            <p>
                                En esta sección explicamos en qué consiste el proyecto Cafetería Alarcos, su
                                funcionamiento, etc.
                            </p>
                            <p class="fst-italic">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore
                                magna aliqua.
                            </p>
                            <ul>
                                <li><i class="bx bx-check-double"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.</li>
                                <li><i class="bx bx-check-double"></i> Duis aute irure dolor in reprehenderit in
                                    voluptate velit.</li>
                                <li><i class="bx bx-check-double"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate trideta
                                    storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                            </ul>
                            <p>
                                Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in
                                culpa qui officia deserunt mollit anim id est laborum
                            </p>
                        </div>

                    </div>

                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= Whu Us Section ======= -->
        <section id="why-us" class="why-us">
            <div class="container">

                <div class="section-title">
                    <h2>Sobre <span>nosotros</span></h2>
                    <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas
                        atque vitae autem.</p>
                </div>

                <div class="row">

                    <div class="col-lg-4">
                        <div class="box">
                            <span>01</span>
                            <h4>Lorem Ipsum</h4>
                            <p>Ulamco laboris nisi ut aliquip ex ea commodo consequat. Et consectetur ducimus vero
                                placeat</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="box">
                            <span>02</span>
                            <h4>Repellat Nihil</h4>
                            <p>Dolorem est fugiat occaecati voluptate velit esse. Dicta veritatis dolor quod et vel dire
                                leno para dest</p>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="box">
                            <span>03</span>
                            <h4> Ad ad velit qui</h4>
                            <p>Molestiae officiis omnis illo asperiores. Aut doloribus vitae sunt debitis quo vel nam
                                quis</p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Whu Us Section -->

        <!-- ======= Gallery Section ======= -->
        <section id="gallery" class="gallery">
            <div class="container-fluid">

                <div class="section-title">
                    <h2>Nuestro <span>Restaurante</span></h2>
                    <p>Aquí os ofrecemos algunas fotografías de lo que os encontraréis en Cafetería Alarcos.</p>
                </div>

                <div class="row g-0">

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('/img/gallery/gallery-1.jpg') }}" class="gallery-lightbox">
                                <img src="{{ asset('/img/gallery/gallery-1.jpg') }}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('/img/gallery/gallery-2.jpg') }}" class="gallery-lightbox">
                                <img src="{{ asset('/img/gallery/gallery-2.jpg') }}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('/img/gallery/gallery-3.jpg') }}" class="gallery-lightbox">
                                <img src="{{ asset('/img/gallery/gallery-3.jpg') }}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('/img/gallery/gallery-4.jpg') }}" class="gallery-lightbox">
                                <img src="{{ asset('/img/gallery/gallery-4.jpg') }}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('/img/gallery/gallery-5.jpg') }}" class="gallery-lightbox">
                                <img src="{{ asset('/img/gallery/gallery-5.jpg') }}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('/img/gallery/gallery-6.jpg') }}" class="gallery-lightbox">
                                <img src="{{ asset('/img/gallery/gallery-6.jpg') }}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('/img/gallery/gallery-7.jpg') }}" class="gallery-lightbox">
                                <img src="{{ asset('/img/gallery/gallery-7.jpg') }}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="gallery-item">
                            <a href="{{ asset('/img/gallery/gallery-8.jpg') }}" class="gallery-lightbox">
                                <img src="{{ asset('/img/gallery/gallery-8.jpg') }}" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Gallery Section -->
    </main>
@endsection
