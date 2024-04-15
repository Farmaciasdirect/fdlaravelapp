<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use App\Models\CollectionPoint;
use Exception;

class UpdateCollectionPointsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $response = Http::withoutVerifying()
            ->timeout(60)
            ->withUserAgent(env('USER_AGENT_AUTHORIZED'))
            ->withToken(env('TOKEN_FDGO_IN_MADRE'))
            ->asForm()
            ->get(sprintf(env('MADRE_COLLECTION_POINTS_ENDPOINT')));
    
        if ($response->successful()) {
            DB::beginTransaction();
    
            $collectionPointsData = $response->json();
    
            try {
                DB::table('collection_points')->truncate();

                foreach ($collectionPointsData as $pointData) {
                    unset($pointData['created_at']);
                    unset($pointData['updated_at']);
                    DB::table('collection_points')->insert($pointData);
                }
    
                DB::commit();
                Log::info('Collection points updated successfully.');
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Failed to update collection points: ' . $e->getMessage());
                throw $e;
            }
        } else {
            Log::error('Failed to update collection points: ' . $response->status());
        }
    }    
}