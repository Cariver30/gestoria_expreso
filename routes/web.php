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
    // Pendiente por pagar venta de servicio a vehículo
    Route::post('pendiente/venta/vehiculo', [App\Http\Controllers\VentaController::class, 'pendienteVenta'])->name('pendiente.venta');
    // Finalizar venta de servicio a vehículo
    Route::post('finalizar/venta/vehiculo', [App\Http\Controllers\VentaController::class, 'finalizarVenta'])->name('finalizar.venta');

    Route::get('get/data/gestoria/subservicio/{id}', [App\Http\Controllers\GestoriaSubServicioController::class, 'getDataSubservicio']);
    Route::get('gestoria/servicios', [App\Http\Controllers\GestoriaController::class, 'getGestoriaServicios'])->name('gestoria.servicios');
    Route::get('reset/pin/{id}', [App\Http\Controllers\UserController::class, 'resetPin']);
    Route::get('sede/cambiar/{id}', [App\Http\Controllers\UserController::class, 'cambiarEntidad']);
    Route::get('subservicios/{id}', [App\Http\Controllers\ServicioController::class, 'getSubServicio']);
    Route::get('servicio/subservicio/editar/{id}', [App\Http\Controllers\ServicioController::class, 'editSubServicio'])->name('servicio.subservicio.edit');
    Route::post('servicio/subservicio', [App\Http\Controllers\ServicioController::class, 'addSubServicio'])->name('servicio.store.subservicio');
    //subservicios de gestoría
    Route::get('servicio/subservicio/gestoria/{id}', [App\Http\Controllers\GestoriaController::class, 'getSubservicios'])->name('servicio.subservicio.gestoria');
    Route::put('update/gestoria/subservicio/{id}', [App\Http\Controllers\GestoriaController::class, 'updateSubServicio']);
    Route::post('servicio/subservicio/gestoria', [App\Http\Controllers\GestoriaController::class, 'addSubServicioUltimo'])->name('ss.store.gestoria');
    Route::put('sservicio/gestoria/{id}', [App\Http\Controllers\GestoriaController::class, 'upSubServicioUltimo']);

    //Checkout
    Route::get('pay/checkout/{id}', [App\Http\Controllers\CheckoutController::class, 'payCheckoutVehicle'])->name('pay.checkout.vehicle');
    
    Route::put('update/subservicio/{id}', [App\Http\Controllers\ServicioController::class, 'updateSubServicio']);
    Route::post('delete/subservicio/{id}', [App\Http\Controllers\ServicioController::class, 'destroySubservicio']);
    Route::get('seccion', [App\Http\Controllers\ServicioController::class, 'getViewInspeccion'])->name('modulo.inspeccion');
    Route::get('consulta/tablilla/{tablilla}', [App\Http\Controllers\ServicioController::class, 'getTablilla'])->name('consulta.tablilla');
    Route::get('consulta/seguro-social/{segurosocial}', [App\Http\Controllers\ServicioController::class, 'getSeguroSocial'])->name('consulta.seguro.social');
    Route::post('clientes/marbete', [App\Http\Controllers\ClienteController::class, 'vehiculoMarbete'])->name('vehiculo.marbete');
    Route::post('seguro/vehiculo', [App\Http\Controllers\ClienteController::class, 'vehiculoSeguro'])->name('vehiculo.seguro');
    Route::get('marcar/bienvenida', [App\Http\Controllers\UserController::class, 'marcarInicio'])->name('marcar.inicio');
    Route::put('editar/usuario/{id}', [App\Http\Controllers\UserController::class, 'editarUsuario']);
    Route::resource('usuario', App\Http\Controllers\UserController::class);
    Route::resource('servicio', App\Http\Controllers\ServicioController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('estatus', App\Http\Controllers\EstatusController::class);
    Route::resource('gestoria', App\Http\Controllers\GestoriaController::class);
    Route::resource('sedes', App\Http\Controllers\SedeController::class);
    Route::resource('clientes', App\Http\Controllers\ClienteController::class);
    Route::resource('checkout', App\Http\Controllers\CheckoutController::class);

    //Update User Details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
});
