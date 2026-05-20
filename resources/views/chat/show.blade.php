@extends('layouts.app')

@section('content')
<style>
    .chat-fila { display: flex; flex-direction: column; margin-bottom: 15px; }
    .chat-mio { align-items: flex-end; }
    .chat-suyo { align-items: flex-start; }
    
    .chat-burbuja {
        max-width: 75%;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.5;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .burbuja-mia {
        background-color: var(--primary-color);
        color: #ffffff;
        border-bottom-right-radius: 2px;
    }
    .burbuja-suya {
        background-color: #ffffff;
        color: var(--text-main);
        border: 1px solid var(--border-color);
        border-bottom-left-radius: 2px;
    }
    
    /* Contenedor principal del chat */
    .chat-container {
        height: 65vh; /* Ocupa el 65% del alto de la pantalla */
        min-height: 400px;
        display: flex;
        flex-direction: column;
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    /* Zona donde van los mensajes */
    .chat-messages {
        flex-grow: 1; /* Ocupa todo el espacio sobrante */
        padding: 20px;
        overflow-y: auto; /* Permite hacer scroll */
        background-color: #f8fafc;
    }
    
    /* Zona de la caja de texto (Anclada abajo) */
    .chat-input-area {
        padding: 15px 20px;
        background: #ffffff;
        border-top: 1px solid var(--border-color);
    }
</style>

<div style="max-width: 900px; margin: 30px auto; padding: 0 20px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="margin: 0 0 5px 0; color: var(--text-main); font-size: 22px;">Sala de Coordinación</h2>
            <p style="margin: 0; color: var(--text-muted); font-size: 14px;">
                Alumno: <strong>{{ $conversacion->candidatura->user->name ?? 'Desconocido' }}</strong> | 
                Oferta: <strong>{{ $conversacion->candidatura->oferta->titulo ?? 'Prácticas' }}</strong>
            </p>
        </div>
        
        <div style="display: flex; gap: 10px; align-items: center;">
            @if(Auth::user()->rol === 'tutor_academico' && $conversacion->candidatura->estado_practicas === 'pendiente')
                <form action="{{ route('chat.asignarHoras', $conversacion->id) }}" method="POST" style="display: flex; gap: 10px; align-items: center; background: #f0fdf4; padding: 8px 12px; border-radius: 8px; border: 1px solid #bbf7d0;">
                    @csrf
                    <label style="font-size: 13px; font-weight: 600; color: #166534;">Asignar Horas:</label>
                    <input type="number" name="horas_totales" placeholder="Ej: 370" required style="width: 80px; padding: 6px; border: 1px solid #bbf7d0; border-radius: 4px; font-size: 13px;">
                    <button type="submit" class="btn" style="padding: 6px 12px; font-size: 12px; background-color: #10b981;">Activar</button>
                </form>
            @endif
            <a href="{{ Auth::user()->rol === 'empresa' ? route('empresa.chats') : route('tutor.alumnos') }}" class="btn-volver">Volver al panel</a>
        </div>
    </div>

    <div class="chat-container">
        
        <div class="chat-messages" id="caja-mensajes">
            @if($conversacion->mensajes->isEmpty())
                <div style="text-align: center; color: var(--text-muted); margin-top: 50px;">
                    <p>¡Sala creada! Escribe el primer mensaje para coordinar las prácticas.</p>
                </div>
            @else
                @foreach($conversacion->mensajes as $mensaje)
                    @php $esMio = $mensaje->user_id === Auth::id(); @endphp
                    <div class="chat-fila {{ $esMio ? 'chat-mio' : 'chat-suyo' }}">
                        <span style="font-size: 11px; color: var(--text-muted); margin-bottom: 4px; font-weight: 600;">
                            {{ $mensaje->remitente->name }} - {{ $mensaje->created_at->format('H:i') }}
                        </span>
                        <div class="chat-burbuja {{ $esMio ? 'burbuja-mia' : 'burbuja-suya' }}">
                            {{ $mensaje->cuerpo }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="chat-input-area">
            <form action="{{ route('chat.mensaje', $conversacion->id) }}" method="POST" style="display: flex; gap: 10px;">
                @csrf
                <input type="text" name="cuerpo" placeholder="Escribe tu mensaje aquí..." required class="form-input" style="border-radius: 20px; padding-left: 20px; border-color: var(--border-color);">
                <button type="submit" class="btn" style="border-radius: 20px; padding: 10px 25px;">
                    Enviar ➔
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    // Script para que al entrar al chat, la vista baje automáticamente hasta el último mensaje
    window.onload = function() {
        var cajaMensajes = document.getElementById('caja-mensajes');
        cajaMensajes.scrollTop = cajaMensajes.scrollHeight;
    }
</script>
@endsection