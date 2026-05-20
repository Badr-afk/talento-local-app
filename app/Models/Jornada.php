<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    use HasFactory;

    protected $table = 'jornadas';
    
    protected $fillable = ['candidatura_id', 'fecha', 'horas', 'actividad', 'modalidad'];

    // Relación: Una jornada pertenece a una candidatura de prácticas concreta
    public function candidatura()
    {
        return $this->belongsTo(Candidatura::class);
    }
}