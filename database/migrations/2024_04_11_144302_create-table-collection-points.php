<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('collection_points', function (Blueprint $table) {
            $table->id('id_collection_point');
            $table->string('agency', 15);
            $table->string('code', 20);
            $table->string('name', 255);
            $table->string('address', 255);
            $table->string('postal_code', 10);
            $table->string('city', 200);
            $table->string('state', 100);
            $table->string('country', 100);
            $table->string('country_iso', 2);
            $table->decimal('latitude', 18, 15)->nullable();
            $table->decimal('longitude', 18, 15)->nullable();
            $table->json('schedule')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_points');
    }
};
