<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taller;

class WelcomeController extends Controller
{
    //Controlador para la vista resources\views\welcome.blade.php y mostrar los talleres que hay en una ciudad en concreto

    /**
     * Funcion que recibe un input con una ciudad que el usuario ha introducidon en el buscador de la vista welcome.blade.php
     * y retorna todos los talleres que coincidan con esa ciudad
     */
    public function buscarTallerPorCiudad(Request $request)

    {
        $query = Taller::query();//Creamos una query para buscar los talleres
        
        if ($request->has('ciudad')) {//Si el request tiene un input con nombre 'ciudad'
            $ciudad = trim($request->input('ciudad'));//Guardamos en la variable $ciudad el valor del input 'ciudad' del request
            $query->where('ubicacionTaller', 'LIKE', "%{$ciudad}%");//Buscamos en la tabla 'talleres' todos los talleres que tengan en la columna 'ubicacionTaller' la ciudad que ha introducido el usuario
        }

        $talleres = $query->get();//Guardamos en la variable $talleres todos los talleres que hemos encontrado

       return view('welcome', compact('talleres'));//Retornamos la vista welcome.blade.php con los talleres encontrados

    }

}
