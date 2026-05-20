@extends('layouts.app')

@section('content')

<style>
    /* Estilos adaptados al nuevo diseño claro SaaS */
    .input-diario {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border-color);
        background-color: #f8fafc; /* Fondo clarito */
        color: var(--text-main) !important; /* Texto oscuro */
        border-radius: 6px;
        box-sizing: border-box;
        font-family: inherit;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    .input-diario:focus {
        outline: none;
        border-color: var(--primary-color);
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
</style>

<div style="max-width: 1100px; margin: 40px auto; padding: 0 20px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 style="color: var(--text-main); margin: 0; font-size: 24px;">Registro Diario de Actividades</h1>
            <p style="color: var(--text-muted); margin: 5px 0 0 0;">Proyecto: <strong>{{ $candidatura->oferta->titulo ?? 'Prácticas' }}</strong></p>
        </div>
        
        <div style="display: flex; gap: 15px; align-items: center;">
            <a href="{{ route('home') }}" class="btn-volver">&larr; Volver al Panel</a>
            
            <a href="{{ route('diario.pdf') }}" class="btn" style="background-color: #ef4444; display: flex; align-items: center; gap: 8px; padding: 10px 15px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Descargar en PDF
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 35px;">
        <div class="card" style="text-align: center; border-left: 4px solid var(--primary-color);">
            <h4 style="margin: 0; color: var(--text-muted); text-transform: uppercase; font-size: 12px;">Horas Totales Requeridas</h4>
            <p style="font-size: 32px; font-weight: bold; margin: 10px 0 0 0; color: var(--text-main);">{{ $candidatura->horas_totales }} h</p>
        </div>
        <div class="card" style="text-align: center; border-left: 4px solid #10b981;">
            <h4 style="margin: 0; color: var(--text-muted); text-transform: uppercase; font-size: 12px;">Horas Completadas</h4>
            <p style="font-size: 32px; font-weight: bold; margin: 10px 0 0 0; color: #10b981;">{{ $horasRealizadas }} h</p>
        </div>
        <div class="card" style="text-align: center; border-left: 4px solid var(--accent-color);">
            <h4 style="margin: 0; color: var(--text-muted); text-transform: uppercase; font-size: 12px;">Horas Restantes</h4>
            <p style="font-size: 32px; font-weight: bold; margin: 10px 0 0 0; color: var(--accent-color);">
                {{ max(0, $candidatura->horas_totales - $horasRealizadas) }} h
            </p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; @media(max-width: 800px){grid-template-columns: 1fr;}">
        
        <div class="card" style="height: fit-content; border-top: 4px solid var(--primary-color);">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">Fichar Nueva Jornada</h3>
            
            <form action="{{ route('jornada.registrar') }}" method="POST">
                @csrf
                <input type="hidden" name="candidatura_id" value="{{ $candidatura->id }}">

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 5px;">Fecha:</label>
                    <input type="date" name="fecha" value="{{ date('Y-m-d') }}" required class="input-diario">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 5px;">Horas Dedicadas:</label>
                    <input type="number" name="horas" min="1" max="12" placeholder="Ej: 4" required class="input-diario">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 5px;">Modalidad:</label>
                    <select name="modalidad" required class="input-diario" style="cursor: pointer;">
                        <option value="presencial">🏢 Presencial</option>
                        <option value="telematico">🏠 Telemático (Remoto)</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 5px;">Tareas Realizadas:</label>
                    <textarea name="actividad" rows="4" placeholder="Describe brevemente qué has hecho hoy..." required class="input-diario" style="resize: none;"></textarea>
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 12px;">Guardar Entrada</button>
            </form>
        </div>

        <div class="card" style="border-top: 4px solid var(--success-color);">
            <h3 style="margin-bottom: 20px; color: var(--success-color);">Historial de Actividades</h3>

            @if($jornadas->isEmpty())
                <p style="color: var(--text-muted); text-align: center; padding: 40px 0;">Aún no has registrado ninguna jornada de trabajo.</p>
            @else
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    @foreach($jornadas as $j)
                        <div style="padding: 15px; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; flex-wrap: wrap; gap: 5px;">
                                <strong style="color: var(--primary-color);">📅 {{ \Carbon\Carbon::parse($j->fecha)->format('d/m/Y') }}</strong>
                                <span style="font-size: 13px; background: #ffffff; padding: 3px 8px; border-radius: 4px; border: 1px solid var(--border-color); color: var(--text-main);">
                                    {{ $j->modalidad === 'presencial' ? '🏢 Presencial' : '🏠 Telemático' }}
                                </span>
                                <span style="color: #10b981; font-weight: bold;">⏱ {{ $j->horas }} horas</span>
                            </div>
                            <p style="margin: 0; font-size: 14px; color: var(--text-main); white-space: pre-line; line-height: 1.5;">
                                {{ $j->actividad }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection