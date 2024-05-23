<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gestoria;
use Illuminate\Http\Request;
use App\Models\GestoriaServicio;
use Illuminate\Support\Facades\Auth;

class GestoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = \Helper::getInfoUsuario();

        $entidades = \Helper::entidadUsuario();

        $gestorias = Gestoria::all();
        $transacciones = GestoriaServicio::where('gestoria_id', 1)->where('estatus_id', 1)->select('id', 'nombre')->get();
        $licencias = GestoriaServicio::where('gestoria_id', 2)->where('estatus_id', 1)->select('id', 'nombre')->get();
        $vehiculos = GestoriaServicio::where('gestoria_id', 3)->where('estatus_id', 1)->select('id', 'nombre')->get();

        return view('modulo.gestoria.index', compact('user', 'entidades', 'gestorias', 'transacciones', 'licencias', 'vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Gestoria $gestoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gestoria $gestoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gestoria $gestoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gestoria $gestoria)
    {
        //
    }
}
