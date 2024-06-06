<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tu taller+</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <!-- CDN iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/EstilosWelcome.css', 'resources/css/headerNav.css', 'resources/js/welcome.js'])
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
    </script>
</head>

<body class="antialiased">
    <header>
        <div class="logo-container">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo de la empresa">
        </div>
        <nav class="navigation">
            @auth
                <div>
                    <a href="{{ url('/miseccion') }}" class="miSeccion">
                        <i class="fa-solid fa-warehouse" style="color: #ffffff;"></i>
                        <p>Mi garaje</p>
                    </a>
                </div>
                @if (!auth()->user()->taller)
                    <div>
                        <a href="{{ url('/formularioTaller') }}" class="miSeccion">
                            <i class="fa-solid fa-building-circle-arrow-right" style="color: #ffffff;"></i>
                            <p>Unirse como taller</p>
                        </a>
                    </div>
                @else
                    <div>
                        <a href="{{ url('/mitaller') }}" class="miSeccion">
                            <i class="fa-solid fa-screwdriver-wrench" style="color: #ffffff;"></i>
                            <p>Mi taller</p>
                        </a>
                    </div>
                @endif
            @else
                <div>
                    <a href="{{ route('login') }}" class="login">
                        <i class="fa-solid fa-right-to-bracket" style="color: #ffffff;"></i>
                        <p>Entrar</p>
                    </a>
                </div>
                @if (Route::has('register'))
                    <div>
                        <a href="{{ route('register') }}" class="register ml-4">
                            <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                            Registrarse
                        </a>
                    </div>
                @endif
            @endauth
        </nav>
        <div class="user-image-container">
            @auth
                <a href="{{ route('profile.edit') }}">
                    @if (auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Image">
                    @else
                        <div class="divIconsUser">
                            <i class="fa-solid fa-user" style="color: #000000;"></i>
                        </div>
                    @endif
                </a>
            @else
                <div class="divIconsUser">
                    <i class="fa-solid fa-user" style="color: #000000;"></i>
                </div>
            @endguest
        </div>
    </header>






    <button id="info-button" class="info-button">¿Qué es esto?</button>

    <div id="info-modal" class="info-modal">
        <div class="info-modal-content">
            <h2>Información sobre esta  web.</h2>
            <p>Esta web permite buscar talleres mecánicos por ubicación y especialidad. Los talleres destacados se
                muestran primero y luego todos los talleres disponibles. Puedes hacer clic en los talleres para ver más
                detalles. Usa los filtros para encontrar talleres específicos.</p>
            <button id="close-info-button" class="close-info-button">Entendido</button>
        </div>
    </div>

    <form id="search-form" action="{{ route('welcome') }}" method="GET" class="search-form">
        <div class="input-group mb-3 search-group">
            <input list="cities" id="ubicacion" name="ubicacion" class="form-control search-input"
                placeholder="Buscar por ubicación" value="{{ request('ubicacion', 'Tarragona') }}">
            <datalist id="cities">
                <option value="Madrid">
                <option value="Barcelona">
                <option value="Valencia">
                    <!-- Continúa añadiendo más ciudades según sea necesario -->
            </datalist>
        </div>
        <div class="input-group mb-3 search-group">
            <select id="especialidad" name="especialidad" class="form-control search-input">
                <option value="">Buscar por especialidad</option>
                <option value="Alto rendimiento (tuning)">Alto rendimiento (tuning)</option>
                <option value="Chapa">Chapa</option>
                <option value="Chapa y pintura">Chapa y pintura</option>
                <option value="Diagnóstico">Diagnóstico</option>
                <option value="Eléctricos">Eléctricos</option>
                <option value="Electronica">Electronica</option>
                <option value="Sistemas de audio y video">Sistemas de audio y video</option>
                <option value="Mecánica general">Mecánica general</option>
                <option value="Multimarca">Multimarca</option>
                <option value="Multimarca, chapa y pintura">Multimarca, chapa y pintura</option>
                <option value="Peritación de vehículos">Peritación de vehículos</option>
                <option value="Pintura">Pintura</option>
                <option value="Restauración">Restauración</option>
                <option value="Neumáticos">Neumáticos</option>
                <option value="Taller oficial Audi-Volkswagen-SEAT-Škoda">Taller oficial Audi-Volkswagen-SEAT-Škoda
                </option>
                <option value="Taller oficial Peugeot-Citroën-Opel-DS">Taller oficial Peugeot-Citroën-Opel-DS</option>
                <option value="Taller oficial Renault-Nissan-Mitsubishi-Dacia">Taller oficial
                    Renault-Nissan-Mitsubishi-Dacia</option>
                <option value="Taller oficial Ford">Taller oficial Ford</option>
                <option value="Taller oficial BMW-MINI">Taller oficial BMW-MINI</option>
                <option value="Taller oficial Mercedes-Benz-Smart">Taller oficial Mercedes-Benz-Smart</option>
                <option value="Taller oficial Fiat-Alfa Romeo-Lancia">Taller oficial Fiat-Alfa Romeo-Lancia</option>
                <option value="Vehículos clásicos">Vehículos clásicos</option>
                <option value="Vehículos industriales">Vehículos industriales</option>
            </select>
        </div>
        <div class="input-group mb-3 search-group">
            <button class="btn btn-primary search-button" type="submit">Buscar</button>
        </div>
    </form>

    <div class="main-content">
        <div class="content-left">
            <div class="title-container">
                <h2>Talleres Destacados</h2>
            </div>
            <div class="talleres-destacados">
                @foreach ($talleresDestacados as $taller)
                    <div class="card card-destacado">
                        @auth
                            <a href="{{ route('taller.verTallerCard', ['id' => $taller->id]) }}" class="miSeccion">
                            @else
                                <a href="#"
                                    onclick="alert('Necesitas estar logueado para ver los detalles del taller.'); return false;"
                                    class="miSeccion">
                                @endauth
                                <img src="{{ $taller->image_path ? asset('storage/' . $taller->image_path) : asset('images/fotoTallerRandom.jpg') }}"
                                    class="card-img-top" alt="Imagen del Taller">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $taller->nombre_de_taller }}</h5>
                                    <p class="card-text">{!! renderStars($taller->averageRating()) !!}
                                        {{ number_format($taller->averageRating(), 1) }} estrellas</p>
                                    <p class="card-text"><strong>Especialidad:</strong> {{ $taller->especialidad }}
                                    </p>
                                </div>
                            </a>
                    </div>
                @endforeach
            </div>

            <div class="title-container">
                <h2>Todos los Talleres</h2>
            </div>
            <div class="talleres-todos">
                @foreach ($talleres as $taller)
                    <div class="card">
                        @auth
                            <a href="{{ route('taller.verTallerCard', ['id' => $taller->id]) }}" class="miSeccion">
                            @endauth
                            <img src="{{ $taller->image_path ? asset('storage/' . $taller->image_path) : asset('images/fotoTallerRandom.jpg') }}"
                                class="card-img-top" alt="Imagen del Taller">
                            <div class="card-body">
                                <h5 class="card-title">{{ $taller->nombre_de_taller }}</h5>
                                <p class="card-text">Calificación promedio: {!! renderStars($taller->averageRating()) !!}
                                    {{ number_format($taller->averageRating(), 1) }} estrellas</p>
                                <p class="card-text"><strong>Especialidad:</strong> {{ $taller->especialidad }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="content-right">
            <div class="map-container">
                <div id="map"></div>
            </div>
        </div>
    </div>









    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h5>Contacto</h5>
                <p><i class="fas fa-phone"></i> +34 956 45 12 62</p>
                <p><i class="fas fa-envelope"></i> jose.rodriguez@insbaixcamp.cat</p>
                <p><i class="fas fa-map-marker-alt"></i> Calle Juan, 123, Madrid, España</p>
            </div>
            <div class="footer-section">
                <h5>Enlaces Rápidos</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Inicio</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h5>Síguenos</h5>
                <div class="social-icons">
                    <a href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Tu+Taller. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script>
        function initMap() {
            var initialCoordinates = {
                lat: {{ $coordinates['lat'] }},
                lng: {{ $coordinates['lng'] }}
            };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: initialCoordinates
            });

            var locations = @json($locations);
            locations.forEach(function(location) {
                if (location.latitude && location.longitude && location.taller) {
                    var marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(location.latitude),
                            lng: parseFloat(location.longitude)
                        },
                        map: map,
                        title: location.taller.nombre_de_taller
                    });
                    google.maps.event.addListener(marker, 'click', function() {
                        window.location.href = '/taller/' + location.taller_id;
                    });
                }
            });
        }

        window.addEventListener('load', function() {
            if (typeof initMap === 'function') {
                initMap();
            }

            var talleres = @json($talleres);
            if (talleres.length === 0) {
                document.getElementById('no-talleres-message').style.display = 'block';
            }
        });


        document.getElementById('info-button').addEventListener('click', function() {
            document.getElementById('info-modal').style.display = 'block';
        });

        document.getElementById('close-info-button').addEventListener('click', function() {
            document.getElementById('info-modal').style.display = 'none';
        });
    </script>
</body>

</html>
