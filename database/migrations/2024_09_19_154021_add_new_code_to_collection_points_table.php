<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('collection_points', function (Blueprint $table) {
            $table->string('new_code')->after('code')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('collection_points', function (Blueprint $table) {
            $table->dropColumn('new_code');
        });
    }
};