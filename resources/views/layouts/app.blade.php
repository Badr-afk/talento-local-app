<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentoLocal - Prácticas</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --accent-color: #4f46e5;
            --success-color: #10b981;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
            padding-top: 80px;
            position: relative;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            height: 65px;
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-sizing: border-box;
            z-index: 1000;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 1001;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-text {
            color: var(--text-main);
            font-weight: 800;
            font-size: 20px;
            letter-spacing: -0.5px;
        }

        .logo-text span {
            color: var(--primary-color);
        }

        .btn-volver {
            color: var(--text-muted);
            background: #f1f5f9;
            border: 1px solid transparent;
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-volver:hover {
            background: #e2e8f0;
            color: var(--text-main);
        }

        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: #ffffff !important;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
            text-align: center;
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-main) !important;
        }

        .btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color) !important;
            background-color: #f0f9ff;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            background-color: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-main);
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #ffffff;
            color: var(--text-main);
            border-left: 4px solid var(--success-color);
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            z-index: 9999;
            animation: slideIn 0.4s ease-out forwards, fadeOut 0.4s ease-in 4s forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                visibility: visible;
            }

            to {
                opacity: 0;
                visibility: hidden;
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}?v=2">
</head>

<body>

    <nav class="navbar">
        <div class="navbar-left">
            @if(!in_array(Route::currentRouteName(), ['home', 'login', 'register']))
            <a href="javascript:history.back()" class="btn-volver">
                &larr; Volver
            </a>
            @endif

            <a href="{{ url('/') }}" class="logo-container">
                <svg width="30" height="30" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100" height="100" rx="20" fill="#2563eb" />
                    <path d="M 30 35 L 70 35 L 70 48 L 56 48 L 56 75 L 44 75 L 44 48 L 30 48 Z" fill="#ffffff" />
                </svg>
                <div class="logo-text">Talento<span>Local</span></div>
            </a>
        </div>

        <div style="font-size: 14px; color: var(--text-muted); font-weight: 500; display: flex; align-items: center; gap: 15px;">
            @auth

            @php
            $notificacionesNoLeidas = \App\Models\Notificacion::where('user_id', Auth::id())->where('leida', false)->latest()->get();
            @endphp

            <div style="position: relative; margin-right: 10px; cursor: pointer;" onclick="document.getElementById('dropdown-notis').style.display = document.getElementById('dropdown-notis').style.display === 'block' ? 'none' : 'block'">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--text-main); transition: transform 0.2s;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>

                @if($notificacionesNoLeidas->count() > 0)
                <span style="position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; font-size: 10px; font-weight: bold; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 0 2px #ffffff;">
                    {{ $notificacionesNoLeidas->count() }}
                </span>
                @endif

                <div id="dropdown-notis" style="display: none; position: absolute; top: 40px; right: -20px; width: 320px; background: #ffffff; border: 1px solid var(--border-color); border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); z-index: 9999; overflow: hidden; cursor: default;">
                    <div style="padding: 12px 16px; background: #f8fafc; border-bottom: 1px solid var(--border-color); font-weight: 700; color: var(--text-main); display: flex; justify-content: space-between; align-items: center;">
                        Notificaciones
                        @if($notificacionesNoLeidas->count() > 0)
                        <form action="{{ route('notificaciones.leerTodas') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" style="background:none; border:none; color: var(--primary-color); font-size: 12px; font-weight: 600; cursor:pointer;">Marcar como leídas</button>
                        </form>
                        @endif
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        @forelse($notificacionesNoLeidas as $noti)
                        <a href="{{ $noti->url ?? '#' }}" style="display: block; padding: 16px; border-bottom: 1px solid var(--border-color); text-decoration: none; color: var(--text-main); font-size: 13px; transition: background 0.2s;">
                            <div style="display: flex; gap: 10px;">
                                <div style="color: var(--primary-color); font-size: 18px;">•</div>
                                <div>
                                    {{ $noti->mensaje }}
                                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 6px;">Hace {{ $noti->created_at->diffInMinutes() }} minutos</div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div style="padding: 30px 20px; text-align: center; color: var(--text-muted); font-size: 13px;">
                            📭 No tienes avisos nuevos
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border-color);">
                @else
                <span style="width: 32px; height: 32px; background-color: #dbeafe; color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                @endif
                <span style="color: var(--text-main); font-weight: 600;">{{ Auth::user()->name }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="background: transparent; border: 1px solid var(--border-color); color: var(--text-main); cursor: pointer; font-size: 13px; font-weight: 600; padding: 6px 12px; border-radius: 6px; transition: all 0.2s;">
                    Cerrar sesión
                </button>
            </form>
            @else
            @if(Route::currentRouteName() !== 'login')
            <a href="{{ route('login') }}" style="text-decoration: none; color: var(--text-main); font-weight: 600;">Entrar</a>
            @endif
            @if(Route::currentRouteName() !== 'register')
            <a href="{{ route('register') }}" class="btn" style="padding: 6px 16px;">Registrarse</a>
            @endif
            @endauth
        </div>
    </nav>

    @if(session('success'))
    <div class="toast" style="border-left-color: var(--success-color);">
        <span style="color: var(--success-color); font-size: 20px;">✓</span> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="toast" style="border-left-color: #ef4444; bottom: 90px;">
        <span style="color: #ef4444; font-size: 20px;">⚠</span> {{ session('error') }}
    </div>
    @endif

    @yield('content')

</body>

</html>