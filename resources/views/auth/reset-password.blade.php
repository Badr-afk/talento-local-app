@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 80px auto; padding: 0 20px;">
    
    <div class="card animate-fade-up">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin: 0 0 10px 0; font-size: 24px;">Crear Nueva Contraseña</h2>
            <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Asegúrate de que tenga al menos 8 caracteres</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div style="width: 100%;">
                <label for="email" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 8px;">Confirma tu correo</label>
                <input id="email" type="email" name="email" value="{{ old('email', request()->email) }}" required autofocus class="form-input" style="width: 100%; box-sizing: border-box;">
                @error('email')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="width: 100%;">
                <label for="password" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 8px;">Nueva Contraseña</label>
                <input id="password" type="password" name="password" required class="form-input" placeholder="••••••••" style="width: 100%; box-sizing: border-box;">
                @error('password')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="width: 100%;">
                <label for="password_confirmation" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 8px;">Repetir Contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input" placeholder="••••••••" style="width: 100%; box-sizing: border-box;">
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 12px; font-size: 15px; margin-top: 10px;">
                Guardar Contraseña
            </button>
        </form>
    </div>

</div>
@endsection