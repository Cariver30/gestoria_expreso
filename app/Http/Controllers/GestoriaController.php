<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Sede;
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
    public function edit($id)
    {
        // dd($id);
        $servicio = Gestoria::find($id);

        if ($servicio) {
            $subservicios = GestoriaServicio::where('gestoria_id', $id)->select('id', 'nombre')->get();
            $entidades = \Helper::entidadUsuario();
            
            return view('modulo.gestoria.admin.servicio', compact('subservicios', 'id', 'servicio', 'entidades'));
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gestoria $gestoria)
    {
        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El nombre es requerido']);
        }

        DB::beginTransaction();

        try {
            $gestoria = Gestoria::find($request->id);
            $gestoria->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $gestoria->save();

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Servicio '.$request->nombre.' actualizado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gestoria $gestoria)
    {
        //
    }

    public function getGestoriaServicios() {

        $entidades = Sede::where('estatus_id', 1)->select('id', 'nombre')->get();
        $gestorias = Gestoria::where('estatus_id', 1)->select('id', 'nombre')->get();

        return view('modulo.gestoria.admin.index', compact('gestorias', 'entidades'));
    }
}
