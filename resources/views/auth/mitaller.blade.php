<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Taller+</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap JS (para el carrusel) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- CDN de íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/EstilosMiTaller.css', 'resources/css/headerNav.css', 'resources/js/jsMitaller.js'])
</head>

<body>

    <!-- NAV HEADER -->
    <header>
        <div class="logo-container">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo de la empresa">
        </div>
        <nav class="navigation">
            @auth
                <div>
                    <a href="{{ url('/') }}">
                        <i class="fa-solid fa-house" style="color: #ffffff;"></i>
                        <p>Inicio</p>
                    </a>
                </div>
                <div>
                    <a href="{{ url('/miseccion') }}" class="miSeccion">
                        <i class="fa-solid fa-warehouse" style="color: #ffffff;"></i>
                        <p>Mi garaje</p>
                    </a>
                </div>
                @if (!auth()->user()->taller)
                    <div>
                        <i class="fa-solid fa-building-circle-arrow-right" style="color: #ffffff;"></i>
                        <a href="{{ url('/formularioTaller') }}" class="miSeccion">
                            <p>Unirse como taller</p>
                        </a>
                    </div>
                @endif
                {{-- @if (auth()->user()->id == $taller->user_id)
                    <div class="notification-container">
                        <i class="fa-solid fa-bell notification-icon" style="color: #ffffff;"
                            onclick="toggleNotifications()"></i>
                        <div class="notification-menu">
                            <h2>Notificaciones</h2>
                            @if ($notifications->isEmpty())
                                <p>No tienes nuevas notificaciones.</p>
                            @else
                                <ul>
                                    @foreach ($notifications as $notification)
                                        <li>
                                            <p>{{ $notification->user->name }} se ha suscrito a tu taller.</p>
                                            <!-- Marcar como leído -->
                                            <form action="{{ route('notifications.read', $notification->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-primary">Marcar como
                                                    leído</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif --}}
            @else
                <div>
                    <i class="fa-solid fa-right-to-bracket" style="color: #ffffff;"></i>
                    <a href="{{ route('login') }}" class="login">
                        <p>Entrar</p>
                    </a>
                </div>
                @if (Route::has('register'))
                    <div>
                        <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                        <a href="{{ route('register') }}" class="register ml-4">Registrarse</a>
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

    <!-- SECCION FOTO DE CABECERA -->
    @if (auth()->check() && auth()->user()->id == $taller->user_id)
        <div class="divImagenCabeceraMaps">
            <div style="display: flex;">
                <div class="header-image-container">
                    <form action="{{ route('mitaller.updateImageTaller') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <figure>
                            <img src="{{ $taller->image_path ? asset('storage/' . $taller->image_path) : asset('images/fotoTallerRandom.jpg') }}"
                                alt="Imagen de cabecera" id="image_path">
                            <div id="divIconoFotoPortada">
                                <label for="fileInput">
                                    <i id="iconoCamara" class="fa-solid fa-camera-retro"></i>
                                </label>
                            </div>
                            <input type="file" id="fileInput" name="image_path" style="display: none;"
                                onchange="form.submit()">
                        </figure>
                    </form>
                </div>
                <div id="map"></div>
            </div>
        @else
            <div class="divImagenCabeceraMaps">
                <div style="display: flex;">
                    <div class="header-image-container">
                        <figure>
                            <img src="{{ $taller->image_path ? asset('storage/' . $taller->image_path) : asset('images/fotoTallerRandom.jpg') }}"
                                alt="Imagen de cabecera" id="image_path">
                            <div id="divIconoFotoPortada" style="visibility: hidden;">
                                <i id="iconoCamara" class="fa-solid fa-camera-retro"></i>
                            </div>
                        </figure>
                    </div>
                    <div id="map"></div>
                </div>
    @endif

    <!-- SECCIÓN FORMULARIO PARA DIRECCIÓN -->
    @if (auth()->check() && auth()->user()->id == $taller->user_id)
        <button class="btn btn-primary" onclick="toggleForm()">Actualizar Dirección del Taller</button>
        <div id="location-form-container" style="margin-top: 20px; display: none;">
            <form id="location-form" action="{{ route('taller.updateLocation', $taller->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="street-input">Calle</label>
                    <input type="text" id="street-input" name="street" class="form-control" placeholder="Calle"
                        required>
                </div>
                <div class="form-group">
                    <label for="city-input">Ciudad</label>
                    <input type="text" id="city-input" name="city" class="form-control" placeholder="Ciudad"
                        required>
                </div>
                <div class="form-group">
                    <label for="postal-code-input">Código Postal</label>
                    <input type="text" id="postal-code-input" name="postal_code" class="form-control"
                        placeholder="Código Postal" required>
                </div>
                <input type="hidden" id="latitude-input" name="latitude">
                <input type="hidden" id="longitude-input" name="longitude">
                <button type="submit" class="btn btn-primary" style="background-color: red">Guardar Dirección</button>
            </form>
        </div>
    @endif

    <!-- SECCIÓN DETALLES DEL TALLER -->
    </div>

    <section id="seccionMostrarCaracteristicas" class="vehicle-details">
        @if (is_object($taller))
            <h2>{{ $taller->nombre_de_taller }}</h2>
            <div class="divContenedorInfo">
                <!-- Calificación -->
                <div class="divInfoPadre">
                    <div id="" class="divIconInfo">
                        <i class="fa-solid fa-star" style="color: #000000;"></i>
                    </div>
                    <p class="textoInfo"><strong>{{ number_format($averageRating, 1) }} </strong>
                        {!! renderStars($averageRating) !!} </p>
                </div>
                <!-- horarios -->
                <div class="divInfoPadreHorarios">
                    <div id="" class="divIconInfoHorarios">
                        <i class="fa-solid fa-clock" style="color: #000000;"></i>
                    </div>
                    <p class="textoInfoHorarios"><strong></strong> {{ $taller->horario }} </p>
                </div>
                <!-- Teléfono -->
                <div class="divInfoPadre">
                    <div id="" class="divIconInfo">
                        <i class="fa-solid fa-phone" style="color: #000000;"></i>
                    </div>
                    <p class="textoInfo"><strong> </strong>{{ $taller->telefono }}</p>
                </div>
                <!-- Correo electrónico -->
                <div class="divInfoPadre">
                    <div id="" class="divIconInfo">
                        <i class="fa-solid fa-envelope" style="color: #000000;"></i>
                    </div>
                    <p class="textoInfo"><strong></strong>{{ $taller->correo_electronico }} </p>
                </div>
                <!-- Coche de cortesía -->
                <div class="divInfoPadre">
                    <div id="" class="divIconInfo">
                        <i class="fa-solid fa-car" style="color: #000000;"></i>
                    </div>
                    <p class="textoInfo"><strong>Coche de cortesía: </strong>
                        {{ $taller->coche_de_cortesia ? '✔️ Sí' : '❌ No' }}</p>
                </div>
                <!-- Cafetería -->
                <div class="divInfoPadre">
                    <div id="" class="divIconInfo">
                        <i class="fa-solid fa-mug-hot" style="color: #000000;"></i>
                    </div>
                    <p class="textoInfo"><strong>Cafetería: </strong> {{ $taller->cafeteria ? '✔️ Sí' : '❌ No' }}</p>
                </div>
                <!-- Especialidad -->
                <div class="divInfoPadre">
                    <div id="" class="divIconInfo">
                        <i class="fa-solid fa-wrench" style="color: #000000;"></i>
                    </div>
                    <p class="textoInfo"><strong>Especialidad: </strong>{{ $taller->especialidad }} </p>
                </div>
                <!-- wc clientes -->
                <div class="divInfoPadre">
                    <div id="" class="divIconInfo">
                        <i class="fa-solid fa-toilet" style="color: #000000;"></i>
                    </div>
                    <p class="textoInfo"><strong>Wc clientes:</strong> {{ $taller->wc ? '✔️ Sí' : '❌ No' }}</p>
                </div>
                <!-- Número de mecánicos -->
                <div class="divInfoPadre">
                    <div id="" class="divIconInfo">
                        <i class="fa-solid fa-users" style="color: #050505;"></i>
                    </div>
                    <p class="textoInfo">Número de mecánicos:<strong> {{ $taller->num_mecanicos }}</strong></p>
                </div>
                <!-- Elevadores -->
                <div class="divInfoPadre">
                    <div id="" class="divIconInfo">
                        <i class="fa-solid fa-elevator" style="color: #000000;"></i>
                    </div>
                    <p class="textoInfo"><strong>Elevadores</strong> {{ $taller->elevadores }} </p>
                </div>
                <!-- ubicación -->
                <div class="divInfoPadreHorarios">
                    <div id="" class="divIconInfoHorarios">
                        <i class="fa-solid fa-location-dot" style="color: #000000;"></i>
                    </div>
                    <!-- //falta añadir la calle desde la BD -->
                    <p class="textoInfoHorarios"><strong> </strong>{{ $taller->ubicacionTaller }}, Carrer d'Astorga,
                        38, nave 4 </p>
                </div>
                <!-- Suscripción al taller -->
                <div class="divInfoPadre">
                    @if (Auth::check() && Auth::user()->id !== $taller->user_id)
                        @if (Auth::user()->subscriptoresTalleres()->where('taller_id', $taller->id)->exists())
                            <form action="{{ route('taller.unsubscribe', $taller->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Desuscribirse</button>
                            </form>
                        @else
                            <form action="{{ route('taller.subscribe', $taller->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Suscribirse</button>
                            </form>
                        @endif
                    @endif
                </div>

            </div>
            </div>
            <!-- ***********///////////FORMULARIO DE EDICIÓN DE TALLER -->
            @if (auth()->user() && auth()->user()->id == $taller->user_id)
                <div class="card-body" id="editForm" style="display:none;">
                    <form action="{{ route('taller.update', $taller->id) }}" method="post" class="container mt-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $taller->id }}">
                        <h3 class="totleFormEditTaller mb-4">Formulario de Edición de Taller</h3>
                        <div class="form-group mb-4">
                            <label for="nombre_de_taller" class="form-label">Nombre del Taller</label>
                            <input type="text" class="form-control" id="nombre_de_taller" name="nombre_de_taller"
                                value="{{ $taller->nombre_de_taller }}" required maxlength="30">
                        </div>
                        <div class="form-group mb-4">
                            <label for="city" class="form-label">Ciudad donde está ubicado el taller</label>
                            <select name="city" id="city" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="street" class="form-label">Calle donde está ubicado el taller</label>
                            <input type="text" id="street" name="street" class="form-control"
                                value="{{ $taller->street }}">
                        </div>
                        <div class="form-group mb-4">
                            <label for="postalCode" class="form-label">Código Postal</label>
                            <input type="text" id="postalCode" name="postalCode" class="form-control"
                                value="{{ $taller->postalCode }}">
                        </div>
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="cafeteria" name="cafeteria"
                                {{ $taller->cafeteria ? 'checked' : '' }}>
                            <label class="form-check-label" for="cafeteria">¿Lugar de espera para los
                                clientes?</label>
                        </div>
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="wc" name="wc"
                                {{ $taller->wc ? 'checked' : '' }}>
                            <label class="form-check-label" for="wc">¿Baño para los clientes?</label>
                        </div>
                        <div class="form-group mb-4">
                            <label for="elevadores" class="form-label">Número de elevadores</label>
                            <input type="number" class="form-control" id="elevadores" name="elevadores"
                                value="{{ $taller->elevadores }}" required min="1" max="10">
                        </div>
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="coche_de_cortesia"
                                name="coche_de_cortesia" {{ $taller->coche_de_cortesia ? 'checked' : '' }}>
                            <label class="form-check-label" for="coche_de_cortesia">¿Coche de cortesía?</label>
                        </div>
                        <div class="form-group mb-4">
                            <label for="num_mecanicos" class="form-label">Número de mecánicos</label>
                            <input type="number" class="form-control" id="num_mecanicos" name="num_mecanicos"
                                value="{{ $taller->num_mecanicos }}" required min="1" max="50">
                        </div>
                        <div class="form-group mb-4">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <select name="especialidad" id="especialidad" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                value="{{ $taller->telefono }}" required maxlength="17">
                        </div>
                        <div class="form-group mb-4">
                            <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo_electronico"
                                name="correo_electronico" value="{{ $taller->correo_electronico }}" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="horario" class="form-label">Horario</label>
                            <div id="dias">
                                <!-- Lunes -->
                                <div class="mb-2">
                                    <label for="lunes" class="form-label">Lunes</label>
                                    <select name="lunes" id="lunes" class="form-control">
                                        <option value="cerrado">Cerrado</option>
                                        <option value="abierto">Abierto</option>
                                    </select>
                                    <div id="horariosLunes" style="display: none;">
                                        <select name="lunes_apertura" class="form-control my-1">
                                            <option value="">Apertura</option>
                                        </select>
                                        <select name="lunes_cierre_mediodia" class="form-control my-1">
                                            <option value="">Cierre medio día</option>
                                        </select>
                                        <select name="lunes_apertura_mediodia" class="form-control my-1">
                                            <option value="">Apertura medio día</option>
                                        </select>
                                        <select name="lunes_cierre" class="form-control my-1">
                                            <option value="">Cierre</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Martes -->
                                <div class="mb-2">
                                    <label for="martes" class="form-label">Martes</label>
                                    <select name="martes" id="martes" class="form-control">
                                        <option value="cerrado">Cerrado</option>
                                        <option value="abierto">Abierto</option>
                                    </select>
                                    <div id="horariosMartes" style="display: none;">
                                        <select name="martes_apertura" class="form-control my-1">
                                            <option value="">Apertura</option>
                                        </select>
                                        <select name="martes_cierre_mediodia" class="form-control my-1">
                                            <option value="">Cierre medio día</option>
                                        </select>
                                        <select name="martes_apertura_mediodia" class="form-control my-1">
                                            <option value="">Apertura medio día</option>
                                        </select>
                                        <select name="martes_cierre" class="form-control my-1">
                                            <option value="">Cierre</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Miércoles -->
                                <div class="mb-2">
                                    <label for="miercoles" class="form-label">Miércoles</label>
                                    <select name="miercoles" id="miercoles" class="form-control">
                                        <option value="cerrado">Cerrado</option>
                                        <option value="abierto">Abierto</option>
                                    </select>
                                    <div id="horariosMiercoles" style="display: none;">
                                        <select name="miercoles_apertura" class="form-control my-1">
                                            <option value="">Apertura</option>
                                        </select>
                                        <select name="miercoles_cierre_mediodia" class="form-control my-1">
                                            <option value="">Cierre medio día</option>
                                        </select>
                                        <select name="miercoles_apertura_mediodia" class="form-control my-1">
                                            <option value="">Apertura medio día</option>
                                        </select>
                                        <select name="miercoles_cierre" class="form-control my-1">
                                            <option value="">Cierre</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Jueves -->
                                <div class="mb-2">
                                    <label for="jueves" class="form-label">Jueves</label>
                                    <select name="jueves" id="jueves" class="form-control">
                                        <option value="cerrado">Cerrado</option>
                                        <option value="abierto">Abierto</option>
                                    </select>
                                    <div id="horariosJueves" style="display: none;">
                                        <select name="jueves_apertura" class="form-control my-1">
                                            <option value="">Apertura</option>
                                        </select>
                                        <select name="jueves_cierre_mediodia" class="form-control my-1">
                                            <option value="">Cierre medio día</option>
                                        </select>
                                        <select name="jueves_apertura_mediodia" class="form-control my-1">
                                            <option value="">Apertura medio día</option>
                                        </select>
                                        <select name="jueves_cierre" class="form-control my-1">
                                            <option value="">Cierre</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Viernes -->
                                <div class="mb-2">
                                    <label for="viernes" class="form-label">Viernes</label>
                                    <select name="viernes" id="viernes" class="form-control">
                                        <option value="cerrado">Cerrado</option>
                                        <option value="abierto">Abierto</option>
                                    </select>
                                    <div id="horariosViernes" style="display: none;">
                                        <select name="viernes_apertura" class="form-control my-1">
                                            <option value="">Apertura</option>
                                        </select>
                                        <select name="viernes_cierre_mediodia" class="form-control my-1">
                                            <option value="">Cierre medio día</option>
                                        </select>
                                        <select name="viernes_apertura_mediodia" class="form-control my-1">
                                            <option value="">Apertura medio día</option>
                                        </select>
                                        <select name="viernes_cierre" class="form-control my-1">
                                            <option value="">Cierre</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Sábado -->
                                <div class="mb-2">
                                    <label for="sabado" class="form-label">Sábado</label>
                                    <select name="sabado" id="sabado" class="form-control">
                                        <option value="cerrado">Cerrado</option>
                                        <option value="abierto">Abierto</option>
                                    </select>
                                    <div id="horariosSabado" style="display: none;">
                                        <select name="sabado_apertura" class="form-control my-1">
                                            <option value="">Apertura</option>
                                        </select>
                                        <select name="sabado_cierre_mediodia" class="form-control my-1">
                                            <option value="">Cierre medio día</option>
                                        </select>
                                        <select name="sabado_apertura_mediodia" class="form-control my-1">
                                            <option value="">Apertura medio día</option>
                                        </select>
                                        <select name="sabado_cierre" class="form-control my-1">
                                            <option value="">Cierre</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Domingo -->
                                <div class="mb-2">
                                    <label for="domingo" class="form-label">Domingo</label>
                                    <select name="domingo" id="domingo" class="form-control">
                                        <option value="cerrado">Cerrado</option>
                                        <option value="abierto">Abierto</option>
                                    </select>
                                    <div id="horariosDomingo" style="display: none;">
                                        <select name="domingo_apertura" class="form-control my-1">
                                            <option value="">Apertura</option>
                                        </select>
                                        <select name="domingo_cierre_mediodia" class="form-control my-1">
                                            <option value="">Cierre medio día</option>
                                        </select>
                                        <select name="domingo_apertura_mediodia" class="form-control my-1">
                                            <option value="">Apertura medio día</option>
                                        </select>
                                        <select name="domingo_cierre" class="form-control my-1">
                                            <option value="">Cierre</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="text" id="horario" name="horario" style="display: none;">
                            </div>
                        </div>
                        <div class="divBotonFormVehiculo">
                            <button type="submit" class="botonFormTopoVehiculo" style="background-color: red">Guardar cambios</button>
                        </div>
                    </form>
                </div>
                <div class="divBotonFormVehiculo">
                    <button class="botonFormTopoVehiculo" onclick="toggleEditForm()">Editar detalles</button>
                </div>

                @if (auth()->user() && auth()->user()->id == $taller->user_id)
                    <button class="btn btn-primary"><a
                            href="{{ route('taller.subscriptorsListTaller', ['id' => $taller->id]) }}"
                            style="color: rgb(255, 255, 255); text-decoration: none; ba" >Ver Suscriptores</a></button>
                @endif
            @else
                <p style="color: white"></p>
            @endif
            </div>
        @else
            <p class="error-message">Error: La información del taller no está disponible. Por favor, asegúrate de que
                el taller está registrado y vuelve a intentarlo.</p>
        @endif
    </section>

    <!-- SECCION OFERTAS -->
    <div class="main-wrapper">
        <div class="divOfertas">
            <div class="ofertasContainer">
                <h2>Ofertas</h2>
                @if ($taller->ofertas && $taller->imagen_oferta)
                    <div class="ofertaDisplay">
                        <h3>{{ $taller->ofertas }}</h3>
                        <div class="imgContainer">
                            <img src="{{ Storage::url($taller->imagen_oferta) }}" alt="Imagen de la oferta">
                            @if (auth()->user() && auth()->user()->id == $taller->user_id)
                                <button onclick="showForm()" class="btnEditar">Editar Oferta</button>
                            @endif
                        </div>
                    </div>
                @endif

                @if (auth()->user() && auth()->user()->id == $taller->user_id)
                    <div class="ofertaForm"
                        style="{{ $taller->ofertas && $taller->imagen_oferta ? 'display: none;' : '' }}">
                        <form method="POST" action="{{ route('taller.update.ofertas') }}"
                            enctype="multipart/form-data" class="formOfertas">
                            @csrf
                            <label for="ofertaTitulo">Título de la Oferta:</label>
                            <input type="text" id="ofertaTitulo" name="ofertas"
                                placeholder="Describe la oferta aquí..." value="{{ $taller->ofertas ?? '' }}"
                                class="inputOferta" maxlength="40">
                            <label for="ofertaImagen">Imagen de la Oferta:</label>
                            <input type="file" id="ofertaImagen" name="imagen_oferta" accept="image/*"
                                class="inputFile">
                            <button type="submit" class="btnGuardar">Guardar Ofertas</button>
                        </form>
                        <div class="imagePreview">
                            @if ($taller->imagen_oferta)
                                <img src="{{ Storage::url($taller->imagen_oferta) }}"
                                    alt="Imagen de la oferta cargada">
                            @else
                                <p>No hay imagen disponible</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        function showForm() {
            document.querySelector('.ofertaForm').style.display = 'block';
            document.querySelector('.ofertaDisplay').style.display = 'none';
        }
    </script>

    <!-- SECCIÓN CARRUSEL DE IMÁGENES -->
    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @forelse ($imagenesCarrusel as $key => $imagen)
                <li data-target="#imageCarousel" data-slide-to="{{ $key }}"
                    class="{{ $key == 0 ? 'active' : '' }}"></li>
            @empty
                <li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
            @endforelse
        </ol>

        <div class="carousel-inner">
            @forelse ($imagenesCarrusel as $key => $imagen)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $imagen->ruta) }}" class="d-block w-100"
                        alt="Imagen {{ $key + 1 }}">
                    @if (auth()->check() && auth()->user()->id == $taller->user_id)
                        <form action="{{ route('taller.deleteCarruselImage', $imagen->id) }}" method="POST"
                            class="delete-form"
                            style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); z-index: 9999;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-btn"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta imagen?')">Eliminar</button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="carousel-item active">
                    <img src="{{ asset('images/fotoCarruselRandom.jpg') }}" class="d-block w-100"
                        alt="Imagen Predeterminada">
                </div>
            @endforelse
        </div>

        <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </div>

    @if (auth()->check() && auth()->user()->id == $taller->user_id)
        <form action="{{ route('taller.storeCarruselImage', $taller->id) }}" method="POST"
            enctype="multipart/form-data" class="upload-form">
            @csrf
            <label for="imagen">Subir imagen para el carrusel:</label>
            <input type="file" name="imagen" required>
            <button type="submit">Subir</button>
        </form>
    @endif

    <!-- SECCIÓN COMENTARIOS -->
    @if (auth()->check() && auth()->user()->id != $taller->user_id)
        <div class="DivComentarios">
            <h2>Dejar un Comentario</h2>
            <form action="{{ route('talleres.storeComment', $taller->id) }}" method="POST">
                @csrf
                <textarea name="contenido" required placeholder="Escribe tu comentario aquí..."></textarea>
                <button type="submit">Enviar Comentario</button>
            </form>
        </div>
        <!-- SECCION CLASIFICAR POR ESTRELLAS -->
        <div class="rating-form">
            <h2>Califica este taller</h2>
            <form action="{{ route('ratings.store', $taller->id) }}" method="POST" id="ratingForm">
                @csrf
                <div class="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingInput">
                <button class="buttonEstrellas" type="submit">Enviar</button>
            </form>
        </div>
    @endif

    <div class="DivComentarios">
        <h2>Comentarios</h2>
        @forelse ($taller->comentarios as $comentario)
            <div class="comentario">
                <div class="user-info">
                    <strong>{{ $comentario->user->name }}</strong> dijo:
                </div>
                <div class="contenido-comentario">
                    {{ $comentario->contenido }}
                </div>
                <div class="fecha-comentario">
                    {{ $comentario->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
        @empty
            <p>No hay comentarios aún.</p>
        @endforelse
    </div>

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
        function toggleEditForm() {
            var form = document.getElementById('editForm');
            form.style.display = (form.style.display === 'none') ? 'block' : 'none';
        }

        function toggleForm() {
            var formContainer = document.getElementById('location-form-container');
            formContainer.style.display = (formContainer.style.display === 'none') ? 'block' : 'none';
        }

        function initMap() {
            var initialLat = {{ $taller->location->latitude ?? 41.14961 }};
            var initialLng = {{ $taller->location->longitude ?? 1.10553 }};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: {
                    lat: initialLat,
                    lng: initialLng
                }
            });

            var marker = new google.maps.Marker({
                position: {
                    lat: initialLat,
                    lng: initialLng
                },
                map: map,
                title: 'Ubicación del Taller'
            });

            var geocoder = new google.maps.Geocoder();

            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                map.panTo(event.latLng);
                document.getElementById('latitude-input').value = event.latLng.lat();
                document.getElementById('longitude-input').value = event.latLng.lng();
                geocodeLatLng(geocoder, event.latLng);
            });
        }

        function geocodeLatLng(geocoder, latLng) {
            geocoder.geocode({
                'location': latLng
            }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        var addressComponents = results[0].address_components;
                        var street = '';
                        var city = '';
                        var postalCode = '';

                        addressComponents.forEach(component => {
                            var types = component.types;
                            if (types.includes('route') || types.includes('street_address')) {
                                street = component.long_name;
                            }
                            if (types.includes('locality')) {
                                city = component.long_name;
                            }
                            if (types.includes('postal_code')) {
                                postalCode = component.long_name;
                            }
                        });

                        document.getElementById('street-input').value = street;
                        document.getElementById('city-input').value = city;
                        document.getElementById('postal-code-input').value = postalCode;
                    } else {
                        alert('No results found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('ratingInput');
            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const value = star.getAttribute('data-value');
                    ratingInput.value = value;
                    stars.forEach(s => {
                        s.classList.toggle('selected', s.getAttribute('data-value') <=
                            value);
                    });
                });
            });
        });
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
    <script>
        function toggleNotifications() {
            var notificationMenu = document.querySelector('.notification-menu');
            notificationMenu.style.display = notificationMenu.style.display === 'none' || notificationMenu.style.display ===
                '' ? 'block' : 'none';
        }
    </script>
</body>

</html>
