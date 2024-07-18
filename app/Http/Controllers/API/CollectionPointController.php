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
        $cacheKey = 'collection_points_' . $zipCode;
        if (Cache::has($cacheKey)) {
            $collectionPoints = Cache::get($cacheKey);
        } else {
            // Si los datos no están en caché, realiza la consulta a la base de datos filtrando por código postal
            $collectionPoints = CollectionPoint::where('postal_code', $zipCode)->get();

            // Si la consulta devuelve resultados, guarda en la caché
            if ($collectionPoints->isNotEmpty()) {
                Cache::put($cacheKey, $collectionPoints, 43200); // 12 horas
            }
        }

        return response()->json($collectionPoints);
    }
}