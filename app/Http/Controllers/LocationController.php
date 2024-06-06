<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Taller;

class LocationController extends Controller
{
    public function store(Request $request, $tallerId)
    {
        $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postalCode' => 'required|string|max:10',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $taller = Taller::findOrFail($tallerId);

        $location = Location::updateOrCreate(
            ['taller_id' => $taller->id],
            [
                'street' => $request->street,
                'city' => $request->city,
                'postal_code' => $request->postalCode,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]
        );

        return response()->json(['message' => 'Localización guardada exitosamente!']);
    }

    public function show($tallerId)
    {
        $location = Location::where('taller_id', $tallerId)->first();
        if (!$location) {
            return response()->json(['message' => 'No se encontró la localización.', 'status' => false]);
        }
        return response()->json(['location' => $location, 'status' => true]);
    }

    public function getAllLocations()
    {
        $locations = Location::with('taller')->get();
        return response()->json(['locations' => $locations]);
    }
}
