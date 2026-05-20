<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidatura;
use App\Models\Jornada;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // <- IMPORTANTE: Cargamos el motor de PDFs

class JornadaController extends Controller
{
    // Muestra el diario de prácticas del alumno logueado
    public function miDiario()
    {
        // Buscamos la candidatura en curso que pertenezca al alumno
        $candidatura = Candidatura::with(['oferta', 'jornadas'])
            ->where('user_id', Auth::id())
            ->where('estado_practicas', 'en_curso')
            ->first();

        // Si no tiene prácticas activas todavía, redirigimos al home con aviso
        if (!$candidatura) {
            return redirect()->route('home')->with('error', 'Aún no tienes ninguna práctica activa en curso asignada por tu tutor.');
        }

        // Sacamos las jornadas ordenadas por fecha reciente
        $jornadas = $candidatura->jornadas()->orderBy('fecha', 'desc')->get();
        $horasRealizadas = $jornadas->sum('horas');

        return view('diario.index', compact('candidatura', 'jornadas', 'horasRealizadas'));
    }

    // Guarda una nueva línea en el diario
    public function registrarJornada(Request $request)
    {
        $request->validate([
            'candidatura_id' => 'required|exists:candidaturas,id',
            'fecha' => 'required|date',
            'horas' => 'required|integer|min:1|max:12',
            'actividad' => 'required|string|max:1000',
            'modalidad' => 'required|in:presencial,telematico',
        ]);

        Jornada::create([
            'candidatura_id' => $request->candidatura_id,
            'fecha' => $request->fecha,
            'horas' => $request->horas,
            'actividad' => $request->actividad,
            'modalidad' => $request->modalidad,
        ]);

        return redirect()->back()->with('success', 'Día registrado correctamente en tu diario.');
    }

    public function descargarPDF()
    {
        // Traemos la candidatura con sus relaciones (oferta y el usuario de la oferta/empresa)
        $candidatura = Candidatura::with(['oferta.user', 'jornadas'])
            ->where('user_id', Auth::id())
            ->where('estado_practicas', 'en_curso')
            ->firstOrFail();

        // Para el PDF oficial, mejor ordenar por fecha antigua a reciente (cronológico)
        $jornadas = $candidatura->jornadas()->orderBy('fecha', 'asc')->get();
        $horasRealizadas = $jornadas->sum('horas');

        // Cargamos la vista y le pasamos los datos
        $pdf = Pdf::loadView('diario.pdf', compact('candidatura', 'jornadas', 'horasRealizadas'));

        // Forzamos la descarga con un nombre de archivo limpio
        $nombreArchivo = 'Diario_Practicas_' . Auth::user()->name . '.pdf';
        return $pdf->download($nombreArchivo);
    }
}