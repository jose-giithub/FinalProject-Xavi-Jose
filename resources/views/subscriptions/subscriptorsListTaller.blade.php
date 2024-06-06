<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <!-- CDN iconos -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Enlace a tu archivo CSS personalizado -->
    @vite([ 'resources/css/headerNav.css','resources/css/footer.css', ])
    <title>followers de tu taller</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .user-container {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-bottom: 20px !important;
            border: 1px solid #ccc !important;
            padding: 20px !important;
            border-radius: 8px !important;
            background-color: #f9f9f9 !important;
        }
        .user-image-container img {
            width: 100px !important; /* Tamaño más grande para la imagen */
            height: 100px !important;
            border-radius: 50% !important;
            margin-right: 20px !important;
        }
        .user-info {
            flex: 3 !important; /* Permite que el texto ocupe el espacio restante */
        }
        .user-info p {
            margin: 0 !important; /* Elimina los márgenes para un aspecto más limpio */
        }
        .user-info a {
            text-decoration: none !important; /* Elimina subrayado de los enlaces */
            color: inherit !important; /* Mantiene el color del texto */
        }
        h1 {
            font-size: 35px !important;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
    </style>
</head>
<body>
    <!--******************** inporto el nav desde resources\views\components\navbar.blade.phpD -->
    <x-navbar />
    <!-- ******************Seccion ver foto usuario subscriptor, info y mensjes que el taller le ha enviado*********** -->
    <div class="container">
    <h1 class="text-center my-4">Usuarios suscritos a tu taller</h1>
    <ul class="list-unstyled">
        @foreach ($suscriptores as $user)
            <li class="user-container">
                <div class="user-image-container">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image">
                    @else
                        <img src="{{ asset('images/userRandom.png') }}" alt="Default Profile Image">
                    @endif
                </div>
                <div class="user-info">
                    <a href="{{ route('miseccion.show', $user->id) }}">
                        <p>El usuario {{ $user->name }}.</p>
                        @if ($user->residenciaUser)
                            <p>Ciudad de residencia: {{ $user->residenciaUser }}</p>
                        @else
                            <p>Ciudad de residencia: Sin definir</p>
                        @endif
                    </a>
                    <form action="{{ route('taller.sendMensaje', ['taller' => $taller->id, 'user' => $user->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="mensaje" class="form-control" placeholder="Escribe tu mensaje aquí"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Enviar Mensaje</button>
                    </form>

                    <!-- **************Mostrar los mensajes enviados************* -->
                    @if ($user->mensajesPrivados->isNotEmpty())
                        <div class="mt-3">
                            <h5>Mensajes enviados:</h5>
                            <ul class="list-group">
                                @foreach ($user->mensajesPrivados as $mensaje)
                                    <li class="list-group-item">
                                        {{ $mensaje->mensaje }} <br>
                                        <small class="text-muted">{{ $mensaje->created_at }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>

    <!-- *********************inporto footer desde  resources\views\components\footer.blade.php -->
    <x-footer />
</body>
</html>
