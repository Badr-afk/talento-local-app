<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
    use HasFactory;

    // 1. Aquí ponemos TODOS los campos permitidos (una sola vez)
    protected $fillable = [
        'user_id',
        'oferta_id',
        'cv_path',
        'horas_totales',
        'estado_practicas'
    ];

    // 2. Relación: Una candidatura pertenece a un Estudiante (Usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 3. Relación: Una candidatura pertenece a una Oferta
    public function oferta()
    {
        return $this->belongsTo(Oferta::class);
    }

    // 4. Relación: Una práctica/candidatura tiene muchas jornadas diarias registradas
    public function jornadas()
    {
        return $this->hasMany(Jornada::class);
    }
    
    // Relación: Una candidatura puede tener un chat asociado si el alumno es elegido
    public function conversacion()
    {
        return $this->hasOne(Conversacion::class);
    }
}
