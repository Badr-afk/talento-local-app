@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 40px auto; padding: 0 20px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="color: var(--text-main); margin: 0; font-size: 22px;">Mi Perfil</h2>
        <a href="{{ route('home') }}" class="btn-volver">Volver al Panel</a>
    </div>

    <div class="card animate-fade-up">

        <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 10px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color);">

                @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border-color); margin-bottom: 15px;">
                @else
                <div style="width: 100px; height: 100px; border-radius: 50%; background-color: #dbeafe; color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-size: 35px; font-weight: bold; margin-bottom: 15px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                @endif

                <label for="avatar" style="cursor: pointer; color: var(--primary-color); font-size: 13px; font-weight: 600; transition: color 0.2s;">
                    Cambiar foto de perfil
                </label>
                <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                <p style="font-size: 11px; color: var(--text-muted); margin: 5px 0 0 0;">JPG, PNG o GIF (Max. 2MB)</p>

                @error('avatar')
                <span style="color: #ef4444; font-size: 12px; margin-top: 8px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="width: 100%;">
                <label for="name" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 8px;">Nombre Completo</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                @error('name')
                <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="width: 100%;">
                <label for="email" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 8px;">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                @error('email')
                <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 12px; margin-top: 10px;">
                Guardar Cambios
            </button>
        </form>

    </div>
</div>

<script>
    // Script para dar feedback visual al seleccionar una imagen
    document.getElementById('avatar').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            let label = document.querySelector('label[for="avatar"]');
            label.textContent = '✓ Archivo seleccionado: ' + e.target.files[0].name;
            label.style.color = 'var(--success-color)';
        }
    });
</script>
@endsection