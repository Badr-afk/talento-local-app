<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Candidatura;
use Illuminate\Support\Facades\Auth;

class OfertaController extends Controller
{
    // 1. Muestra el tablón de anuncios (ahora con buscador)
    public function index(Request $request)
    {
        // Iniciamos la consulta base
        $query = Oferta::query();

        // Si el usuario ha escrito algo en el buscador...
        if ($request->filled('buscar')) {
            $termino = $request->input('buscar');

            // Filtramos por título, descripción o grado
            $query->where(function ($q) use ($termino) {
                $q->where('titulo', 'LIKE', "%{$termino}%")
                    ->orWhere('descripcion', 'LIKE', "%{$termino}%")
                    ->orWhere('grado_requerido', 'LIKE', "%{$termino}%");
            });
        }

        // Ejecutamos la consulta, ordenando por las más recientes
        $ofertas = $query->latest()->get();

        return view('ofertas.index', compact('ofertas'));
    }

    // 2. Muestra el formulario para crear una nueva oferta
    public function create()
    {
        return view('ofertas.create');
    }

    // 3. Guarda la oferta en la base de datos - ACTUALIZADO CON VACANTES
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'grado_requerido' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'vacantes' => 'required|integer|min:1', // Validamos que el número de plazas sea mínimo 1
        ]);

        Oferta::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'grado_requerido' => $request->grado_requerido,
            'descripcion' => $request->descripcion,
            'vacantes' => $request->vacantes, // Guardamos la cantidad de vacantes
            'estado' => true
        ]);

        return redirect()->route('home')->with('success', '¡Oferta publicada correctamente!');
    }

    // 4. Muestra el detalle de una oferta específica
    public function show($id)
    {
        $oferta = Oferta::findOrFail($id);
        return view('ofertas.show', compact('oferta'));
    }

    // 5. Muestra solo las ofertas de la empresa logueada
    public function misOfertas()
    {
        $ofertas = Oferta::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('ofertas.propias', compact('ofertas'));
    }

    // 6. Procesa la inscripción de un estudiante a una oferta
    public function inscribir(Request $request, $id)
    {
        // Regla de seguridad del tutor
        if (Auth::user()->rol === 'estudiante' && is_null(Auth::user()->tutor_id)) {
            return redirect()->back()->with('error', 'SYS_ERR: No puedes inscribirte a ninguna oferta hasta que tengas un tutor académico asignado.');
        }

        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $existe = Candidatura::where('user_id', Auth::id())->where('oferta_id', $id)->first();

        if (!$existe) {
            $path = $request->file('cv')->store('cvs', 'public');

            Candidatura::create([
                'user_id' => Auth::id(),
                'oferta_id' => $id,
                'cv_path' => $path
            ]);

            // 👇 ESTO ERA LO QUE FALTABA: LA CREACIÓN DE LA NOTIFICACIÓN 👇
            $oferta = Oferta::findOrFail($id);
            \App\Models\Notificacion::create([
                'user_id' => $oferta->user_id, // El dueño de la oferta (La Empresa)
                'mensaje' => Auth::user()->name . ' se ha inscrito en tu oferta: ' . $oferta->titulo,
                'url' => route('ofertas.propias') // Al hacer clic, le llevará a sus ofertas
            ]);
            // 👆 FIN NOTIFICACIÓN 👆

            // Ahora te saca directamente al tablón de anuncios con el mensaje
            return redirect()->route('ofertas.index')->with('success', '¡Te has inscrito correctamente en la oferta y hemos enviado tu CV!');
        }

        // Si por alguna razón ya existía, también te saca al tablón
        return redirect()->route('ofertas.index')->with('success', 'Ya estabas inscrito en esta oferta.');
    }

    // 7. Muestra los candidatos inscritos a una oferta
    public function verCandidatos($id)
    {
        $oferta = Oferta::findOrFail($id);

        // Control de seguridad: Evita que una empresa cotillee las ofertas de otra
        if ($oferta->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver estos candidatos.');
        }

        // Recuperamos las candidaturas de esta oferta trayendo también los datos del alumno
        $candidaturas = Candidatura::where('oferta_id', $id)->with('user')->get();

        return view('ofertas.candidatos', compact('oferta', 'candidaturas'));
    }
}