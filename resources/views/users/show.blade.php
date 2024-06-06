<!DOCTYPE html>
<html>

<head>
    <title>Detalle del Usuario</title>
</head>

<body>
    <!-- Vista donde se mostraran todos los usuarios registrados en la web  ruta para verlo http://127.0.0.1:8000/users/1-->
    <h1>{{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>Tipo de Vehículo: {{ $user->tipo_vehiculo }}</p>
    <p>Año de Fabricación: {{ $user->anoFabricacion }}</p>
    <!-- Añade más campos según sea necesario -->
    <a href="{{ route('users.usersRegistrados') }}">Volver a la lista de usuarios</a>
    
</body>

</html>