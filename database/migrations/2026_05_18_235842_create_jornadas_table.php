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
        Schema::create('jornadas', function (Blueprint $table) {
            $table->id();
            // Conecta la jornada con la candidatura/práctica correspondiente
            $table->foreignId('candidatura_id')->constrained()->onDelete('cascade');
            $table->date('fecha');
            $table->integer('horas'); // Horas metidas ese día
            $table->text('actividad'); // Qué ha hecho el alumno
            $table->string('modalidad'); // 'telematico' o 'presencial'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jornadas');
    }
};
