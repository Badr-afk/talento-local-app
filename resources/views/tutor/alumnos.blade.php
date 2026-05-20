@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="color: var(--primary-color);">Panel de Tutoría</h1>
        <a href="{{ route('home') }}" class="btn btn-outline">&larr; Volver al Panel</a>
    </div>

    <div class="card animate-fade-up" style="margin-bottom: 30px; border-top: 4px solid #10b981;">
        <h3 style="margin-bottom: 15px; color: #10b981;">Mis Alumnos Asignados</h3>
        
        @if($misAlumnos->isEmpty())
            <p style="color: var(--text-muted); text-align: center; padding: 20px 0;">Aún no tienes alumnos a tu cargo.</p>
        @else
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <tr>
                    <th style="padding: 10px;">Nombre</th>
                    <th style="padding: 10px;">Email</th>
                    <th style="padding: 10px;">Estado</th>
                </tr>
                @foreach($misAlumnos as $alumno)
                <tr>
                    <td style="padding: 10px; font-weight: bold;">{{ $alumno->name }}</td>
                    <td style="padding: 10px; color: var(--text-muted);">{{ $alumno->email }}</td>
                    <td style="padding: 10px;"><span style="color: #10b981; font-weight: bold;">✓ Tutorizado</span></td>
                </tr>
                @endforeach
            </table>
        @endif
    </div>

    <div class="card animate-fade-up delay-1" style="border-top: 4px solid var(--accent-color); margin-bottom: 30px;">
        <h3 style="margin-bottom: 15px; color: var(--accent-color);">Alumnos Libres (Sin Tutor)</h3>
        
        @if($alumnosLibres->isEmpty())
            <p style="color: var(--text-muted); text-align: center; padding: 20px 0;">Todos los alumnos ya tienen un tutor asignado.</p>
        @else
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <tr>
                    <th style="padding: 10px;">Nombre</th>
                    <th style="padding: 10px;">Email</th>
                    <th style="padding: 10px;">Acción</th>
                </tr>
                @foreach($alumnosLibres as $libre)
                <tr>
                    <td style="padding: 10px; font-weight: bold;">{{ $libre->name }}</td>
                    <td style="padding: 10px; color: var(--text-muted);">{{ $libre->email }}</td>
                    <td style="padding: 10px;">
                        <form action="{{ route('tutor.asignar', $libre->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn" style="border-color: var(--accent-color); color: var(--accent-color);">
                                Asignarme
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        @endif
    </div>

    <div class="card animate-fade-up delay-2" style="border-top: 4px solid var(--primary-color);">
        <h3 style="margin-bottom: 15px; color: var(--primary-color);">Chats Activos con Empresas</h3>
        
        @if($chats->isEmpty())
            <p style="color: var(--text-muted); text-align: center; padding: 20px 0;">No tienes chats de coordinación abiertos con ninguna empresa.</p>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <tr>
                        <th style="padding: 10px;">Alumno</th>
                        <th style="padding: 10px;">Empresa</th>
                        <th style="padding: 10px;">Oferta</th>
                        <th style="padding: 10px;">Acción</th>
                    </tr>
                    @foreach($chats as $chat)
                    <tr>
                        <td style="padding: 10px; font-weight: bold;">{{ $chat->candidatura->user->name }}</td>
                        <td style="padding: 10px; color: var(--text-muted);">{{ $chat->empresa->name }}</td>
                        <td style="padding: 10px; color: var(--text-muted); font-size: 14px;">{{ $chat->candidatura->oferta->titulo ?? 'Prácticas' }}</td>
                        <td style="padding: 10px;">
                            <a href="{{ route('chat.show', $chat->id) }}" class="btn">
                                Abrir Chat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </div>

</div>
@endsection