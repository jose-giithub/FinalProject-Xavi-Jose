<?php

// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Taller;
use App\Models\MensajePrivadoTaller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Método para mostrar las notificaciones de un usuario autenticado.
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        return view('notifications.notificacionesUser', compact('notifications'));
    }
    /**
     * Método para marcar una notificación como leída.
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->read = true;
        $notification->save();

        return back()->with('success', 'Notificación marcada como leída.');
    }

    public function chat($id)
    {
        $user = Auth::user();

        $taller = Taller::findOrFail($id);
        $mensajes = MensajePrivadoTaller::where('taller_id', $id)->with('user')->get();

        return view('notifications.chatUserTaller', compact('taller', 'mensajes'));
    }

    public function sendMessage(Request $request)
    {
        // Crear y guardar el nuevo mensaje
        MensajePrivadoTaller::create([
            'taller_id' => $request->taller_id,
            'user_id' => auth()->id(),
            'mensaje' => $request->message,
            'receptor' => 'taller',
        ]);

        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }
}
