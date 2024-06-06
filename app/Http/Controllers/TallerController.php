<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\Taller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ImagenCarrusel;
use App\Models\Comentario;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Support\Facades\Http;
use App\Models\Location;
use App\Models\Notification;
use App\Notifications\UserNeedsRevisionNotification;

class TallerController extends Controller
{


    public function store(Request $request)
    {
        //dd($request->all());
        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Valida los datos del formulario
        $validatedData = $request->validate([
            'nombre_de_taller' => 'required|string|max:100',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postalCode' => 'required|string|max:10',
            'telefono' => 'required|string|max:100',
            'correo_electronico' => 'required|string|email|max:100',
            'horario' => 'required|string|max:600',
            'especialidad' => 'required|string|max:100',
            'elevadores' => 'required|integer|max:10',
            'coche_de_cortesia' => 'required|boolean',
            'num_mecanicos' => 'required|integer|max:50',
            'cafeteria' => 'required|boolean',
            'wc' => 'required|boolean',
        ]);

        // Asigna el valor de 'city' a 'ubicacionTaller'
        $validatedData['ubicacionTaller'] = $request->input('city');
        $validatedData['user_id'] = $user->id;

        // Crea un nuevo registro en la tabla 'talleres' con los datos validados
        $taller = Taller::create($validatedData);

        // Guarda la localización
        Location::create([
            'taller_id' => $taller->id,
            'street' => $request->input('street'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postalCode'),
        ]);

        // Crea una calificación inicial de 3 estrellas
        Rating::create([
            'user_id' => $user->id,
            'taller_id' => $taller->id,
            'rating' => 3,
        ]);

        // Actualiza el campo 'taller' en la tabla 'users' a true
        $user->update(['taller' => true]);

        // Redirige a la página principal (welcome)
        return redirect()->route('mitaller')->with('success', 'Taller creado con éxito.');
    }

    public function updateLocation(Request $request, $id)
    {
        $taller = Taller::findOrFail($id);
        $location = $taller->location;

        if (!$location) {
            $location = new Location();
            $location->taller_id = $taller->id;
        }

        $location->street = $request->input('street');
        $location->city = $request->input('city');
        $location->postal_code = $request->input('postal_code');
        $location->latitude = $request->input('latitude');
        $location->longitude = $request->input('longitude');
        $location->save();

        // Actualizar el campo ubicacionTaller en la tabla talleres
        $taller->ubicacionTaller = $request->input('city');
        $taller->save();

        return redirect()->back()->with('success', 'Ubicación actualizada correctamente');
    }


    public function updateTallerDetails(Request $request, $id)
    {
        $request->validate([
            'nombre_de_taller' => 'required|string|max:255',
            'ubicacionTaller' => 'required|string|max:30',
            'elevadores' => 'required|int|max:10',
            'num_mecanicos' => 'required|int|max:50',
            'especialidad' => 'required|string|max:100',
            'telefono' => 'required|string|max:9',
            'correo_electronico' => 'required|string|max:100',
            'horario' => 'required|string|max:600',
        ]);

        Taller::updateOrCreate(['id' => $id], [
            'nombre_de_taller' => $request->nombre_de_taller,
            'ubicacionTaller' => $request->ubicacionTaller,
            'cafeteria' => $request->has('cafeteria') ? 1 : 0,
            'wc' => $request->has('wc') ? 1 : 0,
            'elevadores' => $request->elevadores,
            'coche_de_cortesia' => $request->has('coche_de_cortesia') ? 1 : 0,
            'num_mecanicos' => $request->num_mecanicos,
            'especialidad' => $request->especialidad,
            'telefono' => $request->telefono,
            'correo_electronico' => $request->correo_electronico,
            'horario' => $request->horario,
        ]);

        return back()->with('success', 'Taller actualizado con éxito.');
    }



    public function updateImageTaller(Request $request)
    {
        $request->validate([
            'image_path' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $taller = Taller::where('user_id', auth()->id())->firstOrFail();

            if ($taller->image_path && Storage::disk('public')->exists($taller->image_path)) {
                Storage::disk('public')->delete($taller->image_path);
            }

            $path = $request->file('image_path')->store('images/portada_taller', 'public');
            $taller->image_path = $path;
            $taller->save();

            return back()->with('success', 'Imagen actualizada con éxito.');
        }

        return back()->with('error', 'Ocurrió un problema al subir la imagen.');
    }

    public function updateOfertas(Request $request)
    {
        $request->validate([
            'ofertas' => 'required|string',
            'imagen_oferta' => 'nullable|image|max:2048',
        ]);

        $taller = Taller::where('user_id', Auth::id())->first();
        if ($taller) {
            $datos = ['ofertas' => $request->ofertas];

            if ($request->hasFile('imagen_oferta')) {
                $path = $request->file('imagen_oferta')->store('public/ofertas');
                $datos['imagen_oferta'] = $path;
            }

            $taller->update($datos);
            return back()->with('success', 'Ofertas actualizadas correctamente.');
        } else {
            return back()->with('error', 'Taller no encontrado.');
        }
    }
    /**
     * Muestra la página principal con los talleres filtrados por ubicación y talleres destacados.
     *
     * @param Request $request El objeto de solicitud que contiene los parámetros de búsqueda.
     * @return \Illuminate\View\View La vista 'welcome' con los talleres filtrados, talleres destacados y usuarios.
     */
    public function mostrar(Request $request)
    {
        $ubicacion = $request->input('ubicacion');
        $especialidad = $request->input('especialidad');

        // Define las coordenadas por defecto (Reus)
        $coordinates = [
            'lat' => 41.1561,
            'lng' => 1.1069,
        ];

        // Si se proporciona una ubicación, llama a la API de Google Maps para obtener las coordenadas
        if ($ubicacion) {
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            $geoData = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
                'address' => $ubicacion,
                'key' => $apiKey,
            ])->json();

            // Si la API devuelve una respuesta válida, actualiza las coordenadas con las de la ubicación buscada
            if ($geoData['status'] === 'OK') {
                $coordinates['lat'] = $geoData['results'][0]['geometry']['location']['lat'];
                $coordinates['lng'] = $geoData['results'][0]['geometry']['location']['lng'];
            }
        }

        // Obtén los talleres filtrados por ubicación y/o especialidad
        $query = Taller::with('location', 'ratings');
        if ($ubicacion) {
            $query->where('ubicacionTaller', 'LIKE', "%{$ubicacion}%");
        }
        if ($especialidad) {
            $query->where('especialidad', 'LIKE', "%{$especialidad}%");
        }
        $talleres = $query->get()->sortByDesc(function ($taller) {
            return $taller->averageRating();
        });

        // Obtén los talleres destacados
        $talleresDestacados = Taller::with('location', 'ratings')
            ->where('destacado', true)
            ->get()
            ->sortByDesc(function ($taller) {
                return $taller->averageRating();
            });

        // Carga las ubicaciones de todos los talleres
        $locations = Location::with('taller')->get();

        return view('welcome', compact('talleres', 'talleresDestacados', 'ubicacion', 'especialidad', 'coordinates', 'locations'));
    }


    public function verMiseccion($id)
    {
        $usuario = User::findOrFail($id);
        $imagenesCarrusel = ImagenCarrusel::where('user_id', $id)->get();
        return view('auth.miseccion', compact('usuario', 'imagenesCarrusel'));
    }

    public function index()
    {
        $taller = Taller::where('user_id', Auth::id())->first();
        $imagenesCarrusel = ImagenCarrusel::where('taller_id', $taller->id)->get();
        $averageRating = $taller->averageRating();

        return view('auth.mitaller', [
            'taller' => $taller,
            'imagenesCarrusel' => $imagenesCarrusel,
            'averageRating' => $averageRating,
        ]);
    }



    public function myTaller()
    {
        $user = auth()->user();
        $taller = Taller::where('user_id', $user->id)->first();

        if (!$taller) {
            return redirect()->route('formularioTaller')->with('error', 'Primero debes registrar un taller.');
        }

        $averageRating = $taller->averageRating() ?: 0;
        $imagenesCarrusel = ImagenCarrusel::where('taller_id', $taller->id)->get();

        // Get unread notifications
        $notifications = Notification::where('user_id', $user->id)->where('read', false)->get();

        return view('auth.mitaller', [
            'taller' => $taller,
            'imagenesCarrusel' => $imagenesCarrusel,
            'averageRating' => $averageRating,
            'notifications' => $notifications,
        ]);
    }


    public function show($id)
    {
        $taller = Taller::with('comentarios.user', 'ratings')->findOrFail($id);
        $averageRating = $taller->averageRating();
        return view('auth.mitaller', compact('taller', 'averageRating'));
    }

    public function storeCarruselImage(Request $request, $taller_id)
    {
        $request->validate([
            'imagen' => 'required|image|max:2048',
        ]);

        $path = $request->file('imagen')->store('carrusel', 'public');

        ImagenCarrusel::create([
            'taller_id' => $taller_id,
            'ruta' => $path,
        ]);

        return back()->with('success', 'Imagen añadida al carrusel correctamente.');
    }

    public function deleteCarruselImage($id)
    {
        $imagen = ImagenCarrusel::findOrFail($id);

        Storage::disk('public')->delete($imagen->ruta);
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada del carrusel.');
    }


    public function verTallerCard($id)
    {
        $taller = Taller::with('comentarios.user', 'ratings')->findOrFail($id);
        $averageRating = $taller->averageRating();

        // Obtener notificaciones solo si el usuario es el dueño del taller
        $notifications = [];
        if (auth()->check() && auth()->user()->id == $taller->user_id) {
            $notifications = Subscription::where('taller_id', $taller->id)
                ->with('user')
                ->whereNull('read_at')
                ->get();
        }

        $imagenesCarrusel = ImagenCarrusel::where('taller_id', $id)->get();

        return view('auth.mitaller', [
            'taller' => $taller,
            'imagenesCarrusel' => $imagenesCarrusel,
            'averageRating' => $averageRating,
            'notifications' => $notifications,
        ]);
    }


    public function storeComment(Request $request, $tallerId)
    {
        $request->validate([
            'contenido' => 'required|string',
        ]);

        $comentario = new Comentario();
        $comentario->contenido = $request->contenido;
        $comentario->user_id = auth()->id();
        $comentario->taller_id = $tallerId;
        $comentario->save();

        return back()->with('success', 'Comentario añadido con éxito.');
    }

    /********************************
     * Método que obtiene los datos de los controladores de Taller.php , metodo misSubscriptores() y de user.php subscriptoresTalleres()
     * Este metodo para ver los subscriptores de un taller
     */
    public function viewSubscribers($id)
    {
        // Encuentra el taller por su ID
        $taller = Taller::findOrFail($id);

       // Obtiene los suscriptores del taller usando la relación definida en el modelo
       $suscriptores = $taller->misSubscriptores; // Aquí se usa la relación `misSubscriptores` del modelo Taller

        // Retorna la vista con los suscriptores
        return view('taller.suscriptores', compact('taller', 'suscriptores'));
    }

    /**
     * Método para que un taller reciba la notificación si un usuario subscrito necesita una revisión en menos de 29 días
     *
     * @param int $tallerId El ID del taller en el que user esta subscrito.
     * @return \Illuminate\Http\RedirectResponse Una redirección de vuelta con un mensaje de éxito.
     */
    public function requestRevision(Request $request)
    {
        $user = auth()->user();
        $taller = Taller::find($request->taller_id);

        if ($taller) {
            Notification::send($taller, new UserNeedsRevisionNotification($user));
            return back()->with('success', 'La solicitud de revisión ha sido enviada.');
        }

        return back()->with('error', 'Taller no encontrado.');
    }
}
    // Controlador de folower
    // public function followers()
    // {
    //     $taller = auth()->user()->taller;
    //     $followers = $taller->followers; // Asegúrate de tener una relación followers definida en el modelo Taller
    //     return view('followers', compact('followers'));
    // }

