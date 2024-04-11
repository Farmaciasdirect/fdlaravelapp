<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\CollectionPoint;

class UpdateCollectionPointsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $response = Http::withoutVerifying()
            ->timeout(60)
            ->withUserAgent('Farmaciasdirect-Fdgo')
            ->withToken(env('TOKEN_FDGO_IN_MADRE'))
            ->asForm()
            ->get(sprintf(env('MADRE_COLLECTION_POINTS_ENDPOINT')));
        dd($response);
        if ($response->successful()) {
            $collectionPointsData = $response->json();

            CollectionPoint::truncate();

            foreach ($collectionPointsData as $pointData) {
                CollectionPoint::create($pointData);
            }
        } else {
            // Manejar errores si la llamada a la API falla
            logger('Failed to update collection points: ' . $response->status());
        }
    }
}
