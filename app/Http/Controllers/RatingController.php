<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, $tallerId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'taller_id' => $tallerId],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Gracias por tu calificación!');
    }
}
