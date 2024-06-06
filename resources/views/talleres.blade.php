<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Talleres</title>
    @vite (['resources/css/EstilosTalleres.css'])
</head>
<body>

<div class="container">
    <!-- Filtrado de talleres -->
    <div class="filtro-talleres">
        <h2>Filtrar Talleres por Categoría</h2>
        <!-- Aquí podrías agregar tus opciones de filtrado, como botones o un menú desplegable -->
    </div>

    <!-- Visualización de imágenes de talleres -->
    <div class="imagenes-talleres">
        <h2>Imágenes de Talleres</h2>
        <!-- Aquí podrías mostrar las imágenes de los talleres -->
    </div>

    <!-- Noticias de talleres -->
    <div class="noticias-talleres">
        <h2>Noticias de Talleres</h2>
        <!-- Aquí podrías mostrar las noticias relacionadas con los talleres -->
    </div>
</div>

</body>
</html>
