<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sedes = Sede::all();

        return view('sede.index', compact('sedes'));
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
        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El nombre es requerido']);
        }
        if ($request->acceso_panel == '') {
            return response()->json(['code' => 400, 'msg' => 'Debe seleccionar al menos un acceso']);
        }

        DB::beginTransaction();

        try {
            $entidad = new Sede();
            $entidad->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $entidad->acceso_panel = $request->acceso_panel;
            $entidad->estatus_id = 1;
            $entidad->save();

            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Entidad creada']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sede $sede)
    {
        $entidad = Sede::find($sede->id);

        if ($entidad != null) {
            return response()->json(['code' => 200, 'data' => $entidad]);
        }
        return response()->json(['code' => 400, 'msg' => 'Entidad no encontrada']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sede $sede)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sede $sede)
    {
        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El nombre es requerido']);
        }
        if ($request->acceso_panel == '') {
            return response()->json(['code' => 400, 'msg' => 'Debe seleccionar al menos un acceso']);
        }

        DB::beginTransaction();

        try {
            $entidad = Sede::find($sede->id);
            $entidad->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $entidad->acceso_panel = $request->acceso_panel;
            $entidad->save();

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Entidad actualizada']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sede $sede)
    {
        $sede = Sede::find($sede->id);

        if ($sede != null) {
            if ($sede->estatus_id == 1) {
                $sede->estatus_id = 1;
                $mensaje = 'Entidad Desactivada';
            } else {
                $sede->estatus_id = 2;
                $mensaje = 'Entidad Activada';
            }
            $sede->save();
            return response()->json(['code' => 200, 'msg' => $mensaje]);
        }
        return response()->json(['code' => 400, 'msg' => 'Entidad no encontrada']);
    }
}
