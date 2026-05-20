<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversacion; // <- Importamos el modelo de las conversaciones
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    // Muestra el panel con los alumnos asignados, los libres y los CHATS
    public function misAlumnos()
    {
        // 1. Alumnos de este profesor
        $misAlumnos = User::where('rol', 'estudiante')
            ->where('tutor_id', Auth::id())
            ->get();

        // 2. Alumnos sin profesor
        $alumnosLibres = User::where('rol', 'estudiante')
            ->whereNull('tutor_id')
            ->get();

        // 3. NUEVO: Buscamos los chats donde este profesor esté involucrado
        $chats = Conversacion::with(['empresa', 'candidatura.user', 'candidatura.oferta'])
            ->where('tutor_id', Auth::id())
            ->get();

        return view('tutor.alumnos', compact('misAlumnos', 'alumnosLibres', 'chats'));
    }

    // Asigna un alumno libre a este tutor
    public function asignarAlumno($id)
    {
        $alumno = User::findOrFail($id);

        if ($alumno->rol === 'estudiante' && is_null($alumno->tutor_id)) {
            $alumno->tutor_id = Auth::id();
            $alumno->save();
        }

        return redirect()->back();
    }
}
