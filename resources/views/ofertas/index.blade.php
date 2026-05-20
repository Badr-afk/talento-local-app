@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="color: var(--primary-color);">Tablón de Prácticas</h1>
        @if(Auth::user()->rol === 'empresa')
        <a href="{{ route('ofertas.create') }}" class="btn">Nueva Oferta</a>
        @endif
    </div>

    <form action="{{ route('ofertas.index') }}" method="GET" style="margin-bottom: 30px; display: flex; gap: 10px; flex-wrap: wrap;">
        <div style="flex-grow: 1; position: relative;">
            <span style="position: absolute; left: 15px; top: 14px; color: var(--text-muted);">🔍</span>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por tecnología, título o grado (Ej: DAW, PHP, Frontend...)"
                style="width: 100%; padding: 14px 14px 14px 45px; border: 1px solid var(--border-color); border-radius: 8px; background: #ffffff; box-sizing: border-box; font-size: 15px; transition: all 0.2s; outline: none;"
                onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(37, 99, 235, 0.1)';"
                onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none';">
        </div>
        <button type="submit" class="btn" style="padding: 14px 25px; border-radius: 8px;">
            Buscar
        </button>

        @if(request('buscar'))
        <a href="{{ route('ofertas.index') }}" class="btn btn-outline" style="padding: 14px 25px; border-radius: 8px; text-decoration: none; display: flex; align-items: center;">
            Limpiar
        </a>
        @endif
    </form>
    ```

    Guarda ambos archivos. Ve a tu tablón de anuncios y escribe algo en la barra, como "DAW" o "Frontend" (asegúrate de tener ofertas publicadas con esas palabras).

    Verás que el tablón se filtra en tiempo real y, si le das al botón de "Limpiar", vuelve a mostrar todo el catálogo.

    Cuando verifiques que el buscador va fino como la seda, me das luz verde y saltamos a la **Opción B (Generación de PDFs del diario)**, para la cual tendremos que instalar un paquete nuevo en la consola. ¿Funciona bien el filtro?

    @if($ofertas->isEmpty())
    <div class="card animate-fade-up" style="text-align: center; padding: 50px;">
        <h3 style="color: var(--text-muted);">Aún no hay ofertas de prácticas publicadas.</h3>
        <p>¡Vuelve más tarde para descubrir nuevas oportunidades!</p>
    </div>
    @else
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px;">
        @foreach($ofertas as $oferta)
        <div class="card animate-fade-up delay-1" style="border-left: 5px solid var(--primary-color); display: flex; flex-direction: column;">
            <div style="flex-grow: 1;">
                <h3 style="margin-bottom: 10px; color: var(--text-main);">{{ $oferta->titulo }}</h3>

                <p style="font-size: 14px; margin-bottom: 15px; background: #f8fafc; border: 1px solid var(--border-color); padding: 5px 10px; border-radius: 5px; display: inline-block; color: var(--text-main);">
                    <strong>Buscamos:</strong> {{ $oferta->grado_requerido }}
                </p>

                <p style="color: var(--text-muted); margin-bottom: 20px; font-size: 14px; line-height: 1.5;">
                    {{ Str::limit($oferta->descripcion, 100, '...') }}
                </p>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 13px; color: var(--text-muted);">
                    Por: <strong>{{ $oferta->user->name }}</strong>
                </span>

                @auth
                @if(Auth::user()->rol === 'estudiante' && $oferta->candidaturas->contains('user_id', Auth::id()))
                <span style="padding: 6px 12px; background-color: #f0fdf4; color: #10b981; border: 1px solid #10b981; border-radius: 6px; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 5px; cursor: default;">
                    ✓ INSCRITO
                </span>
                @else
                <a href="{{ route('ofertas.show', $oferta->id) }}" style="color: var(--primary-color); font-weight: 600; font-size: 14px; text-decoration: none;">
                    Ver detalles &rarr;
                </a>
                @endif
                @else
                <a href="{{ route('ofertas.show', $oferta->id) }}" style="color: var(--primary-color); font-weight: 600; font-size: 14px; text-decoration: none;">
                    Ver detalles &rarr;
                </a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection