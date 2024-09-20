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

    // --------------------------------------------------- Gestoría ------------------------------------------------------------------
    Route::post('gestoria/cliente', [App\Http\Controllers\GestoriaController::class, 'crearCliente'])->name('gestoria.cliente');
    Route::post('gestoria/cliente/transaccion', [App\Http\Controllers\GestoriaController::class, 'addTransaccion'])->name('gestoria.transaccion');
    Route::post('gestoria/cliente/titulo', [App\Http\Controllers\GestoriaController::class, 'addTitulo'])->name('gestoria.titulo');
    Route::post('gestoria/cliente/renovacion', [App\Http\Controllers\GestoriaController::class, 'addRenovacion'])->name('gestoria.renovacion');
    Route::post('gestoria/cliente/aprendizaje', [App\Http\Controllers\GestoriaController::class, 'addAprendizaje'])->name('gestoria.aprendizaje');
    Route::post('gestoria/cliente/conducir', [App\Http\Controllers\GestoriaController::class, 'addConducir'])->name('gestoria.conducir');
    Route::post('gestoria/cliente/direccion', [App\Http\Controllers\GestoriaController::class, 'addDireccion'])->name('gestoria.direccion');
    Route::post('gestoria/cliente/traspaso', [App\Http\Controllers\GestoriaController::class, 'addTraspaso'])->name('gestoria.traspaso');
    Route::post('gestoria/cliente/venta-condicional', [App\Http\Controllers\GestoriaController::class, 'addVentaCondicional'])->name('gestoria.venta.condicional');
    Route::post('gestoria/cliente/gravamen', [App\Http\Controllers\GestoriaController::class, 'addGravamen'])->name('gestoria.gravamen');
    Route::post('gestoria/cliente/registro', [App\Http\Controllers\GestoriaController::class, 'addRegistro'])->name('gestoria.registro');
    Route::post('gestoria/cliente/notificacion', [App\Http\Controllers\GestoriaController::class, 'addNotificacion'])->name('gestoria.notificacion');
    
    

    Route::post('gestoria/cliente/pagar', [App\Http\Controllers\GestoriaController::class, 'pagar'])->name('gestoria.pagar');
    Route::post('gestoria/cliente/pendiente', [App\Http\Controllers\GestoriaController::class, 'pendiente'])->name('gestoria.pendiente');
    Route::post('gestoria/cliente/cancelar', [App\Http\Controllers\GestoriaController::class, 'cancelar'])->name('gestoria.cancelar');

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
    Route::get('ver/recibo/{id}', [App\Http\Controllers\CheckoutController::class, 'verRecibo'])->name('ver.recibo');
    
    Route::put('update/subservicio/{id}', [App\Http\Controllers\ServicioController::class, 'updateSubServicio']);
    Route::post('delete/subservicio/{id}', [App\Http\Controllers\ServicioController::class, 'destroySubservicio']);
    Route::get('seccion', [App\Http\Controllers\ServicioController::class, 'getViewInspeccion'])->name('modulo.inspeccion');
    Route::get('consulta/tablilla/{tablilla}', [App\Http\Controllers\ServicioController::class, 'getTablilla'])->name('consulta.tablilla');
    
    Route::get('consulta/cliente/tablilla', [App\Http\Controllers\ClienteController::class, 'getTablillaCliente'])->name('cliente.tablillas');
    Route::get('consulta/cliente/tablilla/vehiculo', [App\Http\Controllers\ClienteController::class, 'getTablillaVehiculoCliente'])->name('cliente.tablilla.vehiculo');
    
    // Sección de filtro en clientes
    Route::get('get/data/clientes', [App\Http\Controllers\ClienteController::class, 'getClientes'])->name('cliente.get.data');
    Route::get('get/data/clientes/search/{valor}', [App\Http\Controllers\ClienteController::class, 'getClientesFilter']);
    // Termina sección de filtro en clientes
    Route::post('vehiculo/extras/licencia', [App\Http\Controllers\ClienteController::class, 'vehiculoExtraLicencia'])->name('vehiculo.extras.licencia');
    Route::post('vehiculo/extras/notificacion', [App\Http\Controllers\ClienteController::class, 'vehiculoExtraNotificacion'])->name('vehiculo.extras.notificacion');
    Route::post('vehiculo/extras/multa', [App\Http\Controllers\ClienteController::class, 'vehiculoExtraMulta'])->name('vehiculo.extras.multa');
    Route::get('consulta/seguro-social/{segurosocial}', [App\Http\Controllers\ServicioController::class, 'getSeguroSocial'])->name('consulta.seguro.social');
    Route::post('clientes/marbete/acaa', [App\Http\Controllers\ClienteController::class, 'vehiculoMarbeteAcaa'])->name('vehiculo.marbete.acaa');
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
