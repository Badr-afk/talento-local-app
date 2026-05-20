@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
    
    <div class="card animate-fade-up">
        <h1 style="color: var(--primary-color); margin-bottom: 5px;">Bandeja de Coordinación</h1>
        <p style="color: var(--text-muted); margin-bottom: 25px;">Aquí puedes comunicarte con los tutores académicos de los alumnos que has seleccionado.</p>

        @if($chats->isEmpty())
            <div style="text-align: center; padding: 30px; color: var(--text-muted);">
                <p style="font-size: 16px;">Aún no tienes chats abiertos. Selecciona a un candidato de tus ofertas para iniciar uno.</p>
                <a href="{{ route('ofertas.propias') }}" class="btn" style="margin-top: 15px;">Ver mis ofertas</a>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr>
                            <th>Alumno Seleccionado</th>
                            <th>Tutor Académico</th>
                            <th>Proyecto / Oferta</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chats as $chat)
                            <tr>
                                <td style="font-weight: bold;">{{ $chat->candidatura->user->name }}</td>
                                <td style="color: var(--text-muted);">
                                    {{ $chat->tutor ? $chat->tutor->name : 'Sin tutor asignado' }}
                                </td>
                                <td>
                                    <span style="font-size: 13px; background: #f1f5f9; padding: 4px 8px; border-radius: 4px; border: 1px solid var(--border-color);">
                                        {{ $chat->candidatura->oferta->titulo ?? 'Prácticas' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('chat.show', $chat->id) }}" class="btn" style="padding: 6px 12px; font-size: 13px;">
                                        Abrir Chat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
