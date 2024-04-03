<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\CollectionPoint;
use Illuminate\Support\Facades\Cache;

class CollectionPointController extends APIController
{
    public function index()
    {
        $collectionPoints = Cache::remember('collection_points', 360, function () {
            return CollectionPoint::all();
        });

        return response()->json($collectionPoints);
    }
}
