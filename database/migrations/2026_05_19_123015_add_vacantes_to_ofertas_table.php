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
        Schema::table('ofertas', function (Blueprint $table) {
            // Añadimos las vacantes por defecto a 1, justo después de la descripción
            $table->integer('vacantes')->default(1)->after('descripcion');
        });
    }

    public function down(): void
    {
        Schema::table('ofertas', function (Blueprint $table) {
            $table->dropColumn('vacantes');
        });
    }
};
