<!DOCTYPE html>
<html lang="en">
<script src="https://cdn.tailwindcss.com"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CDN iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Enlace a tu archivo CSS personalizado -->
    @vite(['resources/css/EstilosFormularioTalleres.css', 'resources/css/headerNav.css','resources/js/formCreateTaller.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <title>Unirse como taller</title>
</head>

<body class="bg-white">
    <x-navbar />

    <div class="p-8 rounded-lg shadow-lg w-full flex flex-col justify-center items-center">
        <h1 class="text-2xl font-bold mb-6 text-center" style="color: #2c2b2b;">Hola, contesta estas preguntas para unirte como taller</h1>
        <form action="{{ url('/guardar-taller') }}" method="POST" class="grid grid-cols-4 gap-4">
            @csrf
            <div class="form-group mb-4 col-span-4 bg-[#2c2b2b] p-4 rounded div1">
                <label for="nombre_de_taller" class="block text-sm font-medium text-white">Nombre del taller:</label>
                <input type="text" id="nombre_de_taller" name="nombre_de_taller" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group mb-4 col-span-2 bg-[#2c2b2b] p-4 rounded div2">
                <label for="city" class="block text-sm font-medium text-white">Ciudad donde está ubicado el taller:</label>
                <select name="city" id="city" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Barcelona</option>
                </select>
                <!-- <input type="text" id="city" name="city" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"> -->
            </div>
            <div class="form-group mb-4 col-span-2 bg-[#2c2b2b] p-4 rounded div3">
                <label for="street" class="block text-sm font-medium text-white">Calle donde está ubicado el taller:</label>
                <input type="text" id="street" name="street" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group mb-4 col-span-2 bg-[#2c2b2b] p-4 rounded div4">
                <label for="postalCode" class="block text-sm font-medium text-white">Código Postal</label>
                <input type="text" id="postalCode" name="postalCode" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group mb-4 col-span-2 bg-[#2c2b2b] p-4 rounded div5">
                <label for="telefono" class="block text-sm font-medium text-white">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" maxlength="9" pattern="[0-9]{1,9}" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group mb-4 col-span-2 bg-[#2c2b2b] p-4 rounded div6">
                <label for="correo_electronico" class="block text-sm font-medium text-white">Correo electrónico:</label>
                <input type="email" id="correo_electronico" name="correo_electronico" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
            </div>
            <!-- <div class="form-group mb-4 col-span-2 bg-[#2c2b2b] p-4 rounded div7">
                <label for="horario" class="block text-sm font-medium text-white">Horario:</label>
                <input type="text" id="horario" name="horario" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div> -->
            <div class="form-group mb-4 col-span-2 bg-[#2c2b2b] p-4 rounded">
                <label class="block text-sm font-medium text-white">Horario:</label>
                <div id="dias">
                    <!-- Lunes -->
                    <label for="lunes" class="text-white">Lunes</label>
                    <select name="lunes" id="lunes">
                        <option value="cerrado">Cerrado</option>
                        <option value="abierto">Abierto</option>
                    </select>
                    <div id="horariosLunes" style="display: none;">
                        <select name="lunes_apertura">
                            <option value="">Apertura</option>
                        </select>
                        <select name="lunes_cierre_mediodia">
                            <option value="">Cierre medio día</option>
                        </select>
                        <select name="lunes_apertura_mediodia">
                        <option value="">Apertura medio día</option>
                        </select>
                        <select name="lunes_cierre">
                        <option value="">Cierre</option>
                        </select>
                    </div>
                    <!-- Martes -->
                    <label for="martes" class="text-white">Martes</label>
                    <select name="martes" id="martes">
                        <option value="cerrado">Cerrado</option>
                        <option value="abierto">Abierto</option>
                    </select>
                    <div id="horariosMartes" style="display: none;">
                        <select name="martes_apertura">
                        <option value="">Apertura</option>
                        </select>
                        <select name="martes_cierre_mediodia">
                        <option value="">Cierre medio día</option>
                        </select>
                        <select name="martes_apertura_mediodia">
                        <option value="">Apertura medio día</option>
                        </select>
                        <select name="martes_cierre">
                        <option value="">Cierre</option>
                        </select>
                    </div>
                    <!-- Miércoles -->
                    <label for="miercoles" class="text-white">Miercoles</label>
                    <select name="miercoles" id="miercoles">
                        <option value="cerrado">Cerrado</option>
                        <option value="abierto">Abierto</option>
                    </select>
                    <div id="horariosMiercoles" style="display: none;">
                        <select name="miercoles_apertura">
                        <option value="">Apertura</option>
                        </select>
                        <select name="miercoles_cierre_mediodia">
                        <option value="">Cierre medio día</option>
                        </select>
                        <select name="miercoles_apertura_mediodia">
                        <option value="">Apertura medio día</option>
                        </select>
                        <select name="miercoles_cierre">
                        <option value="">Cierre</option>
                        </select>
                    </div>
                    <!-- Jueves -->
                    <label for="jueves" class="text-white">Jueves</label>
                    <select name="jueves" id="jueves">
                        <option value="cerrado">Cerrado</option>
                        <option value="abierto">Abierto</option>
                    </select>
                    <div id="horariosJueves" style="display: none;">
                        <select name="jueves_apertura">
                        <option value="">Apertura</option>
                        </select>
                        <select name="jueves_cierre_mediodia">
                        <option value="">Cierre medio día</option>
                        </select>
                        <select name="jueves_apertura_mediodia">
                        <option value="">Apertura medio día</option>
                        </select>
                        <select name="jueves_cierre">
                        <option value="">Cierre</option>
                        </select>
                    </div>
                    <!-- Viernes -->
                     <label for="viernes" class="text-white">Viernes</label>
                    <select name="viernes" id="viernes">
                        <option value="cerrado">Cerrado</option>
                        <option value="abierto">Abierto</option>
                    </select>
                    <div id="horariosViernes" style="display: none;">
                        <select name="viernes_apertura">
                        <option value="">Apertura</option>
                        </select>
                        <select name="viernes_cierre_mediodia">
                        <option value="">Cierre medio día</option>
                        </select>
                        <select name="viernes_apertura_mediodia">
                        <option value="">Apertura medio día</option>
                        </select>
                        <select name="viernes_cierre">
                        <option value="">Cierre</option>
                        </select>
                    </div>
                    <!-- Sábado -->
                    <label for="sabado" class="text-white">Sabado</label>
                    <select name="sabado" id="sabado">
                        <option value="cerrado">Cerrado</option>
                        <option value="abierto">Abierto</option>
                    </select>
                    <div id="horariosSabado" style="display: none;">
                        <select name="sabado_apertura">
                        <option value="">Apertura</option>
                        </select>
                        <select name="sabado_cierre_mediodia">
                        <option value="">Cierre medio día</option>
                        </select>
                        <select name="sabado_apertura_mediodia">
                        <option value="">Apertura medio día</option>
                        </select>
                        <select name="sabado_cierre">
                        <option value="">Cierre</option>
                        </select>
                    </div>
                    <!-- Domingo -->
                    <label for="Domingo" class="text-white">Domingo</label>
                    <select name="domingo" id="domingo">
                        <option value="cerrado">Cerrado</option>
                        <option value="abierto">Abierto</option>
                    </select>
                    <div id="horariosDomingo" style="display: none;">
                        <select name="domingo_apertura">
                        <option value="">Apertura</option>
                        </select>
                        <select name="domingo_cierre_mediodia">
                                 <option value="">Cierre medio día</option>
                        </select>
                        <select name="domingo_apertura_mediodia">
                        <option value="">Apertura medio día</option>
                        </select>
                        <select name="domingo_cierre">
                        <option value="">Cierre</option>
                        </select>
                    </div>
                </div>
                <input type="text" id="horario" name="horario" style="display: none;">
            </div>
            <div class="form-group mb-4 col-span-4 bg-[#2c2b2b] p-4 rounded div8">
                <label for="especialidad" class="block text-sm font-medium text-white">Especialidad:</label>
                <select name="especialidad" id="especialidad" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Especialidad</option>
                </select>
                <!-- <input type="text" id="especialidad" name="especialidad" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"> -->
            </div>
            <div class="form-group mb-4 col-span-4 bg-[#2c2b2b] p-4 rounded div9">
                <label for="elevadores" class="block text-sm font-medium text-white">Número de elevadores:</label>
                <input type="number" id="elevadores" name="elevadores" min="1" max="10" value="1" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group mb-4 col-span-4 bg-[#2c2b2b] p-4 rounded div10">
                <label for="coche_de_cortesia" class="block text-sm font-medium text-white">¿Ofrece coche de cortesía?</label>
                <select id="coche_de_cortesia" name="coche_de_cortesia" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="form-group mb-4 col-span-4 bg-[#2c2b2b] p-4 rounded div11">
                <label for="num_mecanicos" class="block text-sm font-medium text-white">Número de mecánicos:</label>
                <input type="number" id="num_mecanicos" name="num_mecanicos" min="1" max="50" value="1" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group mb-4 col-span-4 bg-[#2c2b2b] p-4 rounded div12">
                <label for="cafeteria" class="block text-sm font-medium text-white">¿Cuenta con cafetería?</label>
                <select id="cafeteria" name="cafeteria" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="form-group mb-4 col-span-4 bg-[#2c2b2b] p-4 rounded div13">
                <label for="wc" class="block text-sm font-medium text-white">¿Cuenta con baño para el público?</label>
                <select id="wc" name="wc" class="mt-1 block w-full px-3 py-2 text-[#2c2b2b] border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <button type="submit" class="col-span-4 w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Enviar
            </button>
        </form>
        <div class="flex justify-center mt-6">
            <a href="{{ url('/') }}" class="button text-white bg-black py-2 px-4 rounded-md hover:bg-gray-700">Volver al inicio</a>
        </div>
    </div>
</body>

</html>