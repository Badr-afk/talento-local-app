@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 80px auto; padding: 0 20px;">

    <div class="card animate-fade-up">

        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: var(--primary-color); margin: 0 0 10px 0; font-size: 24px;">Iniciar Sesión</h2>
            <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Accede a tu panel de control</p>
        </div>

        <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <div style="width: 100%;">
                <label for="email" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 8px;">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input" placeholder="ejemplo@correo.com" style="width: 100%; box-sizing: border-box;">
                @error('email')
                <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="width: 100%;">
                <label for="password" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 8px;">Contraseña</label>
                <input id="password" type="password" name="password" required class="form-input" placeholder="••••••••" style="width: 100%; box-sizing: border-box;">
                @error('password')
                <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <input id="remember_me" type="checkbox" name="remember" style="width: 16px; height: 16px; accent-color: var(--primary-color); cursor: pointer;">
                    <label for="remember_me" style="font-size: 13px; color: var(--text-muted); cursor: pointer; margin: 0;">Mantener sesión iniciada</label>
                </div>

                <a href="/forgot-password" style="font-size: 13px; color: var(--primary-color); text-decoration: none; font-weight: 600;">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <button type="submit" class="btn" style="width: 100%; padding: 12px; font-size: 15px; margin-top: 10px;">
                Entrar al Sistema
            </button>
        </form>

        <div style="margin-top: 25px; text-align: center; font-size: 14px; color: var(--text-muted); border-top: 1px solid var(--border-color); padding-top: 20px;">
            ¿No tienes una cuenta?
            <a href="{{ route('register') }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Regístrate aquí</a>
        </div>
    </div>

</div>
@endsection