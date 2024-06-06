<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use App\Models\Comentario;

use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    // public function guardarComentario(Request $request)
    // {
    //     $request->validate([
    //         'taller_id' => 'required|exists:talleres,id',
    //         'contenido' => 'required|string'
    //     ]);

    //     $comentario = new Comentario();
    //     $comentario->user_id = auth()->id(); // ID del usuario autenticado
    //     $comentario->taller_id = $request->taller_id; // ID del taller del formulario
    //     $comentario->contenido = $request->contenido; // Contenido del comentario
    //     $comentario->save();

    //     return redirect()->back()->with('success', 'Comentario agregado exitosamente');
    // }


    // public function mostrarTaller($tallerId) // Asegúrate de que esta función recibe el ID correcto si es necesario
    // {
    //     $taller = Taller::with('comentarios')->findOrFail($tallerId); // Carga el taller y sus comentarios asociados
    //     $comentarios = $taller->comentarios; // Extrae los comentarios para pasarlos a la vista
    //     dd($comentarios); // Esto mostrará la estructura de datos de los comentarios para asegurarte de que se están cargando correctamente.


    //     return view('auth.mitaller', compact('comentarios')); // Pasa tanto el taller como los comentarios a la vista
    // }


}
