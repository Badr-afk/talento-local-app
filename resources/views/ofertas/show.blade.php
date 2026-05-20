@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 40px auto; padding: 0 20px;">

    <div class="card animate-fade-up">

        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px;">
            <div>
                <h1 style="color: var(--text-main); margin: 0 0 10px 0; font-size: 28px; font-weight: 800;">{{ $oferta->titulo }}</h1>
                <span style="font-size: 14px; color: var(--text-muted); display: flex; align-items: center; gap: 5px;">
                    🕒 Publicado {{ $oferta->created_at->diffForHumans() }}
                </span>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid var(--border-color);">
            <div>
                <p style="margin: 0; font-size: 12px; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">EMPRESA</p>
                <p style="margin: 0; font-size: 15px; font-weight: 600; color: var(--text-main);">🏢 {{ $oferta->user->name }}</p>
            </div>
            <div>
                <p style="margin: 0; font-size: 12px; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">PERFIL BUSCADO</p>
                <p style="margin: 0; font-size: 15px; font-weight: 600; color: var(--text-main);">🎓 {{ $oferta->grado_requerido }}</p>
            </div>
        </div>

        <h3 style="margin: 0 0 15px 0; color: var(--text-main); font-size: 18px;">Descripción del Proyecto</h3>
        <p style="line-height: 1.7; color: #475569; margin-bottom: 40px; white-space: pre-line; font-size: 15px;">
            {{ $oferta->descripcion }}
        </p>

        @auth
        @if(Auth::user()->rol === 'estudiante')
        <div style="border-top: 1px solid var(--border-color); padding-top: 30px; margin-top: 20px;">

            @if($oferta->candidaturas->contains('user_id', Auth::id()))
            <div style="background-color: #f0fdf4; border: 1px solid #10b981; padding: 20px; border-radius: 8px; text-align: center;">
                <span style="font-size: 24px; color: #10b981; display: block; margin-bottom: 10px;">✓</span>
                <h3 style="color: #065f46; margin: 0 0 5px 0;">¡Ya estás inscrito en esta oferta!</h3>
                <p style="color: #047857; margin: 0; font-size: 14px;">Tu currículum ha sido enviado a la empresa. Te avisaremos si hay novedades.</p>
            </div>
            @else
            <form action="{{ route('ofertas.inscribir', $oferta->id) }}" method="POST" enctype="multipart/form-data" style="background: #f8fafc; border: 1px solid var(--border-color); padding: 25px; border-radius: 8px;">
                @csrf

                <h3 style="margin: 0 0 20px 0; color: var(--text-main); font-size: 18px; text-align: center;">¿Te interesa? ¡Inscríbete!</h3>

                <div style="margin-bottom: 20px;">
                    <label for="cv" style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 8px; color: var(--text-main);">Adjuntar Currículum Vitae (PDF o Word)</label>
                    <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx" required
                        style="width: 100%; padding: 10px; border: 1px dashed var(--primary-color); border-radius: 6px; background: white; cursor: pointer;">

                    @error('cv')
                    <span style="color: #ef4444; font-size: 13px; margin-top: 8px; display: block; font-weight: 600;">⚠ {{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 14px; font-size: 16px; border-radius: 8px;">
                    Enviar Candidatura
                </button>
            </form>
            @endif
        </div>
        @endif
        @endauth
    </div>

</div>
@endsection