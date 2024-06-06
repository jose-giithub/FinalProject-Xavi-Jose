<?php

namespace App\Http\Controllers;

use App\Models\ImagenCarruselMiSeccion;
use App\Models\User;
use App\Models\VehicleMaintenance;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// Añado todo esto para que funcione la data en formato DD/MM/YYYY con carbon
use Carbon\Carbon;

class MiseccionController extends Controller
{


    /**
     * Muestra la vista de la sección del usuario con su carrusel de imágenes.
     * @param int $id El ID del usuario.
     * @return \Illuminate\View\View La vista de la sección del usuario.
     */
    public function show($id)
    {
        // Encuentra al usuario por su ID. Si no se encuentra, lanza una excepción 404.
        $user = User::findOrFail($id);

        // Obtiene las imágenes del carrusel asociadas al usuario.
        $imagenesCarrusel = ImagenCarruselMiSeccion::where('user_id', $user->id)->get();

        // Retorna la vista 'auth.miseccion' con los datos del usuario y sus imágenes del carrusel.
        return view('auth.miseccion', compact('user', 'imagenesCarrusel'));
    }







    /**
     * Muestra la vista principal de la sección del usuario autenticado.
     * @return \Illuminate\View\View La vista de la sección del usuario autenticado.
     */
    // public function index()
    // {
    //     // Obtiene el usuario autenticado.
    //     $user = auth()->user();

    //     // Obtiene las imágenes del carrusel asociadas al usuario autenticado.
    //     $imagenesCarrusel = ImagenCarruselMiSeccion::where('user_id', $user->id)->get();

    //     // Retorna la vista 'auth.miseccion' con las imágenes del carrusel del usuario autenticado.
    //     return view('auth.miseccion', [
    //         'user' => $user,
    //         'imagenesCarrusel' => $imagenesCarrusel,
    //     ]);
    // }


    public function index()
    {
        $user = auth()->user();
        $imagenesCarrusel = ImagenCarruselMiSeccion::where('user_id', $user->id)->get();
        $talleresSeguidos = $user->subscriptoresTalleres;

        return view('auth.miseccion', [
            'user' => $user,
            'imagenesCarrusel' => $imagenesCarrusel,
            'talleresSeguidos' => $talleresSeguidos,
        ]);
    }





    /**
     * Guarda una nueva imagen en el carrusel del usuario autenticado.
     * @param \Illuminate\Http\Request $request La solicitud HTTP.
     * @return \Illuminate\Http\RedirectResponse Una respuesta de redirección.
     */
    public function storeCarruselImage(Request $request)
    {
        // Valida que el archivo subido sea una imagen y no exceda los 2MB.
        $request->validate([
            'imagen' => 'required|image|max:2048',
        ]);

        // Almacena la imagen en el almacenamiento público bajo la carpeta 'carrusel'.
        $path = $request->file('imagen')->store('carrusel', 'public');

        // Crea un nuevo registro de imagen de carrusel asociado al usuario autenticado.
        ImagenCarruselMiSeccion::create([
            'user_id' => auth()->id(),
            'ruta' => $path,
        ]);

        // Redirige de vuelta con un mensaje de éxito.
        return back()->with('success', 'Imagen añadida al carrusel correctamente.');
    }

    /**
     * Elimina una imagen del carrusel.
     * @param int $id El ID de la imagen del carrusel a eliminar.
     * @return \Illuminate\Http\RedirectResponse Una respuesta de redirección.
     */
    public function deleteCarruselImage($id)
    {
        // Encuentra la imagen del carrusel por su ID. Si no se encuentra, lanza una excepción 404.
        $imagen = ImagenCarruselMiSeccion::findOrFail($id);

        // Elimina el archivo de imagen del almacenamiento público.
        Storage::disk('public')->delete($imagen->ruta);

        // Elimina el registro de la imagen del carrusel de la base de datos.
        $imagen->delete();

        // Redirige de vuelta con un mensaje de éxito.
        return back()->with('success', 'Imagen eliminada del carrusel.');
    }

    /**
     * Muestra el carrusel de imágenes del usuario autenticado.
     * @return \Illuminate\View\View La vista del carrusel de imágenes del usuario autenticado.
     */
    public function showUserCarousel()
    {
        // Obtiene el usuario autenticado.
        $user = auth()->user();

        // Obtiene las imágenes del carrusel del usuario utilizando la relación definida en el modelo.
        $carouselImages = $user->carouselImages;

        // Retorna la vista con las imágenes del carrusel del usuario.
        return view('tu_vista', ['imagenesCarrusel' => $carouselImages]);
    }

    /**
     * Subir imagen de la portada para la vista miSeccion
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'fotoPortada' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('fotoPortada')) {
            $user = auth()->user();

            // Elimina la imagen antigua si existe
            if ($user->fotoPortada && Storage::disk('public')->exists($user->fotoPortada)) {
                Storage::disk('public')->delete($user->fotoPortada);
            }

            // Guarda la nueva imagen y actualiza la información del usuario
            $path = $request->file('fotoPortada')->store('images', 'public');
            $user->fotoPortada = $path;
            $user->save();


            return back()->with('success', 'Imagen actualizada con éxito.');
        }

        return back()->with('error', 'Ocurrió un problema al subir la imagen.');
    }

    /**
     * Controlador de formulario de vehículo
     */
    // public function saveVehicleType(Request $request)
    public function vehicleCreate(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'tipo_vehiculo' => 'required|string|max:30',
            'tipo_combustible' => 'required|string|max:30',
            'anoFabricacion' => 'required|integer|min:1900|max:2024',
            'marca' => 'required|string|max:30',
            'modelo' => 'required|nullable|string|max:100',
            'km' => 'required|integer|min:0|max:2000000',
            'cc' => 'nullable|integer|min:0|max:10000',
            'cv' => 'required|integer|min:0|max:10000',
            'fechaITV' => 'required|date|after:2024-01-01|before:2039-12-31',
            'fechaUltimaRevision' => 'nullable|date|after:2020-01-01|before:2039-12-31',
            'nomTaller' => 'nullable|string|max:30',
            'residenciaUser' => 'required|string|max:30',
        ]);
        Log::info('Entra en guardar vehículo');
        $user = auth()->user();
        //$user->fill($request->all());
        $user->tipo_vehiculo = $request->tipo_vehiculo;
        $user->tipo_combustible = $request->tipo_combustible;
        $user->anoFabricacion = $request->anoFabricacion;
        $user->marca = $request->marca;
        $user->modelo = $request->modelo;
        $user->km = $request->km;
        $user->cc = $request->cc;
        $user->cv = $request->cv;
        $user->fechaITV = $request->fechaITV;
        $user->fechaUltimaRevision = $request->fechaUltimaRevision;
        $user->nomTaller = $request->nomTaller;
        $user->residenciaUser = $request->residenciaUser;
        if ($user->save()) {
            Log::info('Exito al guardar vehículo');
            return back()->with('success', 'Tipo de vehículo actualizado con éxito.');
        } else {
            Log::error('Error al guardar vehículo');
            return back()->with('error', 'Error al guardar el tipo de vehículo.');
        }
    }

    //Modificar datos formulario del vehiculo
    public function updateVehicle(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tipo_vehiculo' => 'required|string|max:30',
            'tipo_combustible' => 'required|string|max:30',
            'anoFabricacion' => 'required|integer|min:1900|max:2024',
            'marca' => 'required|string|max:30',
            'modelo' => 'required|nullable|string|max:100',
            'km' => 'required|integer|min:0|max:2000000',
            'cc' => 'nullable|integer|min:0|max:10000',
            'cv' => 'required|integer|min:0|max:10000',
            'fechaITV' => 'nullable|date|after:2024-01-01|before:2039-12-31',
            'fechaUltimaRevision' => 'required|date|after:2020-01-01|before:2039-12-31',
            'nomTaller' => 'nullable|string|max:30',
            'residenciaUser' => 'required|string|max:30',
        ]);
        Log::info('Entra en editar vehículo');
        $user = auth()->user();
        $user->tipo_vehiculo = $request->tipo_vehiculo;
        $user->tipo_combustible = $request->tipo_combustible;
        $user->anoFabricacion = $request->anoFabricacion;
        $user->marca = $request->marca;
        $user->modelo = $request->modelo;
        $user->km = $request->km;
        $user->cc = $request->cc;
        $user->cv = $request->cv;
        $user->fechaITV = $request->fechaITV;
        $user->fechaUltimaRevision = $request->fechaUltimaRevision;
        $user->nomTaller = $request->nomTaller;
        $user->residenciaUser = $request->residenciaUser;

        if ($user->save()) {
            Log::info('Exito al modificar vehículo en la función updateVehicle');
            return back()->with('success', 'Tipo de vehículo actualizado con éxito.');
            // return redirect()->route('miseccion')->with('success', 'Datos del vehículo actualizados con éxito.');
        } else {
            Log::error('Error al modificar vehículo en la función updateVehicle');
            return back()->with('error', 'No se pudo actualizar la información del vehículo.');
        }
    }
    //controlador para guardar mantenimiento// dd($request->all());
    public function maintenanceCreate(Request $request)
    {
        $request->validate([
            'fechaMantenimiento' => 'required|date|after:2020-01-01|before:2039-12-31',
            'nomDeTaller' => 'nullable|string|max:30',
            'trabajoRealizado' => 'required|string|max:250',
        ]);

        Log::info('Entrando en guardar mantenimiento');

        $user = auth()->user();

        $maintenance = $user->maintenances()->create([
            'fechaMantenimiento' => $request->fechaMantenimiento,
            'nomDeTaller' => $request->nomDeTaller,
            'trabajoRealizado' => $request->trabajoRealizado,
        ]);

        if ($maintenance) {
            Log::info('Éxito al guardar mantenimiento');
            return back()->with('success', 'Mantenimiento creado con éxito.');
        } else {
            Log::error('Error al guardar mantenimiento');
            return back()->with('error', 'Error al guardar el mantenimiento.');
        }
    }

    public function maintenanceUpdate(Request $request)
    {
        $request->validate([
            'fechaMantenimiento' => 'required|date|after:2020-01-01|before:2039-12-31',
            'nomDeTaller' => 'nullable|string|max:30',
            'trabajoRealizado' => 'required|string|max:250',
        ]);

        Log::info('Entrando en modificar mantenimiento');

        $user = auth()->user();
        $maintenance = VehicleMaintenance::find($request->id);
        $maintenance->fechaMantenimiento =  $request->fechaMantenimiento;
        $maintenance->nomDeTaller = $request->nomDeTaller;
        $maintenance->trabajoRealizado = $request->trabajoRealizado;
        $maintenance->save();

        // $maintenance = $user->maintenanceUpdate()->update([
        //     'fechaMantenimiento' => $request->fechaMantenimiento,
        //     'nomDeTaller' => $request->nomDeTaller,
        //     'trabajoRealizado' => $request->trabajoRealizado,
        // ]);

        if ($maintenance) {
            Log::info('Éxito al modificar mantenimiento');
            return back()->with('success', 'Mantenimiento modificado con éxito.');
        } else {
            Log::error('Error al modificar mantenimiento');
            return back()->with('error', 'Error al modificado el mantenimiento.');
        }
    }

    /**
     * Delete para la porción de mantenimiento.
     */
    public function destroyMaintenance($id)
    {
        $maintenance = VehicleMaintenance::find($id);

        if ($maintenance) {
            $maintenance->delete();
            return back()->with('success', 'Maintenance record deleted successfully.');
        }

        return back()->with('error', 'Maintenance record not found.');
    }
}
