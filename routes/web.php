<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::post('inicio', [App\Http\Controllers\Auth\LoginController::class, 'validarLogin'])->name('login.pin');
Route::middleware(['auth'])->group(function () {

    Route::get('extraer/data/pdf', [App\Http\Controllers\HomeController::class, 'getDataPdf'])->name('pdf.data'); //cambiar para subir licencia imagen

    //Cancelar venta de servicio a vehículo
    Route::post('cancelar/venta/vehiculo', [App\Http\Controllers\VentaController::class, 'cancelarVenta'])->name('cancelar.venta');
    Route::get('reset/pin/{id}', [App\Http\Controllers\UserController::class, 'resetPin']);
    Route::get('sede/cambiar/{id}', [App\Http\Controllers\UserController::class, 'cambiarEntidad']);
    Route::get('subservicios/{id}', [App\Http\Controllers\ServicioController::class, 'getSubServicio']);
    Route::get('servicio/subservicio/editar/{id}', [App\Http\Controllers\ServicioController::class, 'editSubServicio'])->name('servicio.subservicio.edit');
    Route::post('servicio/subservicio', [App\Http\Controllers\ServicioController::class, 'addSubServicio'])->name('servicio.store.subservicio');
    Route::put('update/subservicio/{id}', [App\Http\Controllers\ServicioController::class, 'updateSubServicio']);
    Route::get('seccion', [App\Http\Controllers\ServicioController::class, 'getViewInspeccion'])->name('modulo.inspeccion');
    Route::get('consulta/tablilla/{tablilla}', [App\Http\Controllers\ServicioController::class, 'getTablilla'])->name('consulta.tablilla');
    Route::get('gestoria', [App\Http\Controllers\ServicioController::class, 'getViewGestoria'])->name('modulo.gestoria');
    Route::post('clientes/marbete', [App\Http\Controllers\ClienteController::class, 'vehiculoMarbete'])->name('vehiculo.marbete');
    Route::post('seguro/vehiculo', [App\Http\Controllers\ClienteController::class, 'seguroVehiculo'])->name('seguro.vehiculo');
    Route::get('marcar/bienvenida', [App\Http\Controllers\UserController::class, 'marcarInicio'])->name('marcar.inicio');
    Route::resource('usuario', App\Http\Controllers\UserController::class);
    Route::resource('servicio', App\Http\Controllers\ServicioController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('estatus', App\Http\Controllers\EstatusController::class);
    Route::resource('sedes', App\Http\Controllers\SedeController::class);
    Route::resource('clientes', App\Http\Controllers\ClienteController::class);

    //Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
});
