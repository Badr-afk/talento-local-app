<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidatura;
use App\Models\Conversacion;
use Illuminate\Support\Facades\Auth;
use App\Models\Mensaje;
use App\Models\Notificacion; // <- Cargamos el modelo de Notificaciones

class ChatController extends Controller
{
    // Función que se ejecuta al pulsar el botón "Contactar Tutor"
    public function iniciarChat($candidatura_id)
    {
        // 1. Buscamos la candidatura y sacamos los datos del alumno
        $candidatura = Candidatura::with('user')->findOrFail($candidatura_id);
        $alumno = $candidatura->user;

        // 2. Comprobamos si el alumno tiene un profesor/tutor asignado
        if (!$alumno->tutor_id) {
            return redirect()->back()->with('error', 'No se puede iniciar el chat: Este alumno aún no tiene un tutor asignado por el centro educativo.');
        }

        // 3. Buscamos si ya existe un chat previo, si no, lo creamos nuevo
        $conversacion = Conversacion::firstOrCreate([
            'candidatura_id' => $candidatura->id,
            'empresa_id' => Auth::id(),
            'tutor_id' => $alumno->tutor_id
        ]);

        // 4. Redirigimos a la sala de chat
        return redirect()->route('chat.show', $conversacion->id);
    }

    // Muestra la sala de chat y todos sus mensajes
    public function show($id)
    {
        $conversacion = Conversacion::with(['mensajes.remitente', 'empresa', 'tutor', 'candidatura.user'])->findOrFail($id);

        // Seguridad: Solo pueden entrar el tutor o la empresa implicada
        if (Auth::id() !== $conversacion->empresa_id && Auth::id() !== $conversacion->tutor_id) {
            abort(403, 'No tienes permiso para entrar a este chat.');
        }

        return view('chat.show', compact('conversacion'));
    }

    // Guarda el mensaje en la base de datos (AHORA NOTIFICA A LA PARTE CONTRARIA)
    public function enviarMensaje(Request $request, $id)
    {
        $request->validate(['cuerpo' => 'required|string|max:1000']);

        $conversacion = Conversacion::findOrFail($id);

        // Creamos el mensaje en la base de datos
        Mensaje::create([
            'conversacion_id' => $id,
            'user_id' => Auth::id(),
            'cuerpo' => $request->cuerpo
        ]);

        // 👇 LÓGICA INTELIGENTE DE ROLES: Detectamos quién escribe para avisar al contrario 👇
        if (Auth::id() === $conversacion->tutor_id) {
            // Si escribe el Tutor, el receptor es la Empresa
            $receptorId = $conversacion->empresa_id;
            $nombreRemitente = "El Tutor " . Auth::user()->name;
        } else {
            // Si escribe la Empresa, el receptor es el Tutor
            $receptorId = $conversacion->tutor_id;
            $nombreRemitente = "La Empresa " . Auth::user()->name;
        }

        Notificacion::create([
            'user_id' => $receptorId,
            'mensaje' => '💬 ' . $nombreRemitente . ' te ha enviado un mensaje en el chat.',
            'url' => route('chat.show', $id) // Al pulsar, le manda directo a la sala de chat
        ]);
        // 👆 FIN NOTIFICACIÓN DE MENSAJE 👆

        return redirect()->back();
    }

    // Guarda las horas totales acordadas y arranca las prácticas (AHORA NOTIFICA AL ALUMNO)
    public function asignarHoras(Request $request, $id)
    {
        $request->validate([
            'horas_totales' => 'required|integer|min:1|max:1000',
        ]);

        $conversacion = Conversacion::with('candidatura.oferta')->findOrFail($id);

        // Modificamos la candidatura vinculada a este chat
        $candidatura = $conversacion->candidatura;
        $candidatura->update([
            'horas_totales' => $request->horas_totales,
            'estado_practicas' => 'en_curso'
        ]);

        // 👇 NUEVO: SE DISPARA LA NOTIFICACIÓN DIRECTAMENTE AL ALUMNO 👇
        Notificacion::create([
            'user_id' => $candidatura->user_id, // El ID del estudiante
            'mensaje' => '🚀 ¡Buenas noticias! Tu tutor ha activado tus prácticas para la oferta: ' . $candidatura->oferta->titulo . '. ¡Ya puedes rellenar tu diario!',
            'url' => route('home') // Le manda a su panel principal para que acceda al botón del Diario
        ]);
        // 👆 FIN NOTIFICACIÓN AL ALUMNO 👆

        return redirect()->back()->with('success', '¡Horas asignadas y prácticas puestas en curso!');
    }

    // Muestra la lista de chats activos para la Empresa
    public function misChats()
    {
        if (Auth::user()->rol !== 'empresa') {
            abort(403, 'Solo las empresas pueden acceder a esta sección.');
        }

        $chats = Conversacion::with(['tutor', 'candidatura.user', 'candidatura.oferta'])
            ->where('empresa_id', Auth::id())
            ->get();

        return view('empresa.chats', compact('chats'));
    }
    public function actualizarMensajes($id)
    {
        $conversacion = Conversacion::with('mensajes.remitente')->findOrFail($id);
        return view('chat.partials.mensajes', compact('conversacion'));
    }
}
