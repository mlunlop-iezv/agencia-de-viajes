<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Http\Requests\ComentarioRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    // Blindamos todo el controlador: solo usuarios logueados pueden entrar
    function __construct() {
        $this->middleware('auth');
    }

    // Helper de seguridad: devuelve true si eres el dueño del comentario o el admin
    private function ownerControl(Comentario $comentario): bool {
        $user = Auth::user();
        return $user->id == $comentario->iduser || $user->isAdmin();
    }

    public function store(ComentarioRequest $request): RedirectResponse {
        $user = Auth::user();
        
        // Regla de negocio: No puedes opinar si no has reservado antes
        if(!$user->tieneReserva($request->idvacacion)) {
            return back()->withErrors(['general' => 'Debes tener una reserva para comentar.']);
        }

        // Instanciamos y asignamos el autor (el usuario actual)
        $comentario = new Comentario($request->all());
        $comentario->iduser = $user->id;

        try {
            $comentario->save();
            return back()->with(['general' => 'Comentario publicado.']);

        } catch(\Exception $e) {
            return back()->withErrors(['general' => 'Error al guardar el comentario.']);
        }
    }

    // Muestra el formulario de edición, pero primero verifica permisos
    public function edit(Comentario $comentario): RedirectResponse|View {
        if(!$this->ownerControl($comentario)) {
            return redirect()->route('main.index')->withErrors(['general' => 'Acceso denegado.']);
        }
        return view('comentario.edit', ['comentario' => $comentario]);
    }

    public function update(ComentarioRequest $request, Comentario $comentario): RedirectResponse {
        // Doble check de seguridad antes de escribir en la BD
        if(!$this->ownerControl($comentario)) {
            return redirect()->route('main.index');
        }

        try {
            $comentario->update($request->all());
            return redirect()->route('vacacion.show', $comentario->idvacacion)->with(['general' => 'Comentario actualizado.']);

        } catch(\Exception $e) {
            return back()->withErrors(['general' => 'Error al editar.']);
        }
    }

    public function destroy(Comentario $comentario): RedirectResponse {
        // Si no eres dueño ni admin, no pasas
        if(!$this->ownerControl($comentario)) {
            return back();
        }

        try {
            $comentario->delete();
            return back()->with(['general' => 'Comentario eliminado.']);

        } catch(\Exception $e) {
            return back()->withErrors(['general' => 'Error al eliminar.']);
        }
    }
}