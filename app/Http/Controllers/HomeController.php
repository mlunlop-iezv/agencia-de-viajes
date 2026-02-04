<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class HomeController extends Controller
{
    // Candado puesto: solo usuarios logueados pueden entrar aquí
    function __construct()
    {
        $this->middleware('auth');
    }

    // Dashboard principal: traemos al usuario con sus reservas (Eager Loading para no matar la BD)
    function index(): View
    {
        $user = Auth::user()->load('reservas.vacacion');
        return view('auth.home', ['user' => $user]);
    }

    // Formulario de edición de perfil
    function edit(): View
    {
        return view('auth.edit');
    }

    // Procesa la actualización de datos del usuario
    function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Validaciones clave: 'current_password' chequea seguridad y 'unique' ignora nuestro propio ID
        $rules = [
            'current-password' => 'current_password',
            'email'            => 'required|max:255|email|unique:users,email,' . $user->id,
            'name'             => 'required|max:255',
            'password'         => 'nullable|min:8|confirmed',
        ];

        $messages = [
            'name.required'                     => 'Nombre obligatorio',
            'name.max'                          => 'Nombre máximo 255 caracteres',
            'email.max'                         => 'Correo máximo 255 caracteres',
            'email.unique'                      => 'Este correo ya está en uso',
            'email.required'                    => 'Correo obligatorio',
            'email.email'                       => 'Formato de correo inválido',
            'password.min'                      => 'La contraseña debe tener mínimo 8 caracteres',
            'password.confirmed'                => 'Las contraseñas no coinciden',
            'current-password.current_password' => 'La contraseña actual es incorrecta'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        // Actualizamos nombre
        $user->name = $request->name;

        // Si cambia el email, reseteamos la verificación para obligarle a validar el nuevo
        if($user->email != $request->email) {
            $user->email_verified_at = null;
            $user->email = $request->email;
        }

        // Solo hasheamos y guardamos la pass si el usuario escribió una nueva
        if($request->password != null) {
            $user->password = Hash::make($request->password);
        }

        try {
            $user->save();
            $message = 'Perfil actualizado correctamente.';
        } catch(\Exception $e) {
            $message = 'Error al guardar.';
        }

        return redirect()->route('home')->with(['general' => $message]);
    }
}