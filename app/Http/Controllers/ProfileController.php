<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // <- Añadimos el modelo

class ProfileController extends Controller
{
    // Muestra el formulario de edición
    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    // Procesa la actualización de datos
    public function update(Request $request)
    {
        // Buscamos al usuario directamente desde el modelo para que VS Code no marque error
        $user = User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            // Comprueba que el email no lo use otro usuario, excepto él mismo
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Máximo 2MB
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Si el usuario ha subido una nueva imagen...
        if ($request->hasFile('avatar')) {
            // Borrar el avatar anterior si existía para no acumular basura en el servidor
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Guardar la nueva foto en la carpeta public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'SYS_MSG: Perfil actualizado correctamente.');
    }
}