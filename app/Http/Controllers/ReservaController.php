<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;

class ReservaController extends Controller
{
    function __construct() {
        // Solo dejamos pasar a usuarios logueados y con el email verificado
        $this->middleware(['auth', 'verified']);
    }

    function store(Request $request): RedirectResponse {
        $user = Auth::user();
        $idvacacion = $request->input('idvacacion');

        // Comprobamos antes de nada si ya reservó para no duplicar
        if($user->tieneReserva($idvacacion)) {
            return back()->withErrors(['general' => 'Ya tienes una reserva para este viaje.']);
        }

        $reserva = new Reserva();
        $reserva->iduser = $user->id;
        $reserva->idvacacion = $idvacacion;
        
        $result = false;
        
        // Intentamos guardar controlando si falla por duplicado o error SQL
        try {
            $result = $reserva->save();
            $message = '¡Reserva confirmada con éxito!';
        } catch(UniqueConstraintViolationException $e) {
            $message = 'Ya has reservado este viaje anteriormente.';
        } catch(QueryException $e) {
            $message = 'Error al procesar la reserva.';
        } catch(\Exception $e) {
            $message = 'Ha ocurrido un error inesperado.';
        }

        // Redirigimos según si salió bien o mal
        if($result) {
            return redirect()->route('home')->with(['general' => $message]);
        } else {
            return back()->withErrors(['general' => $message]);
        }
    }

    function destroy(Reserva $reserva): RedirectResponse {
        // Seguridad: Solo el dueño de la reserva o un admin pueden borrarla
        if(Auth::user()->id != $reserva->iduser && !Auth::user()->isAdmin()) {
            return back()->withErrors(['general' => 'No tienes permiso para cancelar esta reserva.']);
        }

        try {
            $reserva->delete();
            $message = 'La reserva ha sido cancelada.';
            $result = true;
        } catch(\Exception $e) {
            $message = 'Error al cancelar la reserva.';
            $result = false;
        }

        // Retorno feedback al usuario
        if($result) {
            return back()->with(['general' => $message]);
        } else {
            return back()->withErrors(['general' => $message]);
        }
    }
}