<!DOCTYPE html>
<html lang="en">
<script src="https://cdn.tailwindcss.com"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap JS (para el carrusel) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Mi sección</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- CDN iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite (['resources/css/miSeccion.css' , 'resources/css/headerNav.css', 'resources/css/estilosCarruselImg.css'
    ,'resources/js/jsMiSeccion.js'])

       <script>
//    function toggleNotifications() {
//     var notifications = document.getElementById('notifications');
//     if (notifications.style.display === 'none' || notifications.style.display === '') {
//         notifications.style.display = 'block';
//     } else {
//         notifications.style.display = 'none';
//     }
//}
    </script>
</head>

<body>
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
                <a href="{{ url('/mitaller') }}" class="miSeccion">
                    <i class="fa-solid fa-screwdriver-wrench" style="color: #ffffff;"></i>
                    <p>Mi taller</p>
                </a>
            </div>
        @else
            <div>
                <a href="{{ route('login') }}" class="login">
                    <i class="fa-regular fa-user"></i>
                    <p>Entrar</p>
                </a>
            </div>
            @if (Route::has('register'))
                <div>
                    <a href="{{ route('register') }}" class="register ml-4">
                        <i class="fa-regular fa-user"></i>
                        <p>Registrarse</p>
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
            <img src="{{ asset('images/userRandom.png') }}" alt="Logo usuario sin foto">
        @endauth
    </div>
 
</header>
<!-- ********************notificacion  -->
@if (auth()->check())
        <div class="notification-container">
            <i class="fa-solid fa-bell notification-icon" style="color: #ffffff;" onclick="toggleNotifications()"></i>
            <div class="notifications" id="notifications">
                <div class="notification-header">
                    <h2>Notificaciones</h2>
                    <span class="close-btn" onclick="toggleNotifications()">&times;</span>
                </div>
                @php
                    $unreadNotifications = auth()->user()->notifications()->where('read', false)->get();
                @endphp
                @if ($unreadNotifications->isEmpty())
                    <p>No tienes nuevas notificaciones.</p>
                @else
                    <ul>
                        @foreach ($unreadNotifications as $notification)
                            <li class="notification-item">
                                @if ($notification->follower && $notification->taller)
                                    <p>{{ $notification->follower->name }} te ha enviado un mensaje en el taller {{ $notification->taller->nombre_de_taller }}.</p>
                                @elseif ($notification->follower)
                                    <p>{{ $notification->follower->name }} te ha enviado un mensaje.</p>
                                @elseif ($notification->taller)
                                    <p>Notificación del taller {{ $notification->taller->nombre_de_taller }}: {{ $notification->message }}</p>
                                @else
                                    <p>{{ $notification->message }}</p>
                                @endif
                                <!-- Marcar como leído -->
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-primary">Marcar como leído</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-primary mt-2">Ver todas las notificaciones</a>
            </div>
        </div>
    @endif

<!-- *************************fORMULARIO VEHÍCULO  ******************* -->
@if (auth()->user()->tipo_vehiculo !== 'Coche' && auth()->user()->tipo_vehiculo !== 'Moto')
    <section id="sectionFormUsers" class="sectionFormUsers">
        <form action="{{ route('miSeccion.vehicleCreate') }}" method="POST" id="idFormCreateVehicle">
            @csrf
            <label for="tipo_vehiculo">Información de su vehiculo</label>
            <div class="divPAdreIconosVehicle" style="display: flex;">
                <!-- Contenedor para los íconos de los vehículos -->

                @if (auth()->check() && auth()->user()->id == $user->id)
                    <div id="divIconoCoche" class="divIconosVehiculo" data-value="Coche" style="display: flex;">
                        <i class="fa-solid fa-car"></i>
                        <span class="spanLabel" id="sapnVehiculos">Coche</span>
                    </div>
                @else
                    <div id="divIconoCoche" class="divIconosVehiculo" data-value="Coche" style="display: none;">
                        <i class="fa-solid fa-car"></i>
                        <span class="spanLabel" id="sapnVehiculos">Coche</span>
                    </div>
                @endif
                <!-- <div id="divIconoMoto" class="divIconosVehiculo" data-value="Moto" style="display: flex;">
                <i class="fa-solid fa-motorcycle"></i>
                <span class="spanLabel" id="sapnVehiculos">Moto</span>
            </div> -->
            </div>
            <!-- Campo Año fabricación -->
            <div class="divPadreLabelIconoInput" id="divAñoFabricacion" style="display: none;">
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Año de fabricación</span></label>
                </div>
                <div class="divIcons" id="divInputAno">
                    <i class="fa-regular fa-calendar-days"></i>
                    <input type="number" name="anoFabricacion" id="inputAnoFabricacion" min="1900"
                        max="2024" value="">
                </div>
            </div>
            <!-- Campo Marca  -->
            <div class="divPadreLabelIconoInput" id="idCreateMarca" style="display: none;">
                <div class="divTextoLabel">
                    <label class=""><span class="spanLabel">Marca de tu vehículo</span></label>
                </div>
                <div class="divIcons" id="divSelectMarca">
                    <select id="selectMarca" name="marca" class="selectMarca">
                        <!-- Añado los option desde el js -->
                    </select>
                </div>
            </div>
            <!--Campo modelo-->
            <div class="divPadreLabelIconoInput" id="idCreateModel" style="display: none;">
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Modelo de tu vehículo</span></label>
                </div>
                <!-- <div id="divTextAreaModelo" class="divIcons"> -->
                <div id="divSelectModelo" class="divIcons">
                    <select id="selectModelo" name="modelo" class="selectModelo">
                        <!-- <textarea name="modelo" id="modelo" cols="30" rows="3" placeholder="Modelo de tu vehículo..."></textarea> -->

                        <option value="">Modelo de tu vehículo</option>
                    </select>
                </div>
            </div>
            <!--Campo Km-->
            <div class="divPadreLabelIconoInput" id="idCreateKm" style="display: none;">
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Km actuales</span></label>
                </div>
                <div class="divIcons" id="divInputKmCreate">
                    <i class="fa-solid fa-road" style="color: #000000;"></i>
                    <input type="number" name="km" id="km" min="0" max="2000000"
                        value="" placeholder="50000km">
                </div>
            </div>
            <!-- Cilindrada -->
            <div class="divPadreLabelIconoInput" id="idCreateCC" style="display: none;">
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Cilindrada motor</span></label>
                </div>
                <div class="divIcons" id="divInputCC">
                    <i class="fa-solid fa-gopuram" style="color: #000000;"></i>
                    <input type="number" name="cc" id="cc" min="49" max="10000"
                        value="" placeholder="1900">
                </div>
            </div>
            <!--Potencia caballos cv-->
            <div class="divPadreLabelIconoInput" id="idCreateCV" style="display: none;">
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Caballos</span></label>
                </div>
                <div class="divIcons" id="divInputCV">
                    <i class="fa-solid fa-horse" style="color: #000000;"></i>
                    <input type="number" name="cv" id="cv" min="1" max="1500"
                        value="" placeholder="135cv">
                </div>
            </div>
            <!-- ITV -->
            <div class="divPadreLabelIconoInput" id="divCreateITV" style="display: none;">
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Fecha proxima ITV</span></label>
                </div>
                <div class="divIcons" id="divInputITV">
                    <i class="fa-solid fa-hand-point-up" style="color: #000000;"></i>
                    <input type="date" name="fechaITV" id="inputITV" min="2024-01-01" max="2039-12-31"
                        value="">
                </div>
            </div>
            <!-- Fecha ultima revision -->
            <div class="divPadreLabelIconoInput" id="divCreateRevision" style="display: none;">
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Fecha Ultima revisión</span></label>
                </div>
                <div class="divIcons" id="divInputRevision">
                    <i class="fa-solid fa-magnifying-glass fa-flip-horizontal" style="color: #000000;"></i>
                    <input type="date" name="fechaUltimaRevision" id="inputRevision" min="2020-01-01"
                        max="2039-12-31" value="">
                </div>
            </div>
            <!-- Nombre taller donde lo llevaste -->
            <!-- <div class="divPadreLabelIconoInput" id="divCreateNomTaller" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Nombre taller donde lo llevaste</span></label>
            </div>
            <div class="divIcons" id="divInputNomTaller">
                <i class="fa-solid fa-warehouse" style="color: #000000;"></i>
                <input type="text" name="nomTaller" id="nomTaller" placeholder="Nombre del taller">
            </div>
        </div> -->
            <!-- Ciudad esidencia user -->
            <div class="divPadreLabelIconoInput" id="divCreateResidenciaUser" style="display: none;">
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Ciudad de residencia</span></label>
                </div>
                <div class="divIcons" id="divInputNomTaller">
                    <i class="fa-solid fa-house-user" style="color: #000000;"></i>
                    <input type="text" name="residenciaUser" id="residenciaUser" placeholder="Leon">
                </div>
            </div>
            <!-- Tipo de combustible -->
            <div class="divPadreLabelIconoInput" id="idCreateCombustible" style="display: none;">
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Tipo de combustible</span></label>
                </div>
                <div class="divIcons" id="divSelectCombustibles">
                    <select id="selectCombustible" name="tipo_combustible" class="selectMarca">
                        <!-- añado el option desde el js -->
                    </select>
                </div>
            </div>

            <input type="hidden" name="tipo_vehiculo" id="tipo_vehiculo">
            <div class="divBotonFormVehiculo">
                <button class="botonFormTopoVehiculo" type="submit" style="display: none;">Añadir</button>
            </div>
        </form>
    </section>
@endif
<!-- **************************MOSTRAR FECHAS IMPORTANTES ************************************ -->
<section class="sectionFechas">

    <!-- Fecha ITV -->
    <div class="reminder-item">
        <div class="logo">
            <i class="fa-solid fa-hand-point-up"></i>
        </div>
        <div class="details">
            <div class="textEvent">
                <p>Fecha próxima ITV:</p>
            </div>
            @if (auth()->user()->fechaITV)
                <div class="date">{{ auth()->user()->fechaITV->format('d-m-Y') }}</div>
            @else
                <div class="date">Fecha no definida</div>
            @endif
            <div class="textEvent">
                <p>Tiempo restante</p>
            </div>
            <div id="divProximaItv" class="time-remaining green"
                data-fecha-itv="{{ auth()->user()->fechaITV }}"></div>
        </div>
    </div>
    <!-- revisión -->
    <div class="reminder-item">
        <div class="logo">
            <i class="fa-solid fa-car-on" style="color: #000000;"></i>
        </div>
        <div class="details">
            <div class="textEvent">
                <p>Fecha próxima revisión</p>
            </div>
            @if (auth()->user()->fechaUltimaRevision)
                <div class="date"> {{ auth()->user()->fechaUltimaRevision->format('d-m-Y') }}</div>
            @else
                <div class="date">Fecha no definida</div>
            @endif
            <div class="textEvent">
                <p>Tiempo restante</p>
            </div>
            <div id="divProximaRevision" class="time-remaining green"
                data-fecha-revision="{{ auth()->user()->fechaUltimaRevision }}"></div>
        </div>
    </div>
    <!-- Campo 3 -->
    <div class="reminder-item">
        <div class="logo">
            <i class="fa-solid fa-hand-point-up"></i>
        </div>
        <div class="details">
            <div class="textEvent">
                <p>Fecha próxima...:</p>
            </div>
            <div class="date"> 22-10-2025</div>
            <div class="textEvent">
                <p>Tiempo restante proxima...:</p>
            </div>
            <div class="time-remaining green">1 años, 4 meses, y 26 días</div>
        </div>
    </div>

</section>
<!-- *************************FORMULARIO EDITAR CARACTERISTICAS VEHICULO ******************* -->

<section id="sectionFormUsers" class="sectionFormUsers" style="display:none;">
    <form action="{{ route('miSeccion.updateVehicle') }}" method="POST" id="idFormUpdateVehicle">
        @csrf
        @method('PUT') <!-- Usando método PUT para actualizar -->
        <label for="tipo_vehiculo">Modificar formulario del vehiculo</label>
        <div class="divPAdreIconosVehicle" style="display: flex;">
            <!-- Contenedor para los íconos de los vehículos -->
            <div id="divIconoCoche" class="divIconosVehiculo" data-value="Coche" style="display: flex;">
                <i class="fa-solid fa-car"></i>
                <span class="spanLabel">Coche</span>
            </div>
            <!-- <div id="divIconoMoto" class="divIconosVehiculo" data-value="Moto" style="display: flex;">
                <i class="fa-solid fa-motorcycle"></i>
                <span class="spanLabel">Moto</span>
            </div> -->
        </div>
        <!-- Campo Año fabricación -->
        <div class="divPadreLabelIconoInput" id="divAñoFabricacion" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Año de fabricación</span></label>
            </div>
            <div class="divIcons" id="divInputAno">
                <i class="fa-regular fa-calendar-days"></i>
                <input type="number" name="anoFabricacion" id="inputAnoFabricacion" min="1900"
                    max="2024" value="{{ auth()->user()->anoFabricacion }}">
            </div>
        </div>
        <!-- Campo Marca  -->
        <div class="divPadreLabelIconoInput" id="idCreateMarca" style="display: none;">
            <div class="divTextoLabel">
                <label class=""><span class="spanLabel">Marca de tu vehículo</span></label>
            </div>
            <div class="divIcons" id="divSelectMarca">
                <select id="selectMarca" name="marca" class="selectMarca">
                    <!-- Añado los option desde el js -->
                    <option value="{{ auth()->user()->marca }}"></option>
                </select>
            </div>
        </div>
        <!--Campo modelo-->
        <div class="divPadreLabelIconoInput" id="idCreateModel" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Modelo de tu vehículo</span></label>
            </div>
            <div id="divSelectModelo" class="divIcons">
                <select id="selectModelo" name="modelo" class="selectModelo">
                    <!-- <textarea name="modelo" id="modelo" cols="30" rows="3" placeholder="Modelo de tu vehículo...">
                    <p>    { { auth ( ) - > user ( ) -> modelo } }</p>
                </textarea>  -->
                    <option value="">{{ auth()->user()->modelo }}</option>
                </select>
            </div>
        </div>
        <!--Campo Km-->
        <div class="divPadreLabelIconoInput" id="idCreateKm" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Km actuales</span></label>
            </div>
            <div class="divIcons" id="divInputKmCreate">
                <i class="fa-solid fa-road" style="color: #000000;"></i>
                <input type="number" name="km" id="km" min="0" max="2000000"
                    value="{{ auth()->user()->km }}" placeholder="50000km">
            </div>
        </div>
        <!-- Cilindrada -->
        <div class="divPadreLabelIconoInput" id="idCreateCC" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Cilindrada motor</span></label>
            </div>
            <div class="divIcons" id="divInputCC">
                <i class="fa-solid fa-gopuram" style="color: #000000;"></i>
                <input type="number" name="cc" id="cc" min="49" max="10000"
                    value="{{ auth()->user()->cc }}" placeholder="1900">
            </div>
        </div>
        <!--Potencia caballos cv-->
        <div class="divPadreLabelIconoInput" id="idCreateCV" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Caballos</span></label>
            </div>
            <div class="divIcons" id="divInputCV">
                <i class="fa-solid fa-horse" style="color: #000000;"></i>
                <input type="number" name="cv" id="cv" min="1" max="1500"
                    value="{{ auth()->user()->cv }}" placeholder="135cv">
            </div>
        </div>
        <!-- ITV -->
        <div class="divPadreLabelIconoInput" id="divCreateITV" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Nueva fecha de ITV</span></label>
            </div>
            <div class="divIcons" id="divInputITV">
                <i class="fa-solid fa-hand-point-up" style="color: #000000;"></i>
                <input type="date" name="fechaITV" id="inputITV" min="2024-01-01" max="2039-12-31"
                    value="{{ auth()->user()->fechaITV ? auth()->user()->fechaITV->format('Y-m-d') : '' }}">
            </div>
        </div>
        <!-- Fecha ultima revision -->
        <div class="divPadreLabelIconoInput" id="divCreateRevision" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Fecha proxima revisión</span></label>
            </div>
            <div class="divIcons" id="divInputRevision">
                <i class="fa-solid fa-magnifying-glass fa-flip-horizontal" style="color: #000000;"></i>
                <input type="date" name="fechaUltimaRevision" id="inputRevision" min="2020-01-01"
                    max="2039-12-31"
                    value="{{ auth()->user()->fechaUltimaRevision ? auth()->user()->fechaUltimaRevision->format('Y-m-d') : '' }}">
            </div>
        </div>
        <!-- Nombre taller donde lo llevaste -->
        <!-- <div class="divPadreLabelIconoInput" id="divCreateNomTaller" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Nombre taller donde lo llevaste</span></label>
            </div>
            <div class="divIcons" id="divInputNomTaller">
                <i class="fa-solid fa-warehouse" style="color: #000000;"></i>
                <input type="text" name="nomTaller" id="nomTaller" value="{{ auth()->user()->nomTaller }}"
                    placeholder="">
            </div>
        </div> -->
        <!-- Ciudad residencia user -->
        <div class="divPadreLabelIconoInput" id="divCreateResidenciaUser" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Ciudad de residencia</span></label>
            </div>
            <div class="divIcons" id="divInputNomTaller">
                <i class="fa-solid fa-house-user" style="color: #000000;"></i>
                <input type="text" name="residenciaUser" id="residenciaUser"
                    value="{{ auth()->user()->residenciaUser }}">
            </div>
        </div>

        <!-- Tipo de combustible -->
        <div class="divPadreLabelIconoInput" id="idCreateCombustible" style="display: none;">
            <div class="divTextoLabel">
                <label><span class="spanLabel">Tipo de combustible</span></label>
            </div>
            <div class="divIcons" id="divSelectCombustibles">
                <select id="selectCombustible" name="tipo_combustible" class="selectMarca">
                    <!-- añado el option desde el js -->
                    <option value="{{ auth()->user()->tipo_combustible }}"></option>
                </select>
            </div>
        </div>
        <!-- Campo oculto para almacenar el valor seleccionado -->
        <input type="hidden" name="tipo_vehiculo" id="tipo_vehiculo">
        <!-- Campo oculto para almacenar el tipo de combustible -->
        <!-- <input type="hidden" name="tipo_combustible" id="tipo_combustible" value=""> -->
        <div class="divBotonFormVehiculo">
            <button class="botonFormTopoVehiculo" type="submit" style="display: none;">Actualizar</button>
        </div>
    </form>
</section>
<!--***************************MOSTRAR CARACTERISTICAS VEHICULO  -->
<!-- si no hya nada en la bd no muestra nada -->
@if (auth()->user()->tipo_vehiculo)
    <section id="seccionMostrarCaracteristicas" class="vehicle-details">
        <h2>Características del vehículo</h2>
        <div class="divContenedorInfo">
            <div class="divInfoVehiculo">

                <div class="divIconoVehiculoInfo">
                    @if (auth()->user()->tipo_vehiculo == 'Coche')
                        <i class="fa-solid fa-car"></i>
                    @elseif(auth()->user()->tipo_vehiculo == 'Moto')
                        <i class="fa-solid fa-motorcycle"></i>
                    @endif
                </div>
                <p class="tipoVehiculoTexto"><strong>Tipo de vehículo:</strong>
                    {{ auth()->user()->tipo_vehiculo }}
                </p>
            </div>
            <!-- Mostrar marca -->
            <div class="divInfoPadre">
                <div id="" class="divIconInfo">
                    <i class="fa-regular fa-bookmark" style="color: #000000;"></i>
                </div>
                <p class="textoInfo"><strong>Marca:</strong> {{ auth()->user()->marca }}</p>
            </div>
            <!-- Modelo -->
            <div class="divInfoPadre">
                <div id="" class="divIconInfo">
                    <i class="fa-solid fa-rocket" style="color: #000000;"></i>
                </div>
                <p class="textoInfo"><strong>Modelo:</strong> {{ auth()->user()->modelo }}</p>
            </div>
            <!-- Año de fabricación -->
            <div class="divInfoPadre">
                <div id="" class="divIconInfo">
                    <i class="fa-solid fa-hammer" style="color: #000000;"></i>
                </div>
                <p class="textoInfo"><strong>Año fabricación:</strong> {{ auth()->user()->anoFabricacion }}</p>
            </div>
            <!-- km -->
            <div class="divInfoPadre">
                <div id="" class="divIconInfo">
                    <i class="fa-solid fa-road" style="color: #000000;"></i>
                </div>
                <p class="textoInfo"><strong>Km actuales:</strong> {{ auth()->user()->km }} Km</p>
            </div>
            <!-- CC -->
            <div class="divInfoPadre">
                <div id="" class="divIconInfo">
                    <i class="fa-solid fa-gopuram" style="color: #000000;"></i>
                </div>
                <p class="textoInfo"><strong>Cubicaje motor:</strong> {{ auth()->user()->cc }} CC</p>
            </div>
            <!-- CV -->
            <div class="divInfoPadre">
                <div id="" class="divIconInfo">
                    <i class="fa-solid fa-horse" style="color: #000000;"></i>
                </div>
                <p class="textoInfo"><strong>Caballos:</strong> {{ auth()->user()->cv }} CV</p>
            </div>

            <!-- Ultima revisión -->
            <div class="divInfoPadre">
                <div id="" class="divIconInfo">
                    <i class="fa-solid fa-magnifying-glass fa-flip-horizontal" style="color: #050505;"></i>
                </div>
                <p class="textoInfo"><strong>Fecha ultima revisión:</strong>
                    {{ auth()->user()->fechaUltimaRevision->format('d-m-Y') }}
                </p>
            </div>
            <!-- Nom taller -->
            <!-- <div class="divInfoPadre">
            <div id="" class="divIconInfo">
                <i class="fa-solid fa-warehouse" style="color: #000000;"></i>
            </div>
            <p class="textoInfo"><strong>Taller que la realizo:</strong> {{ auth()->user()->nomTaller }}</p>
        </div> -->
            <!-- Residencia user -->
            <div class="divInfoPadre">
                <div id="" class="divIconInfo">
                    <i class="fa-solid fa-house-user" style="color: #000000;"></i>
                </div>
                <p class="textoInfo"><strong>Residencia usuario</strong> {{ auth()->user()->residenciaUser }}</p>
            </div>
            <!-- ITV -->
            <div class="divInfoPadre">
                <div id="" class="divIconInfo">
                    <i class="fa-solid fa-hand-point-up" style="color: #000000;"></i>
                </div>
                <p class="textoInfo"><strong>Fecha proxima ITV:</strong>
                    {{ auth()->user()->fechaITV->format('d-m-Y') }}</p>
            </div>
            <!-- Mostrar tipo de combustible -->
            <div class="divInfoPadre">
                <div class="divIconInfo">
                    @if (auth()->user()->tipo_combustible == 'Gasolina' || auth()->user()->tipo_combustible == 'Diesel')
                        <i class="fa-solid fa-gas-pump"></i>
                    @elseif(auth()->user()->tipo_combustible == 'Electrico')
                        <i class="fa-solid fa-plug-circle-bolt"></i>
                    @elseif(auth()->user()->tipo_combustible == 'Hibrido')
                        <i class="fa-solid fa-gas-pump"></i>
                        <i class="fa-solid fa-car-battery"></i>
                    @endif
                </div>
                <p class="textoInfo"><strong>Tipo de combustible:</strong> {{ auth()->user()->tipo_combustible }}
                </p>
            </div>
        </div>
        @if (auth()->check() && auth()->user()->id == $user->id)
            <button id="editarVehiculo" class="botonEditarVehiculo">Editar Vehículo</button>
        @else
            <button style="visibility: hidden;" id="editarVehiculo" class="botonEditarVehiculo">Editar
                Vehículo</button>
        @endif
    </section>
@endif

<!-- ******************Añadir historial de mantenimiento -->
<!-- Si ha rellenado el formulario del vehículo  y si eres el propietario, se muestra-->
@if (auth()->check() && auth()->user()->id == $user->id && $user->tipo_vehiculo)
    <section id="seccionMostrarCaracteristicas" class="vehicle-details">
        <h2>Añadir el historial de mantenimiento de tu vehículo</h2>
        <!-- formulario y su ruta en web.php y el nombre del controlador en miSeccionController -->
        <form action="{{ route('miSeccion.maintenanceCreate') }}" method="POST" id="idFormCreateMaintenance">
            @csrf
            <div class="divPadreLabelIconoInput" id="divCreateNomTaller">
                <!--Preguntar por la fecha de la revisión -->
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Fecha</span></label>
                </div>
                <div class="divIcons" id="divInputRevision">
                    <i class="fa-solid fa-magnifying-glass fa-flip-horizontal" style="color: #000000;"></i>
                    <input type="date" name="fechaMantenimiento" id="inputReparacion" min="2020-01-01"
                        max="2039-12-31">
                </div>
                <!--Preguntar por la nombre del taller que la hizo -->
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Nombre taller</span></label>
                </div>
                <div class="divIcons" id="divInputNomTaller">
                    <i class="fa-solid fa-warehouse" style="color: #000000;"></i>
                    <input type="text" name="nomDeTaller" id="nomTallerMantenimiento"
                        placeholder="Nombre del taller">
                </div>
                <!--Añadir la descripción de lo que se le hizo -->
                <div class="divTextoLabel">
                    <label><span class="spanLabel">Descripción </span></label>
                </div>
                <div id="divTextAreaModelo" class="divIcons">
                    <textarea name="trabajoRealizado" id="modelo" cols="30" rows="6"
                        placeholder="Cambio aceite y filtros"></textarea>
                </div>
            </div>
            <div class="divBotonFormVehiculo">
                <button class="botonFormTopoVehiculo" type="submit">Añadir campo</button>
            </div>
        </form>
    </section>
@endif

<!-- *******************Mostrar el historial de mantenimiento *****************************-->
@if (auth()->user()->tipo_vehiculo)
    <div id="divPadreHistorialMantenimiento" class="container my-4">
        <h2 class="text-center my-3">Historial de mantenimiento</h2>
        @foreach (auth()->user()->maintenances as $maintenance)
            <div class="maintenance-entry card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Fecha:</strong> {{ $maintenance->fechaMantenimiento }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Nombre del taller:</strong> {{ $maintenance->nomDeTaller }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Descripción:</strong> {{ $maintenance->trabajoRealizado }}</p>
                        </div>
                    </div>
                    <!-- Si eres el propietario se muestra si no se oculta  -->
                    @if (auth()->check() && auth()->user()->id == $user->id)
                        <div class="text-right">
                            <button id="botonEditarMantenimiento" class="btn btn-primary mr-2"
                                data-id="{{ $maintenance->id }}">Editar</button>
                            <form action="{{ route('miSeccion.destroyMaintenance', $maintenance->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Eliminar</button>
                            </form>
                        </div>
                    @else
                        <div class="text-right">
                            </form>
                        </div>
                    @endif

                    <!-- ****************Editar mantenimiento ****************-->
                    <div id="editForm{{ $maintenance->id }}" class="editForm mt-3" style="display:none;">

                        <form action="{{ route('miSeccion.maintenanceUpdate') }}" method="POST"
                            class="form-inline">
                            <h2>Modificar historial</h2>
                            @csrf
                            @method('PUT')
                            <div class="divPadreLabelIconoInput">
                                <input type="hidden" name="id" value="{{ $maintenance->id }}">
                                <!--Preguntar por la fecha de la revisión -->
                                <div class="divTextoLabel">
                                    <label><span class="spanLabel">Fecha</span></label>
                                </div>
                                <div class="divIcons" id="divInputRevision">
                                    <i class="fa-solid fa-magnifying-glass fa-flip-horizontal"
                                        style="color: #000000;"></i>
                                    <input type="date" name="fechaMantenimiento"
                                        value="{{ $maintenance->fechaMantenimiento }}" class="form-control mr-2">
                                </div>

                                <!--Preguntar por la nombre del taller que la hizo -->
                                <div class="divTextoLabel">
                                    <label><span class="spanLabel">Nombre taller</span></label>
                                </div>
                                <div class="divIcons" id="divInputNomTaller">
                                    <i class="fa-solid fa-warehouse" style="color: #000000;"></i>
                                    <input type="text" name="nomDeTaller"
                                        value="{{ $maintenance->nomDeTaller }}" class="form-control mr-2">
                                </div>

                                <!--Añadir la descripción de lo que se le hizo -->
                                <div class="divTextoLabel">
                                    <label><span class="spanLabel">Descripción </span></label>
                                </div>
                                <div id="divTextAreaModelo" class="divIcons">
                                    <textarea name="trabajoRealizado" class="form-control mr-2">{{ $maintenance->trabajoRealizado }}</textarea>
                                </div>
                            </div>
                            <button id="botonCambioMantenance" type="submit" class="btn btn-success">Guardar
                                Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Añado el carrusel de fotos -->
<!-- Carrusel de Imágenes -->
{{-- resources\views\auth\miseccion.blade.php --}}
<div id="imageCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicadores -->
    <ol class="carousel-indicators">
        @forelse ($imagenesCarrusel as $key => $imagen)
            <li data-target="#imageCarousel" data-slide-to="{{ $key }}"
                class="{{ $key == 0 ? 'active' : '' }}"></li>
        @empty
            <li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
        @endforelse
    </ol>

    <!-- Contenido del carrusel -->
    <div class="carousel-inner">
        @forelse ($imagenesCarrusel as $key => $imagen)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $imagen->ruta) }}" class="d-block w-100"
                    alt="Imagen {{ $key + 1 }}">
                <form action="{{ route('miseccion.deleteCarruselImage', $imagen->id) }}" method="POST"
                    class="delete-form"
                    style="position: absolute; bottom: 10px; left: 90%; transform: translateX(-50%); z-index: 9999;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta imagen?')">Eliminar</button>
                </form>
            </div>
        @empty
            <div class="carousel-item active">
                <img src="{{ asset('images/fotoRandomCarUser.jpg') }}" class="d-block w-100"
                    alt="Imagen Predeterminada">
            </div>
        @endforelse
    </div>

    <!-- Controles del carrusel -->
    <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
    </a>
</div>

@if (auth()->check() && auth()->user()->id == $user->id)
    <form action="{{ route('miseccion.storeCarruselImage') }}" method="POST" enctype="multipart/form-data"
        class="upload-form">
        @csrf
        <div class="form-group">
            <label for="imagen">Subir imagen para el carrusel:</label>
            <input type="file" id="imagen" name="imagen" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar imagen</button>
    </form>
@else
    <form style="visibility: hidden;" action="{{ route('miseccion.storeCarruselImage') }}" method="POST"
        enctype="multipart/form-data" class="upload-form">
        @csrf
        <div class="form-group">
            <label for="imagen">Subir imagen para el carrusel:</label>
            <input type="file" id="imagen" name="imagen" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar imagen</button>
    </form>
@endif

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
    function toggleNotifications() {
        var notifications = document.getElementById('notifications');
        notifications.style.display = notifications.style.display === 'block' ? 'none' : 'block';
    }
</script>
</body>
</html>
