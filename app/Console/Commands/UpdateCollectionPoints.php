<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateCollectionPointsJob;

class UpdateCollectionPoints extends Command
{
    protected $signature = 'update:collection-points';
    protected $description = 'Crea job para actualizar los puntos de recogida desde madre';

    public function handle()
    {
        dispatch(new UpdateCollectionPointsJob());
        $this->info('Job Creado Correctamente.');
    }
}
