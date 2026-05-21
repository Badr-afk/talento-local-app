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
            @include('chat.partials.mensajes')
        </div>

        <div class="chat-input-area">
            <form action="{{ route('chat.mensaje', $conversacion->id) }}" method="POST" style="display: flex; gap: 10px;" id="form-mensaje">
                @csrf
                <input type="text" name="cuerpo" id="input-mensaje" placeholder="Escribe tu mensaje aquí..." required class="form-input" style="border-radius: 20px; padding-left: 20px; border-color: var(--border-color); flex-grow: 1;">
                <button type="submit" class="btn" style="border-radius: 20px; padding: 10px 25px;">
                    Enviar ➔
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    // Variable para controlar si el usuario ha hecho scroll hacia arriba
    let usuarioHizoScroll = false;
    const cajaMensajes = document.getElementById('caja-mensajes');

    // Función para bajar al último mensaje
    function scrollAlFondo() {
        if (!usuarioHizoScroll) {
            cajaMensajes.scrollTop = cajaMensajes.scrollHeight;
        }
    }

    // Detectar si el usuario mueve el scroll hacia arriba
    cajaMensajes.addEventListener('scroll', function() {
        // Si está a más de 50px del fondo, consideramos que está leyendo mensajes antiguos
        const distanciaAlFondo = cajaMensajes.scrollHeight - cajaMensajes.scrollTop - cajaMensajes.clientHeight;
        usuarioHizoScroll = distanciaAlFondo > 50;
    });

    window.onload = function() {
        scrollAlFondo();
    }

    // ACTUALIZACIÓN EN TIEMPO REAL (AJAX Polling)
    setInterval(function() {
        fetch("{{ route('chat.actualizar', $conversacion->id) }}")
            .then(response => {
                if (!response.ok) throw new Error('Error de red');
                return response.text();
            })
            .then(html => {
                // Comprobamos si hay mensajes nuevos (si el HTML ha cambiado)
                if(cajaMensajes.innerHTML !== html) {
                    cajaMensajes.innerHTML = html;
                    // Solo hacemos auto-scroll si el usuario no estaba leyendo arriba
                    scrollAlFondo();
                }
            })
            .catch(error => console.error('Error al actualizar chat:', error));
    }, 3000); // Se actualiza cada 3 segundos

    // Envío por AJAX (Opcional, para que ni siquiera recargue al enviar)
    document.getElementById('form-mensaje').addEventListener('submit', function(e) {
        e.preventDefault(); // Evitamos que el formulario recargue la página
        
        const form = this;
        const input = document.getElementById('input-mensaje');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(() => {
            input.value = ''; // Limpiamos la caja de texto
            // Forzamos una actualización inmediata
            fetch("{{ route('chat.actualizar', $conversacion->id) }}")
                .then(response => response.text())
                .then(html => {
                    cajaMensajes.innerHTML = html;
                    usuarioHizoScroll = false; // Reseteamos
                    scrollAlFondo();
                });
        });
    });
</script>
@endsection