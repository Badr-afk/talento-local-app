<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\JornadaController;
use App\Http\Controllers\ProfileController;

// --- RUTAS PROTEGIDAS (Solo para usuarios logueados) ---
Route::middleware('auth')->group(function () {

    // Página principal
    Route::get('/', function () {
        return view('home');
    })->name('home');

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- RUTAS DE LAS OFERTAS ---
    Route::get('/ofertas', [OfertaController::class, 'index'])->name('ofertas.index'); // <-- ¡Esta es la que faltaba!
    Route::get('/ofertas/crear', [OfertaController::class, 'create'])->name('ofertas.create');
    Route::post('/ofertas', [OfertaController::class, 'store'])->name('ofertas.store');
    Route::get('/ofertas/{id}', [OfertaController::class, 'show'])->name('ofertas.show');
    Route::get('/mis-ofertas', [OfertaController::class, 'misOfertas'])->name('ofertas.propias');
});

// --- RUTAS PÚBLICAS (Login y Registro) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');

// --- Incribirse ---
Route::post('/ofertas/{id}/inscribir', [OfertaController::class, 'inscribir'])->name('ofertas.inscribir');
Route::get('/ofertas/{id}/candidatos', [OfertaController::class, 'verCandidatos'])->name('ofertas.candidatos');

// --- RUTAS DEL CHAT ---
Route::post('/candidatura/{id}/chat', [ChatController::class, 'iniciarChat'])->name('chat.iniciar');
Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');


Route::get('/magia-tutor', function () {
    // 1. Coge al primer estudiante que pille en la base de datos
    $alumno = \App\Models\User::where('rol', 'estudiante')->first();

    // 2. Busca un tutor o lo crea si no existe
    $tutor = \App\Models\User::firstOrCreate(
        ['email' => 'profe@instituto.com'],
        ['name' => 'Profesor Tutor', 'password' => bcrypt('12345678'), 'rol' => 'tutor_academico']
    );

    // 3. Los conecta
    if ($alumno) {
        $alumno->tutor_id = $tutor->id;
        $alumno->save();
        return "¡Magia hecha! El alumno {$alumno->name} ahora tiene al tutor {$tutor->name}.";
    }
    return "¡Aviso! No tienes ningún estudiante creado en la base de datos.";
});

Route::post('/chat/{id}/mensaje', [ChatController::class, 'enviarMensaje'])->name('chat.mensaje');

// --- RUTAS DEL TUTOR ---
Route::get('/mis-alumnos', [TutorController::class, 'misAlumnos'])->name('tutor.alumnos');
Route::post('/mis-alumnos/{id}/asignar', [TutorController::class, 'asignarAlumno'])->name('tutor.asignar');

Route::post('/chat/{id}/asignar-horas', [ChatController::class, 'asignarHoras'])->name('chat.asignarHoras');

// --- RUTAS DEL DIARIO DE PRÁCTICAS ---
Route::get('/mi-diario', [JornadaController::class, 'miDiario'])->name('diario.index');
Route::post('/mi-diario/registrar', [JornadaController::class, 'registrarJornada'])->name('jornada.registrar');
// Ruta para ver la lista de chats de la empresa
Route::get('/mis-chats', [ChatController::class, 'misChats'])->name('empresa.chats');

// --- RUTAS DE PERFIL ---
Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.edit');
Route::post('/perfil', [ProfileController::class, 'update'])->name('perfil.update');

Route::get('/diario/descargar-pdf', [App\Http\Controllers\JornadaController::class, 'descargarPDF'])->name('diario.pdf');

// Ruta rápida para marcar todas las notificaciones como leídas
Route::post('/notificaciones/leer', function () {
    \App\Models\Notificacion::where('user_id', \Illuminate\Support\Facades\Auth::id())->update(['leida' => true]);
    return back();
})->name('notificaciones.leerTodas');
