<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Tipo;
use App\Models\Foto;
use App\Http\Requests\VacacionCreateRequest;
use App\Http\Requests\VacacionEditRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;

class VacacionController extends Controller
{
    function __construct() {
        // Candado puesto: solo admins, salvo para cotillear (show)
        $this->middleware('admin')->except(['show']);
    }

    public function index()
    {
        // Listado descendente y paginado para no saturar
        $vacaciones = Vacacion::orderBy('id', 'desc')->paginate(10);
        return view('vacacion.admin', ['vacaciones' => $vacaciones]);
    }

    public function show(Vacacion $vacacion)
    {
        // Eager Loading: cargamos fotos y comentarios de una para optimizar queries
        $vacacion->load(['fotos', 'comentarios.user']); 
        return view('vacacion.show', ['vacacion' => $vacacion]);
    }

    public function create()
    {
        $tipos = Tipo::all();
        return view('vacacion.create', ['tipos' => $tipos]);
    }

    public function store(VacacionCreateRequest $request): RedirectResponse
    {
        $result = false;
        // Instanciamos con los datos ya validados por el Request
        $vacacion = new Vacacion($request->all());
        
        try {
            $result = $vacacion->save();
            
            // Si guardó bien y trae foto, la subimos
            if($request->hasFile('imagen')) {
                $ruta = $this->upload($request, $vacacion->id);
                if($ruta) {
                    Foto::create(['idvacacion' => $vacacion->id, 'ruta' => $ruta]);
                }
            }
            
            $message = 'La vacación ha sido creada correctamente.';

        } catch(UniqueConstraintViolationException $e) {
            // Cazamos duplicados
            $message = 'Ya existe un registro con estos datos.';
        } catch(QueryException $e) {
            // Fallo SQL general
            $message = 'Error en la consulta SQL: ' . $e->getMessage();
        } catch(\Exception $e) {
            // Cualquier otro crash
            $message = 'Se ha producido un error inesperado.';
        }

        $messageArray = ['general' => $message];

        if($result) {
            return redirect()->route('vacacion.index')->with($messageArray);
        } else {
            return back()->withInput()->withErrors($messageArray);
        }
    }

    public function edit(Vacacion $vacacion)
    {
        $tipos = Tipo::all();
        return view('vacacion.edit', ['vacacion' => $vacacion, 'tipos' => $tipos]);
    }

    public function update(VacacionEditRequest $request, Vacacion $vacacion): RedirectResponse
    {
        $result = false;

        try {
            $result = $vacacion->update($request->all());
            
            // Gestión de imagen al editar: si suben nueva, la guardamos
            if($request->hasFile('imagen')) {
                $ruta = $this->upload($request, $vacacion->id);
                if($ruta) {
                    Foto::create(['idvacacion' => $vacacion->id, 'ruta' => $ruta]);
                }
            }

            $message = 'La vacación ha sido editada.';

        } catch(UniqueConstraintViolationException $e) {
            $message = 'Ya existe un registro con estos datos.';
        } catch(\Exception $e) {
            $message = 'Se ha producido un error.';
        }

        $messageArray = ['general' => $message];

        if($result) {
            return redirect()->route('vacacion.index')->with($messageArray);
        } else {
            return back()->withInput()->withErrors($messageArray);
        }
    }

    public function destroy(Vacacion $vacacion): RedirectResponse
    {
        try {
            // Limpieza manual: borramos fotos físicas primero
            foreach($vacacion->fotos as $foto) {
                $foto->delete(); 
            }

            // Borrado en cascada de relaciones antes de matar al padre
            $vacacion->reservas()->delete();
            $vacacion->comentarios()->delete();
            
            $result = $vacacion->delete();
            $message = 'La vacación ha sido eliminada.';

        } catch(\Exception $e) {
            $result = false;
            $message = 'No se ha podido eliminar la vacación. Puede tener dependencias.';
        }

        $messageArray = ['general' => $message];

        if($result) {
            return redirect()->route('vacacion.index')->with($messageArray);
        } else {
            return back()->withInput()->withErrors($messageArray);
        }
    }

    function deleteGroup(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->withErrors(['general' => 'No se seleccionó ningún elemento.']);
        }

        try {
            // Borrado masivo eficiente usando whereIn para no hacer mil consultas
            \App\Models\Reserva::whereIn('idvacacion', $ids)->delete();
            \App\Models\Comentario::whereIn('idvacacion', $ids)->delete();
            \App\Models\Foto::whereIn('idvacacion', $ids)->delete();

            $count = Vacacion::whereIn('id', $ids)->delete();
            
            $message = "Se han eliminado $count elementos correctamente.";

        } catch (\Exception $e) {
            $message = 'Error al eliminar: ' . $e->getMessage();
            return back()->withErrors(['general' => $message]);
        }

        return redirect()->route('vacacion.index')->with(['general' => $message]);
    }

    // Helper privado para subir archivos al disco public
    private function upload(Request $request, $idvacacion): string|null {
        $path = null;
        if($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $image = $request->file('imagen');
            $fileName = $idvacacion . '_' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('fotos', $fileName, 'public');
        }
        return $path;
    }
}