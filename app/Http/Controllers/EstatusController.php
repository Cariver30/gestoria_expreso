<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Estatus;
use Illuminate\Http\Request;

class EstatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estatus = Estatus::select('id', 'nombre')->get();

        return view('estatus.index', compact('estatus'));
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
            return response()->json(['code' => 400, 'msg' => 'El nombre es un campo requerido']);
        }

        DB::beginTransaction();

        try {
            $estatus = new Estatus();
            $estatus->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $estatus->save();

            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Estatus creado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Estatus $estatus)
    {
        $estatus = Estatus::find($estatus->id);

        if ($estatus != null) {
            return response()->json(['code' => 200, 'data' => $estatus]);
        }
        return response()->json(['code' => 400, 'msg' => 'Estatus no encontrado']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estatus $estatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El nombre es un campo requerido']);
        }

        DB::beginTransaction();

        try {
            $estatus = Estatus::find($id);
            $estatus->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $estatus->save();

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Estatus actualizado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estatus $estatus)
    {
        $estatus = Estatus::find($estatus->id);

        if ($estatus != null) {
            $result = $estatus->delete();
            if ($result) {
                return response()->json(['code' => 200, 'msg' => 'Estatus eliminado']);
            }
            return response()->json(['code' => 400, 'msg' => 'Ocurrió un error']);
        }
        return response()->json(['code' => 400, 'msg' => 'Estatus no encontrado']);
    }
}
