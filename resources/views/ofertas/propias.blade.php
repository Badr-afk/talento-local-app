@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="color: var(--primary-color);">Mis Ofertas Publicadas</h1>
        <a href="{{ route('home') }}" class="btn btn-outline">&larr; Volver al Panel</a>
    </div>

    @if($ofertas->isEmpty())
    <div class="card animate-fade-up" style="text-align: center; padding: 50px;">
        <h3 style="color: var(--text-muted);">Aún no has publicado ninguna oferta.</h3>
        <a href="{{ route('ofertas.create') }}" class="btn" style="margin-top: 15px;">Crear mi primera oferta</a>
    </div>
    @else
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px;">
        @foreach($ofertas as $oferta)
        <div class="card animate-fade-up" style="border-left: 5px solid var(--accent-color);">
            <h3 style="margin-bottom: 10px; color: var(--primary-color);">{{ $oferta->titulo }}</h3>
            <p style="font-size: 14px; margin-bottom: 15px; background: #f3f4f6; padding: 5px 10px; border-radius: 5px; display: inline-block;">
                🎓 {{ $oferta->grado_requerido }}
            </p>
            <p style="color: var(--text-muted); margin-bottom: 20px;">
                {{ Str::limit($oferta->descripcion, 80, '...') }}
            </p>
            
            <div style="border-top: 1px solid var(--border-color); padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('ofertas.show', $oferta->id) }}" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">Ver anuncio completo</a>
                
                <a href="{{ route('ofertas.candidatos', $oferta->id) }}" class="btn" style="padding: 6px 15px; font-size: 14px; background-color: var(--primary-color);">Ver Candidatos</a>
            </div>
            </div>
        @endforeach
    </div>
    @endif

</div>
@endsection