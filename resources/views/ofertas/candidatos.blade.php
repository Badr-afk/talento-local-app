@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">

    <a href="{{ route('ofertas.propias') }}" style="color: var(--text-muted); text-decoration: none; font-weight: bold; display: inline-block; margin-bottom: 20px;">
        &larr; Volver a mis ofertas
    </a>

    <div class="card animate-fade-up">
        <h1 style="color: var(--primary-color); margin-bottom: 5px;">Alumnos Inscritos</h1>
        <p style="color: var(--text-muted); margin-bottom: 25px;">Oferta: <strong>{{ $oferta->titulo }}</strong></p>

        @if($candidaturas->isEmpty())
        <div style="text-align: center; padding: 30px; color: var(--text-muted);">
            <p style="font-size: 16px;">Aún no se ha inscrito ningún alumno en esta oferta.</p>
        </div>
        @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color); background-color: #f9fafb;">
                        <th style="padding: 12px; color: #374151;">Nombre del Alumno</th>
                        <th style="padding: 12px; color: #374151;">Email de Contacto</th>
                        <th style="padding: 12px; color: #374151;">Documentación</th>
                        <th style="padding: 12px; color: #374151;">Fecha</th>
                        <th style="padding: 12px; color: #374151;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidaturas as $candidatura)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 12px; font-weight: bold; color: #111827;">{{ $candidatura->user->name }}</td>
                        <td style="padding: 12px; color: #4b5563;">{{ $candidatura->user->email }}</td>
                        <td style="padding: 12px;">
                            @if($candidatura->cv_path)
                            <a href="{{ asset('storage/' . $candidatura->cv_path) }}" target="_blank" style="color: #10b981; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                📄 Ver Currículum
                            </a>
                            @else
                            <span style="color: var(--text-muted);">Sin documento</span>
                            @endif
                        </td>
                        <td style="padding: 12px; color: var(--text-muted); font-size: 14px;">
                            {{ $candidatura->created_at->format('d/m/Y') }}
                        </td>
                        <td style="padding: 12px;">
                            <form action="{{ route('chat.iniciar', $candidatura->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="background-color: var(--primary-color); padding: 8px 12px; font-size: 13px; border: none; cursor: pointer; color: white; border-radius: 5px;">
                                    Contactar Tutor
                                </button>
                            </form>
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