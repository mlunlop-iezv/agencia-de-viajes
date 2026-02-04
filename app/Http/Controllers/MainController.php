<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    function index(Request $request): View
    {
        // 1. Sanitizamos los inputs para evitar valores raros en la URL
        $campo = $this->limpiarCampo($request->campo);
        $orden = $this->limpiarOrden($request->orden);
        $precioMin = $this->limpiarNumeros($request->precioMin);
        $precioMax = $this->limpiarNumeros($request->precioMax);
        
        // Variables directas
        $q = $request->q;
        $idtipo = $request->idtipo;

        // 2. Query Base: Unimos con 'tipo' para poder filtrar/ordenar por su nombre
        $query = Vacacion::query();
        $query->join('tipo', 'tipo.id', '=', 'vacacion.idtipo')
              ->select('vacacion.*', 'tipo.nombre as tipo_nombre');

        // 3. Aplicamos filtros solo si vienen datos
        if ($precioMin != null) {
            $query->where('vacacion.precio', '>=', $precioMin);
        }
        if ($precioMax != null) {
            $query->where('vacacion.precio', '<=', $precioMax);
        }
        if ($idtipo != null) {
            $query->where('vacacion.idtipo', '=', $idtipo);
        }

        // 4. Buscador Global: Usamos una closure (función anónima) para agrupar los OR
        // Esto es clave: si no agrupas, los OR rompen los filtros de precio/tipo anteriores
        if ($q != null) {
            $query->where(function ($sq) use ($q) {
                $sq->where('vacacion.titulo', 'like', '%' . $q . '%')
                    ->orWhere('vacacion.descripcion', 'like', '%' . $q . '%')
                    ->orWhere('vacacion.pais', 'like', '%' . $q . '%')
                    ->orWhere('tipo.nombre', 'like', '%' . $q . '%');
            });
        }

        // 5. Ordenación segura y paginación
        $campoorden = $this->getOrderBy($campo);
        $query->orderBy($campoorden, $orden);

        $vacaciones = $query->paginate(9)->withQueryString();

        // Datos para rellenar los filtros en la vista
        $tipos = Tipo::pluck('nombre', 'id')->all();

        return view('vacacion.index', [
            'vacaciones' => $vacaciones,
            'tipos'      => $tipos,
            // Pasamos los inputs de vuelta para mantener el estado del formulario
            'campo'      => $campo,
            'orden'      => $orden,
            'precioMin'  => $precioMin,
            'precioMax'  => $precioMax,
            'idtipo'     => $idtipo,
            'q'          => $q,
        ]);
    }

    // Traduce el parámetro de la URL a la columna real de la BD
    private function getOrderBy($orderRequest): string {
        $array = [
            'recent' => 'vacacion.id',
            'titulo' => 'vacacion.titulo',
            'precio' => 'vacacion.precio',
            'pais'   => 'vacacion.pais'
        ];
        return $array[$orderRequest] ?? 'vacacion.id';
    }

    // Whitelisting: Solo permitimos columnas y direcciones válidas
    private function limpiarCampo($campo): string {
        return $this->limpiarInput($campo, ['recent', 'titulo', 'precio', 'pais']);
    }

    private function limpiarOrden($orden): string {
        return $this->limpiarInput($orden, ['desc', 'asc']);
    }

    // Lógica genérica de validación contra lista blanca
    private function limpiarInput($input, array $array): string {
        return in_array($input, $array) ? $input : $array[0];
    }

    // Asegura que sea número o null
    private function limpiarNumeros($numero): mixed {
        return is_numeric($numero) ? $numero : null;
    }
}