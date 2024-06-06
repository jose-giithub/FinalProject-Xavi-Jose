<?php

namespace App\Http\Controllers;

use App\Models\MensajePrivadoTaller;
use App\Models\Notification;
use App\Models\Taller;
use App\Models\User;
use Illuminate\Http\Request;

class MensajePrivadoTallerController extends Controller
{
    /**
     * Método para enviar un mensaje privado a un suscriptor de un taller
     * Obtiene el taller y el usuario suscriptor y envía el mensaje
     */
    public function sendMensaje(Request $request, Taller $taller, User $user)

    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'mensaje' => 'required|string|max:1000',
        ]);
        // Crear el mensaje privado
        MensajePrivadoTaller::create([
            'taller_id' => $taller->id, // Cambiar por el id del taller
            'user_id' => $user->id,
            'mensaje' => $validatedData['mensaje'], // Mensaje del formulario
            'receptor' => 'user',
        ]);
        // Crear una notificación
        Notification::create([
            'user_id' => $user->id,
            'follower_id' => $taller->user_id, // El taller es el que envía el mensaje
            'taller_id' => $taller->id,
            'read' => false,
        ]);

        //retorno a la vista con un mensaje de éxito y redirecciono a la lista de suscriptores
        return redirect()->route('taller.subscriptorsListTaller', ['id' => $taller->id])
            ->with('success', 'Mensaje enviado con éxito.');
    }
}
