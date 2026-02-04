<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Foto;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImageController extends Controller
{
    // Carga la foto principal (la primera) de una vacación
    function view($id): BinaryFileResponse
    {
        $vacacion = Vacacion::find($id);
        $foto = $vacacion?->fotos->first(); // El ? nos protege si no encuentra la vacación

        // Construimos la ruta completa al archivo
        $path = storage_path('app/public/' . $foto?->ruta);

        // Si no hay datos en BD o el archivo físico no existe, mostramos el placeholder
        if(!$vacacion || !$foto || !file_exists($path)) {
            return response()->file(public_path('assets/img/noimage.png')); 
        }

        return response()->file($path);
    }

    // Carga una foto específica por su ID
    function foto($id): BinaryFileResponse
    {
        $foto = Foto::find($id);
        $path = storage_path('app/public/' . $foto?->ruta);

        // Misma lógica: seguridad ante archivos perdidos
        if(!$foto || !file_exists($path)) {
            return response()->file(public_path('assets/img/noimage.png'));
        }

        return response()->file($path);
    }
}