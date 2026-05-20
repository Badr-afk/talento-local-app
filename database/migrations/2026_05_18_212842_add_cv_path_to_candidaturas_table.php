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
        Schema::table('candidaturas', function (Blueprint $table) {
            // Creamos la columna para la ruta del archivo justo después de la oferta
            $table->string('cv_path')->nullable()->after('oferta_id');
        });
    }

    public function down(): void
    {
        Schema::table('candidaturas', function (Blueprint $table) {
            $table->dropColumn('cv_path');
        });
    }
};
