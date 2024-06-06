<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   /**
     * Muestra la vista con la lista de usuarios registrados.
     * @return \Illuminate\View\View La vista con la lista de usuarios registrados.
     */
    public function usersRegistrados()
    {
        // Obtiene todos los usuarios de la base de datos.
        $users = User::all();

        // Retorna la vista 'users.usersRegistrados' con los usuarios.
        return view('users.usersRegistrados', compact('users'));
    }

    /**
     * Muestra la vista de detalle de un usuario específico.
     * @param int $id El ID del usuario.
     * @return \Illuminate\View\View La vista de detalle del usuario.
     */
    public function show($id)
    {
        // Encuentra al usuario por su ID. Si no se encuentra, lanza una excepción 404.
        $user = User::findOrFail($id);

        // Retorna la vista 'users.show' con los datos del usuario.
        return view('users.show', compact('user'));
    }
}
