<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    protected $table = 'conversaciones';
    protected $fillable = ['candidatura_id', 'empresa_id', 'tutor_id'];

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
    public function empresa()
    {
        return $this->belongsTo(User::class, 'empresa_id');
    }
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
    public function candidatura()
    {
        return $this->belongsTo(Candidatura::class);
    }
}
