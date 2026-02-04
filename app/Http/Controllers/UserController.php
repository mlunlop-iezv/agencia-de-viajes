<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\UniqueConstraintViolationException;

class UserController extends Controller
{
    function __construct() {
        // Zona VIP: solo entran administradores
        $this->middleware('admin');
    }

    public function index(): View {
        // Listamos paginando para no saturar la vista
        $users = User::paginate(10);
        return view('user.index', ['users' => $users]);
    }

    public function show(User $user): View {
        return view('user.show', ['user' => $user]);
    }

    public function create(): View {
        // Pasamos los roles posibles al formulario
        $rols = ['admin', 'user', 'advanced'];
        return view('user.create', ['rols' => $rols]);
    }

    public function store(Request $request): RedirectResponse {
        // Reglas básicas antes de guardar
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'rol' => 'required'
        ]);

        try {
            // Creamos y encriptamos la contraseña al vuelo
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => $request->rol,
                'email_verified_at' => now(),
            ]);
            return redirect()->route('user.index')->with(['general' => 'Usuario creado.']);
        } catch(\Exception $e) {
            return back()->withInput()->withErrors(['general' => 'Error al crear usuario.']);
        }
    }

    public function edit(User $user): View {
        $rols = ['admin', 'user', 'advanced'];
        return view('user.edit', ['user' => $user, 'rols' => $rols]);
    }

    public function update(Request $request, User $user): RedirectResponse {
        // Validamos ignorando el email actual para que no de error de duplicado
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'rol' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->rol = $request->rol;

        // Solo cambiamos la pass si escribieron algo nuevo
        if($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Control manual del checkbox de verificado
        if($request->has('verified')) {
            if($user->email_verified_at == null) $user->email_verified_at = now();
        } else {
            $user->email_verified_at = null;
        }

        try {
            $user->save();
            return redirect()->route('user.index')->with(['general' => 'Usuario actualizado.']);
        } catch(\Exception $e) {
            return back()->withErrors(['general' => 'Error al actualizar.']);
        }
    }

    public function destroy(User $user): RedirectResponse {
        // Seguridad: Prohibido borrar al último admin del sistema
        if($user->isAdmin() && User::where('rol', 'admin')->count() <= 1) {
            return back()->withErrors(['general' => 'No puedes borrar al último administrador.']);
        }
        
        try {
            // Limpieza manual en cascada antes de borrar al usuario
            $user->reservas()->delete(); 
            $user->comentarios()->delete();
            $user->delete();
            return redirect()->route('user.index')->with(['general' => 'Usuario eliminado.']);
        } catch(\Exception $e) {
            return back()->withErrors(['general' => 'Error al eliminar usuario.']);
        }
    }
}