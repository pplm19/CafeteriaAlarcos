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

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">

                <div class="section-title">
                    <h2><span>Contacta</span>nos</h2>
                    <p>Mediante este formulario puedes ponerte en contacto con nosotros.</p>
                </div>
            </div>

            <div class="map">
                <iframe style="border:0; width: 100%; height: 350px;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3101.473875032006!2d-3.9284349240591387!3d38.981679971706164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6bc33e3658240b%3A0xac4f1c4ec2360744!2sIES%20Santa%20Mar%C3%ADa%20de%20Alarcos!5e0!3m2!1ses!2ses!4v1694541209933!5m2!1ses!2ses"
                    frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="container mt-5">

                <div class="info-wrap">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 info">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Localización:</h4>
                            <p>A108 Adam Street<br>New York, NY 535022</p>
                        </div>

                        <div class="col-lg-3 col-md-6 info mt-4 mt-lg-0">
                            <i class="bi bi-clock"></i>
                            <h4>Horario:</h4>
                            <p>Monday-Saturday:<br>11:00 AM - 2300 PM</p>
                        </div>

                        <div class="col-lg-3 col-md-6 info mt-4 mt-lg-0">
                            <i class="bi bi-envelope"></i>
                            <h4>Correo electrónico:</h4>
                            <p>info@example.com<br>contact@example.com</p>
                        </div>

                        <div class="col-lg-3 col-md-6 info mt-4 mt-lg-0">
                            <i class="bi bi-phone"></i>
                            <h4>Teléfono:</h4>
                            <p>+1 5589 55488 51<br>+1 5589 22475 14</p>
                        </div>
                    </div>
                </div>

                <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                    <div class="row g-2">
                        <div class="form-floating col-md">
                            <input type="text" class="form-control is-valid" name="name" id="name"
                                placeholder="Tu nombre" required>
                            <label for="name">Tu nombre</label>
                            <div class="valid-feedback">
                                ¡Correcto!
                            </div>
                        </div>
                        <div class="col-md form-floating">
                            <input type="email" class="form-control is-invalid" name="email" id="email"
                                placeholder="Tu correo electrónico" required>
                            <label for="email">Tu correo electrónico</label>
                            <div class="invalid-feedback">
                                El correo electrónico es incorrecto.
                            </div>
                        </div>
                    </div>
                    <div class="g-2 mt-3 form-floating">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto"
                            required>
                        <label for="subject">Asunto</label>
                    </div>
                    <div class="g-2 mt-3 form-floating">
                        <textarea class="form-control" placeholder="Deja tu comentario aquí." name="message" id="message"
                            style="height: 100px" required></textarea>
                        <label for="floatingTextarea2">Comentarios</label>
                    </div>
                    <div class="text-center mt-3"><button type="submit">Enviar mensaje</button></div>
                </form>
            </div>
        </section><!-- End Contact Section -->

    </main>
@endsection
