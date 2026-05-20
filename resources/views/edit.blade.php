@extends('layouts.app')

@section('content')
<style>
    .input-terminal {
        width: 100%;
        padding: 12px;
        background-color: var(--bg-color);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        border-radius: 2px;
        font-family: monospace;
        font-size: 14px;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }
    .input-terminal:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.1) inset;
    }
    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-color);
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.2);
    }
    .avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: var(--border-color);
        border: 2px dashed var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: var(--text-muted);
    }
</style>

<div style="max-width: 600px; margin: 40px auto; padding: 0 20px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="color: var(--primary-color); font-family: monospace; text-transform: uppercase;">>_ Configuración de Usuario</h1>
        <a href="{{ route('home') }}" class="btn btn-outline">[ PANEL ]</a>
    </div>

    <div class="card animate-fade-up">
        
        <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 30px;">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar de {{ $user->name }}" class="avatar-preview">
                @else
                    <div class="avatar-placeholder">
                        👤
                    </div>
                @endif
                
                <div style="margin-top: 15px; text-align: center;">
                    <label for="avatar" style="cursor: pointer; color: var(--primary-color); font-size: 13px; font-weight: bold; text-decoration: underline;">
                        [ ACTUALIZAR IMAGEN ]
                    </label>
                    <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                    <p style="font-size: 11px; color: var(--text-muted); margin-top: 5px; font-family: monospace;">JPG, PNG o GIF (Max. 2MB)</p>
                </div>
                @error('avatar')
                    <span style="color: var(--accent-color); font-size: 12px; margin-top: 5px;">Error: {{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px; font-family: monospace;">IDENTIFICADOR (NOMBRE):</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-terminal" required>
                @error('name')
                    <span style="color: var(--accent-color); font-size: 12px;">Error: {{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-size: 12px; color: var(--text-muted); margin-bottom: 8px; font-family: monospace;">DIRECCIÓN DE COMUNICACIÓN (EMAIL):</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-terminal" required>
                @error('email')
                    <span style="color: var(--accent-color); font-size: 12px;">Error: {{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn" style="width: 100%;">EJECUTAR ACTUALIZACIÓN</button>
        </form>
    </div>
</div>

<script>
    // Pequeño script para que cuando elijas una foto, el texto cambie y sepas que se ha cargado
    document.getElementById('avatar').addEventListener('change', function(e) {
        if(e.target.files.length > 0) {
            let label = document.querySelector('label[for="avatar"]');
            label.textContent = '[ ARCHIVO CARGADO - LISTO PARA EJECUTAR ]';
            label.style.color = 'var(--success-color)';
        }
    });
</script>
@endsection