@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 50px auto; padding: 0 20px;">

    <div class="card animate-fade-up">
        <h1 style="color: var(--primary-color); margin-bottom: 10px;">Panel de Control</h1>
        
        <p style="color: var(--text-main); font-size: 16px;">Bienvenido, <strong>{{ Auth::user()->name }}</strong>.
            Has iniciado sesión como <span style="color: var(--accent-color); font-weight: bold; text-transform: uppercase;">{{ Auth::user()->rol }}</span>.
        </p>

        @if(session('error'))
            <div style="margin-top: 15px; padding: 12px; background-color: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; border-radius: 4px;">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-top: 30px;">

        @if(Auth::user()->rol === 'empresa')
        <div class="card animate-fade-up delay-1" style="border-top: 4px solid var(--primary-color);">
            <h3 style="margin-bottom: 15px; color: var(--primary-color);">Publicar Anuncio</h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Crea una nueva oferta de prácticas para encontrar talento local para tu negocio.</p>
            <a href="{{ route('ofertas.create') }}" class="btn" style="width: 100%; box-sizing: border-box;">Crear Oferta</a>
        </div>

        <div class="card animate-fade-up delay-2" style="border-top: 4px solid var(--accent-color);">
            <h3 style="margin-bottom: 15px; color: var(--accent-color);">Mis Ofertas Activas</h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Gestiona los anuncios que ya has publicado y revisa a los candidatos inscritos.</p>
            <a href="{{ route('ofertas.propias') }}" class="btn btn-outline" style="width: 100%; box-sizing: border-box; text-align: center;">Ver mis ofertas</a>
        </div>

        <div class="card animate-fade-up delay-2" style="border-top: 4px solid var(--success-color);">
            <h3 style="margin-bottom: 15px; color: var(--success-color);">Mensajes y Coordinación</h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Comunícate con los tutores de los alumnos para acordar las horas y el plan de trabajo.</p>
            <a href="{{ route('empresa.chats') }}" class="btn" style="width: 100%; box-sizing: border-box; background-color: var(--success-color);">
                Ver mis chats
            </a>
        </div>

        @elseif(Auth::user()->rol === 'estudiante')
        <div class="card animate-fade-up delay-1" style="border-top: 4px solid var(--primary-color);">
            <h3 style="margin-bottom: 15px; color: var(--primary-color);">Buscar Prácticas</h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Explora el tablón de anuncios y encuentra el proyecto perfecto para tu especialidad.</p>
            <a href="{{ route('ofertas.index') }}" class="btn" style="width: 100%; box-sizing: border-box;">Ver Tablón de Anuncios</a>
        </div>

        <div class="card animate-fade-up delay-2" style="border-top: 4px solid var(--success-color);">
            <h3 style="margin-bottom: 15px; color: var(--success-color);">Mis Prácticas</h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Haz seguimiento de tus horas, rellena el diario de clase y revisa el estado de tus proyectos.</p>
            <a href="{{ route('diario.index') }}" class="btn" style="width: 100%; box-sizing: border-box; background-color: var(--success-color);">
                Mi Diario de Prácticas
            </a>
        </div>
        
        @elseif(Auth::user()->rol === 'tutor_academico')
        <div class="card animate-fade-up delay-1" style="border-top: 4px solid var(--primary-color);">
            <h3 style="margin-bottom: 15px; color: var(--primary-color);">Mis Alumnos</h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Haz seguimiento de los estudiantes que tienes asignados y valida sus prácticas.</p>
            <a href="{{ route('tutor.alumnos') }}" class="btn" style="width: 100%; box-sizing: border-box;">Ver Alumnos</a>
        </div>
        @endif

        <div class="card animate-fade-up delay-2" style="border-top: 4px solid var(--border-color);">
            <h3 style="margin-bottom: 15px; color: var(--text-main);">Mi Perfil</h3>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Actualiza tu información personal, contraseña y datos de contacto.</p>
            <a href="{{ route('perfil.edit') }}" class="btn btn-outline" style="width: 100%; box-sizing: border-box; text-align: center;">Editar Perfil</a>
        </div>

    </div>
</div>
@endsection