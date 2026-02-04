<?php
namespace App\Http\Controllers;
use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller {
    public function index() { return "Gestión de Tipos (Pendiente)"; }
    public function create() { }
    public function store(Request $request) { }
    public function show(Tipo $tipo) { }
    public function edit(Tipo $tipo) { }
    public function update(Request $request, Tipo $tipo) { }
    public function destroy(Tipo $tipo) { }
}