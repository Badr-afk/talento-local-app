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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // A quién va el aviso
            $table->string('mensaje'); // El texto ("Tienes un nuevo mensaje")
            $table->string('url')->nullable(); // A dónde te lleva al hacer clic
            $table->boolean('leida')->default(false); // Para saber si apagar el punto rojo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacions');
    }
};
