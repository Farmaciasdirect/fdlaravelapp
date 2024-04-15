<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\CollectionPoint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CollectionPointController extends APIController
{
    public function index(Request $request)
    {
        $zipCode = $request->input('zip');

        // Intenta recuperar los datos de la caché utilizando el código postal como clave
        $collectionPoints = Cache::remember('collection_points_' . $zipCode, 43200, function () use ($zipCode) {
            // Si los datos no están en caché, realiza la consulta a la base de datos filtrando por código postal
            return CollectionPoint::where('postal_code', $zipCode)->get();
        });

        return response()->json($collectionPoints);
    }
}
