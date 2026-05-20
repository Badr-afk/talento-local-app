@extends('layouts.app')

@section('content')
<div style="max-width: 450px; margin: 50px auto; padding: 0 20px;">
    
    <div class="card animate-fade-up">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin: 0 0 10px 0; font-size: 26px;">Crear Cuenta</h2>
            <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Únete a la red de TalentoLocal</p>
        </div>

        <form method="POST" action="{{ route('register') }}" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf
            
            <div style="width: 100%;">
                <label for="name" style="display: block; font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">NOMBRE Y APELLIDOS</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                       style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc; box-sizing: border-box; font-size: 14px;" 
                       placeholder="Ej: Badr Belayachi">
                @error('name')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="width: 100%;">
                <label for="email" style="display: block; font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">CORREO ELECTRÓNICO</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                       style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc; box-sizing: border-box; font-size: 14px;" 
                       placeholder="tu@email.com">
                @error('email')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="width: 100%;">
                <label for="rol" style="display: block; font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">¿QUÉ TIPO DE USUARIO ERES?</label>
                <select id="rol" name="rol" required 
                        style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc; box-sizing: border-box; font-size: 14px; cursor: pointer;">
                    <option value="" disabled selected>Selecciona una opción...</option>
                    <option value="estudiante">👨‍🎓 Estudiante</option>
                    <option value="empresa">🏢 Empresa</option>
                    <option value="tutor_academico">👨‍🏫 Tutor Académico</option>
                </select>
                @error('rol')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div id="campo_estudiante" style="display: none; width: 100%; animation: fadeUp 0.3s ease-out;">
                <label for="grado" style="display: block; font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">CICLO FORMATIVO / GRADO</label>
                <input id="grado" type="text" name="grado" value="{{ old('grado') }}" 
                       style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc; box-sizing: border-box; font-size: 14px;" 
                       placeholder="Ej: 2º DAW">
            </div>

            <div id="campo_empresa" style="display: none; width: 100%; animation: fadeUp 0.3s ease-out;">
                <label for="nombre_empresa" style="display: block; font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">NOMBRE DE LA EMPRESA</label>
                <input id="nombre_empresa" type="text" name="nombre_empresa" value="{{ old('nombre_empresa') }}" 
                       style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc; box-sizing: border-box; font-size: 14px;" 
                       placeholder="Ej: Tecnoambiente S.L.">
            </div>

            <div style="width: 100%;">
                <label for="password" style="display: block; font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">CONTRASEÑA</label>
                <input id="password" type="password" name="password" required 
                       style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc; box-sizing: border-box; font-size: 14px;" 
                       placeholder="Mínimo 8 caracteres">
            </div>

            <div style="width: 100%;">
                <label for="password_confirmation" style="display: block; font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">REPETIR CONTRASEÑA</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required 
                       style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 6px; background: #f8fafc; box-sizing: border-box; font-size: 14px;" 
                       placeholder="Repite tu contraseña">
            </div>
            @error('password')
                <span style="color: #ef4444; font-size: 12px; margin-top: -10px; display: block;">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn" style="width: 100%; padding: 14px; font-size: 16px; margin-top: 10px; border-radius: 8px;">
                Completar Registro
            </button>
        </form>

        <div style="margin-top: 25px; text-align: center; font-size: 14px; color: var(--text-muted); border-top: 1px solid var(--border-color); padding-top: 20px;">
            ¿Ya tienes cuenta? 
            <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 700; text-decoration: none;">Inicia Sesión aquí</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectRol = document.getElementById('rol');
        const campoEstudiante = document.getElementById('campo_estudiante');
        const campoEmpresa = document.getElementById('campo_empresa');

        function actualizarCampos() {
            campoEstudiante.style.display = 'none';
            campoEmpresa.style.display = 'none';

            if (selectRol.value === 'estudiante') {
                campoEstudiante.style.display = 'block';
            } else if (selectRol.value === 'empresa') {
                campoEmpresa.style.display = 'block';
            }
        }
        selectRol.addEventListener('change', actualizarCampos);
        if(selectRol.value) { actualizarCampos(); }
    });
</script>
@endsection