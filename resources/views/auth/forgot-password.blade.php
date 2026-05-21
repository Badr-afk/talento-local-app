@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 80px auto; padding: 0 20px;">
    
    <div class="card animate-fade-up">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin: 0 0 10px 0; font-size: 24px;">Recuperar Contraseña</h2>
            <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Te enviaremos un enlace para restablecerla</p>
        </div>

        @if (session('status'))
            <div style="background-color: #dcfce3; color: #166534; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; text-align: center;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <div style="width: 100%;">
                <label for="email" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 8px;">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input" placeholder="ejemplo@correo.com" style="width: 100%; box-sizing: border-box;">
                @error('email')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 12px; font-size: 15px; margin-top: 10px;">
                Enviar enlace de recuperación
            </button>
        </form>

        <div style="margin-top: 25px; text-align: center; font-size: 14px; border-top: 1px solid var(--border-color); padding-top: 20px;">
            <a href="{{ route('login') }}" style="color: var(--text-muted); font-weight: 600; text-decoration: none;">Volver al Iniciar Sesión</a>
        </div>
    </div>

</div>
@endsection