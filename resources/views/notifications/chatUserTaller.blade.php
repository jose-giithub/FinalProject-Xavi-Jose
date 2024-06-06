<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat del Taller</title>
       <!-- CDN iconos -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite([ 'resources/css/headerNav.css','resources/css/footer.css', ])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<!--******************** inporto el nav desde resources\views\components\navbar.blade.phpD -->
<x-navbar />
<body class="bg-gray-100 min-h-screen flex flex-col items-center p-6">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Chat del Taller: {{ $taller->nombre_de_taller }}</h1>
        <p class="text-gray-700 mb-6">ID del Taller: {{ $taller->id }}</p>

        <!-- Aquí puedes agregar más detalles del taller o el chat -->
        <div class="space-y-4">
            <div class="p-4 bg-blue-50 rounded-lg">

                <!-- Mostrar mensajes -->
                <div class="mb-4">
                    @foreach ($mensajes as $mensaje)
                        @if ($mensaje->receptor === 'taller')
                            <div class="flex justify-end mb-2">
                                <div class="bg-gray-300 text-gray-900 p-2 rounded shadow-md max-w-xs">
                                    <strong>{{ $mensaje->user->name }}:</strong>
                                    <p>{{ $mensaje->mensaje }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-start mb-2">
                                <div class="bg-blue-500 text-white p-2 rounded shadow-md max-w-xs">
                                    <strong>Taller: {{ $taller->nombre_de_taller }} </strong>
                                    <p>{{ $mensaje->mensaje }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Formulario de envío de mensajes -->
                <form action="{{ route('notifications.sendMessage') }}" method="POST" class="w-full">
                    @csrf
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Mensaje:</label>
                        <textarea id="message" name="message" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required></textarea>
                    </div>
                    <input type="hidden" name="taller_id" value="{{ $taller->id }}">
                    <input type="hidden" name="receptor" value="taller">
                    <input type="hidden" name="receptor_id" value="{{ $taller->id }}">
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   <!-- *********************inporto footer desde  resources\views\components\footer.blade.php -->
<div id="footer-container" style=" width: 100%;">
<x-footer />
</div>
  
</body>

</html>
