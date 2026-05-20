<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    // Le damos permiso a Laravel para guardar datos en estas columnas
    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'grado_requerido',
        'estado',
        'vacantes'
    ];

    /**
     * Relación: Una oferta pertenece a un Usuario (Empresa)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Una oferta tiene muchas candidaturas
     */
    public function candidaturas()
    {
        return $this->hasMany(Candidatura::class);
    }
}