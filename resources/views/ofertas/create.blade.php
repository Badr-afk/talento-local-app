@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 40px auto; padding: 0 20px;">
    <div class="card animate-fade-up">
        <h2 style="color: var(--primary-color); margin-bottom: 20px;">Publicar Nueva Oferta</h2>
        
        <form action="{{ route('ofertas.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; margin-bottom: 5px; color: var(--text-main);">Título de la oferta:</label>
                <input type="text" name="titulo" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-size: 14px; margin-bottom: 5px; color: var(--text-main);">Grado Requerido:</label>
                    <input type="text" name="grado_requerido" placeholder="Ej: 2º DAW" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 14px; margin-bottom: 5px; color: var(--text-main);">Alumnos necesarios (Vacantes):</label>
                    <input type="number" name="vacantes" min="1" value="1" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; box-sizing: border-box;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; margin-bottom: 5px; color: var(--text-main);">Descripción del proyecto:</label>
                <textarea name="descripcion" rows="5" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; resize: none; box-sizing: border-box;"></textarea>
            </div>

            <button type="submit" class="btn" style="width: 100%;">Publicar Oferta</button>
        </form>
    </div>
</div>
@endsection