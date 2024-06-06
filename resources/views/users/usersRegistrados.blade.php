<!DOCTYPE html>
<html>
<head>
    <title>Usuarios Registrados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .user-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .user-image-container img {
            width: 100px; /* Tamaño más grande para la imagen */
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .user-info {
            flex: 1; /* Permite que el texto ocupe el espacio restante */
        }
        .user-info p {
            margin: 0; /* Elimina los márgenes para un aspecto más limpio */
        }
        .user-info a {
            text-decoration: none; /* Elimina subrayado de los enlaces */
            color: inherit; /* Mantiene el color del texto */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Usuarios Registrados</h1>
        <ul class="list-unstyled">
            @foreach ($users as $user)
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
                            <p>El usuario  {{ $user->name }}.</p>
                            <p>Correo de contacto: {{ $user->email }}</p>
                            @if ($user->residenciaUser)
                            <p>Ciudad de residencia: {{ $user->residenciaUser }}</p>
                            @else
                            <p>Sin definir</p>
                            @endif
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
