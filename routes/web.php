<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\NotificationController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Http\Controllers\MiseccionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MensajePrivadoTallerController;
use App\Http\Controllers\UserController;
use App\Mail\correoPruebasMailable;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SubscriptionController;
use App\Mail\RecordatorioFecha;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//***********************RUTA PARA VER LAS VISTAS DE LOS USUARIOS ruta , http://127.0.0.1:8000/usersRegistrados ******************************** */
//Ruta para mostrar la lista de usuarios registrados.
Route::get('/usersRegistrados', [UserController::class, 'usersRegistrados'])->name('users.usersRegistrados')->middleware('auth');

// Ruta para mostrar la sección de un usuario específico.
Route::get('/miseccion/{id}', [MiseccionController::class, 'show'])->name('miseccion.show')->middleware('auth');

// **********************RUTA PARA CORREOS AUTOMATIZADOS  DE PRUEBAS , http://127.0.0.1:8000/emailPruebas ******************
//CORREO DE PUERBA nombre vista emailPruebas.blade.php
Route::get('emailPruebas', function () {
    $user = User::find(1); // Asegúrate de que el ID del usuario existe en tu base de datos
    $tipoRecordatorio = 'ITV'; // O 'revisión'
    $diasRestantes = 30;

    if ($user) {
        Mail::to($user->email)->send(new correoPruebasMailable($user, $tipoRecordatorio, $diasRestantes));
        return 'Mensaje enviado'; // muestra 'Mensaje enviado' si el correo se envía correctamente
    } else {
        return 'Usuario no encontrado';
    }
})->name('emailPruebas');

//**********LOGIN CON BREEZE
Route::get('/dashboard', function () {
   // return view('dashboard');
    return redirect('/');
    //PARA ENTRAR QUE ESTE VERIFICADO Y AUTENTICADO POR EMAIL
})->middleware(['auth', 'verified'])->name('/');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para mostrar el formulario del taller
    Route::get('/formularioTaller', function () {
        return view('auth.formularioTaller');
    })->name('formularioTaller');

    //********************** */ Rutas para miSeccion solo acceso a usuarios  auth y verified*****************
    Route::middleware(['auth', 'verified'])->group(function () {
        // Ruta para mostrar la sección principal
        Route::get('/miseccion', [MiseccionController::class, 'index'])->name('miseccion');
        //boton subir img cabecera cabecera
        Route::post('/public/images/miseccion', [MiseccionController::class, 'uploadImage'])->name('mi-seccion.upload');
        //boton formulario vehiculo
        Route::post('/miSeccion/vehicleCreate', [MiseccionController::class, 'vehicleCreate'])->name('miSeccion.vehicleCreate');
        //boton modificar datos formulario vehículo
        Route::put('/miSeccion/updateVehicle', [MiseccionController::class, 'updateVehicle'])->name('miSeccion.updateVehicle');
        //boton añadir mantenimiento
        Route::post('/miSeccion/maintenance', [MiseccionController::class, 'maintenanceCreate'])->name('miSeccion.maintenanceCreate');
        //Boton modificar mantenimiento
        Route::put('/miSeccion/maintenance', [MiseccionController::class, 'maintenanceUpdate'])->name('miSeccion.maintenanceUpdate');
        //eliminar porción de mantenimiento
        Route::delete('/miSeccion/maintenance/{id}', [MiseccionController::class, 'destroyMaintenance'])->name('miSeccion.destroyMaintenance');
    });

    /*******************Ruta para acceder a la vista de los usuarios */
    // Si el usuario esta auntentificado
    Route::middleware(['auth'])->group(function () {
        //****** */ Ruta para ver la sección del usuario
        Route::get('/miseccion', [MiseccionController::class, 'index'])->name('miseccion.index');

        // Guardar imagenes carrusel miseccion
        Route::post('/miseccion/store-image', [MiseccionController::class, 'storeCarruselImage'])->name('miseccion.storeCarruselImage');

        // Eliminar  imagenes carrusel miseccion
        Route::delete('/miseccion/delete-image/{id}', [MiseccionController::class, 'deleteCarruselImage'])->name('miseccion.deleteCarruselImage');
    });

});

require __DIR__ . '/auth.php';
//**********FINAL LOGIN CON BREEZE

// ********LOGIN CON GITHUB
Route::get('/github-auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});
Route::get('/github-auth/callback', function () {
    $user_github = Socialite::driver('github')->user();
    $existingUser = User::where('email', $user_github->email)->first();
    if ($existingUser) {
        // El usuario ya existe, puedes iniciar sesión con él
        Auth::login($existingUser);
        return redirect('/'); // Cambiado de view('welcome') a redirect('/')
    }
    // El usuario no existe, así que lo creamos
    $user = User::create([
        'name' => $user_github->name,
        'email' => $user_github->email,
        // ...

        'password' => bcrypt(Str::random(12)),
    ]);
    // Luego, iniciamos sesión con el nuevo usuario
    Auth::login($user);
    return redirect('dashboard'); // Consistente con el flujo de usuario existente
    // return redirect('/dashboard');
});
// fin parte Github

// Parte de GOOGLE
Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-auth/callback', function () {
    $user_google = Socialite::driver('google')->user();

    $existingUser = User::where('email', $user_google->email)->first();

    if ($existingUser) {
        // El usuario ya existe, puedes iniciar sesión con él
        Auth::login($existingUser);
        return redirect('/'); // Cambiado de view('welcome') a redirect('/')
    }

    // El usuario no existe, así que lo creamos
    $user = User::create([
        'name' => $user_google->name,
        'email' => $user_google->email,
        'password' => bcrypt(Str::random(12)),
    ]);

    // Luego, iniciamos sesión con el nuevo usuario
    Auth::login($user);
    return redirect('dashboard'); // Consistente con el flujo de usuario existente
    // return redirect('/dashboard');
});

require __DIR__ . '/auth.php';
//**********FINAL LOGIN CON BREEZE

// Enlaces para los talleres etc................................................
// Enlace para talleres
Route::get('/talleres', function () {
    return view('talleres');
});

// Enlace para emergencias
Route::get('/emergencias', function () {
    return view('emergencias');
});

// Enlace para revisiones
Route::get('/revisiones', function () {
    return view('revisiones');
});

//************************talleres********************** */
// Ruta para guardar los datos para hacerse taller.
Route::post('/guardar-taller', [TallerController::class, 'store'])->name('guardar_taller');

// Ruta para ver y editar la información del taller del usuario autenticado
Route::get('/mitaller', [TallerController::class, 'myTaller'])->middleware('auth')->name('mitaller');

//boton subir img cabecera
Route::post('/public/images/taller', [TallerController::class, 'updateImageTaller'])->name('mitaller.updateImageTaller');

Route::post('/save-location', [LocationController::class, 'store'])->name('location.save');

// Ruta para ver la página del taller
Route::get('/mitaller', [TallerController::class, 'index'])->name('mitaller')->middleware('auth');

// Ruta para procesar el formulario de las ofertas
Route::post('/taller/update/ofertas', [TallerController::class, 'updateOfertas'])->name('taller.update.ofertas');

// Ruta que sirve para mostrar las localizaciones del mapa.
Route::get('/location/show', [LocationController::class, 'show'])->name('locations.show');

// routes/web.php
Route::post('/taller/{id}/store-carrusel-image', [TallerController::class, 'storeCarruselImage'])->name('taller.storeCarruselImage');

// Eliminar fotos carrusel
Route::delete('/taller/carrusel/{id}', [TallerController::class, 'deleteCarruselImage'])->name('taller.deleteCarruselImage');

// Cambiar de POST a PUT o PATCH
Route::put('/taller/{id}', [TallerController::class, 'updateTallerDetails'])->name('taller.update');

//ruta para ver el taller al clicar sobre las diferentes cards
Route::get('/talleres/{id}', [TallerController::class, 'verTallerCard'])->name('talleres.verTallerCard');

// Rutas para mostrar y comentar en los talleres
Route::post('talleres/{taller}/comentarios', [TallerController::class, 'storeComment'])->name('talleres.storeComment');
Route::get('talleres/{taller}/comentarios', [TallerController::class, 'showComments'])->name('talleres.showComments');

// Ruta para mostrar los talleres en la pagina welcome
Route::get('/', [TallerController::class, 'mostrar'])->name('welcome');

// Rutas de las localizaciones
Route::get('/locations', [LocationController::class, 'getAllLocations']);
Route::post('/taller/{tallerId}/save-location', [LocationController::class, 'store'])->name('taller.location.store');
Route::get('/taller/{tallerId}/location/show', [LocationController::class, 'show'])->name('taller.location.show');

// Rutas para los ratings de los talleres:
Route::post('/taller/{tallerId}/rate', [RatingController::class, 'store'])->name('ratings.store');
Route::get('/mitaller', [TallerController::class, 'myTaller'])->name('mitaller');

// Ruta para actualizar las dirección del taller
Route::post('/taller/{id}/updateLocation', [TallerController::class, 'updateLocation'])->name('taller.updateLocation');

//*******************////////////////ruta para welcome ////////////////************** */
// Muestra los talleres cuando hacer click sobre una card en welcome
Route::get('/taller/{id}', [TallerController::class, 'verTallerCard'])->name('taller.verTallerCard');

//****************** Rutas para suscribirse/******************** */
//subscribirse
Route::post('/taller/{tallerId}/subscribe', [SubscriptionController::class, 'subscribe'])->name('taller.subscribe');
//desubscribirse
Route::post('/taller/{tallerId}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('taller.unsubscribe');

//************************* notificación de suscrito
Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

/*******************Ruta para ver los suscriptores de un taller */
Route::middleware(['auth'])->group(function () {
    // misSubscriptores nombre de la funcion en el modelo Taller //viewSubscribers nombre de la funcion en el controlador TalleresController
    Route::get('/taller/{id}/misSubscriptores', [SubscriptionController::class, 'viewSubscribers'])->name('taller.subscriptorsListTaller');
    // ******************Ruta para enviar un mensaje privado a un suscriptor del taller
    Route::post('/taller/{taller}/mensaje/{user}', [MensajePrivadoTallerController::class, 'sendMensaje'])->name('taller.sendMensaje');
    /*********************ruta para mostrar las notificaciones de los usuarios */
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::get('/notification/chat/{id}', [NotificationController::class, 'chat'])->name('notifications.chat');

    Route::post('/notification/chat/sendMessage', [NotificationController::class, 'sendMessage'])->name('notifications.sendMessage');
});
