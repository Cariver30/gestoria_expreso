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
Route::get('extraer/data/pdf', [App\Http\Controllers\HomeController::class, 'getDataPdf'])->name('pdf.data');
Route::get('subservicios/{id}', [App\Http\Controllers\ServicioController::class, 'getSubServicio']);
Route::post('servicio/subservicio', [App\Http\Controllers\ServicioController::class, 'addSubServicio'])->name('servicio.store.subservicio');
Route::resource('usuario', App\Http\Controllers\UserController::class);
Route::resource('servicio', App\Http\Controllers\ServicioController::class);
Route::resource('roles', App\Http\Controllers\RoleController::class);
Route::resource('estatus', App\Http\Controllers\EstatusController::class);
Route::resource('sedes', App\Http\Controllers\SedeController::class);

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'root'])->name('index');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
