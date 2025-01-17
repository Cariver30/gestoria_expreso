<?php

namespace App\Http\Controllers;

use App\Models\GestoriaSubServicio;
use Illuminate\Http\Request;

class GestoriaSubServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(gestoriaSubServicio $gestoriaSubServicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(gestoriaSubServicio $gestoriaSubServicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, gestoriaSubServicio $gestoriaSubServicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(gestoriaSubServicio $gestoriaSubServicio)
    {
        //
    }

    public function getDataSubservicio($id) {

        $sub_servicios = GestoriaSubServicio::where('gestoria_servicio_id', $id)->get();

        return response()->json(['code' => 200, 'data' => $sub_servicios]);
    }
}
