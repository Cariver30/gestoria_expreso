<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Sede;
use App\Models\Estatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estatus = Estatus::select('id', 'nombre')->get();

        $user = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                    ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                    ->where('users.id', Auth::user()->id)
                    ->select(
                        'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                        'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede', 'sedes.acceso_panel as panel')
                    ->first();

        $entidades = Sede::where('estatus_id', 1)->select('id', 'nombre')->get();

        return view('estatus.index', compact('estatus', 'user', 'entidades'));
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
