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