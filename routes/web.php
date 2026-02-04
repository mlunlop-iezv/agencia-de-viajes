<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MainController;
use App\Http\Controllers\VacacionController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\HomeController;



Route::get('/', [MainController::class, 'index'])->name('main.index');


Route::get('image/{id}', [ImageController::class, 'view'])->name('image.view');
Route::get('foto/{id}', [ImageController::class, 'foto'])->name('foto.view');

Route::delete('vacacion/delete/group', [VacacionController::class, 'deleteGroup'])->name('vacacion.delete.group');

Route::resource('vacacion', VacacionController::class);
Route::resource('tipo', TipoController::class);
Route::resource('user', UserController::class);

Route::post('reserva', [ReservaController::class, 'store'])->name('reserva.store');
Route::delete('reserva/{reserva}', [ReservaController::class, 'destroy'])->name('reserva.destroy');


Route::post('comentario', [ComentarioController::class, 'store'])->name('comentario.store');
Route::get('comentario/{comentario}/edit', [ComentarioController::class, 'edit'])->name('comentario.edit');
Route::put('comentario/{comentario}', [ComentarioController::class, 'update'])->name('comentario.update');
Route::delete('comentario/{comentario}', [ComentarioController::class, 'destroy'])->name('comentario.destroy');

Auth::routes(['verify' => true]);

// Panel de Usuario
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('home/edit', [HomeController::class, 'edit'])->name('home.edit');
Route::put('home/update', [HomeController::class, 'update'])->name('home.update');