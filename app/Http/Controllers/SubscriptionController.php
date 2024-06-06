<?php

// app/Http/Controllers/SubscriptionController.php

namespace App\Http\Controllers;

use App\Models\MensajePrivadoTaller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Taller;



class SubscriptionController extends Controller
{

    /*
        * Método para ver los suscriptores de un taller
        * Obtiene el taller por su ID y los suscriptores del taller
        * Obtiene los mensajes enviados a cada suscriptor
        * Retorna la vista con los suscriptores y el taller y los menajes enviados a cada suscriptor 
        *para mostrarlos en la vista resources\views\subscriptions\subscriptorsListTaller.blade.php
        */
    public function viewSubscribers($id)
    {
         // Encuentra el taller por su ID
        $taller = Taller::findOrFail($id);
       // Obtiene los suscriptores del taller usando la relación definida en el modelo
       $suscriptores = $taller->misSubscriptores;
                                                             

       // Obtiene los mensajes enviados a cada suscriptor
    foreach ($suscriptores as $suscriptor) {
        $suscriptor->mensajesPrivados = MensajePrivadoTaller::where('taller_id', $taller->id)
                                                            ->where('user_id', $suscriptor->id)
                                                            ->get();
    }

    // Retorna la vista con los suscriptores y el taller
    return view('subscriptions.subscriptorsListTaller', compact('taller', 'suscriptores'));
}
    
/**
 * Método para suscribir un usuario autenticado a un taller.
 *
 * @param int $tallerId El ID del taller al que se va a suscribir el usuario.
 * @return \Illuminate\Http\RedirectResponse Una redirección de vuelta con un mensaje de éxito.
 */
public function subscribe($tallerId)
{
    // Obtiene el usuario autenticado
    $user = Auth::user();

    // Crea una nueva suscripción
    $subscription = new Subscription();
    $subscription->user_id = $user->id; // Asigna el ID del usuario autenticado
    $subscription->taller_id = $tallerId; // Asigna el ID del taller al que se suscribe
    $subscription->save(); // Guarda la suscripción en la base de datos

    // Crea una notificación para el propietario del taller
    $tallerOwner = Taller::findOrFail($tallerId)->user; // Obtiene el propietario del taller
    Notification::create([
        'user_id' => $tallerOwner->id, // ID del propietario del taller que recibirá la notificación
        'follower_id' => $user->id, // ID del usuario que se ha suscrito (el seguidor)
        'taller_id' => $tallerId, // ID del taller al que se ha suscrito
    ]);

    // Redirige de vuelta a la página anterior con un mensaje de éxito
    return back()->with('success', 'Te has suscrito al taller.');
}

    public function unsubscribe($tallerId)
    {
        $user = Auth::user();
        Subscription::where('user_id', $user->id)->where('taller_id', $tallerId)->delete();

        return back()->with('success', 'Te has desuscrito del taller.');
    }



    public function markAsRead($id)
    {
        $notification = Subscription::findOrFail($id);
        $notification->read_at = now();
        $notification->save();

        return back()->with('success', 'Notificación marcada como leída.');
    }
}
