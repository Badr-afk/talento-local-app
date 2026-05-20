<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = ['conversacion_id', 'user_id', 'cuerpo'];

    public function remitente() { return $this->belongsTo(User::class, 'user_id'); }
}