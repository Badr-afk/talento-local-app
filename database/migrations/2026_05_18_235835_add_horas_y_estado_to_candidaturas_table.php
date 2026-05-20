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
            // Horas asignadas para las prácticas (ej. 400)
            $table->integer('horas_totales')->nullable()->after('cv_path');
            // Estado para saber si está aceptado, en curso o terminado
            $table->string('estado_practicas')->default('pendiente')->after('horas_totales'); // pendiente, en_curso, finalizada
        });
    }

    public function down(): void
    {
        Schema::table('candidaturas', function (Blueprint $table) {
            $table->dropColumn(['horas_totales', 'estado_practicas']);
        });
    }
};
