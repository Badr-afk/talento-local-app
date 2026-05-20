@extends('layouts.app')

@section('content')
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="card animate-fade-up" style="text-align: center; max-width: 500px; width: 100%; border-top: 5px solid var(--primary-color);">

        <div style="font-size: 80px; font-weight: 900; color: var(--primary-color); line-height: 1; margin-bottom: 10px;">
            404
        </div>

        <h2 style="color: var(--text-main); margin: 0 0 15px 0;">¡Vaya! Te has salido del mapa</h2>

        <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: 30px;">
            La página o la oferta de prácticas que estás buscando no existe, ha sido eliminada o nunca estuvo aquí.
        </p>

        <a href="{{ url('/') }}" class="btn" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 25px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Volver al Tablón Principal
        </a>
    </div>
</div>
@endsection