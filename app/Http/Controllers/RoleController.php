<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::select('id', 'nombre', 'estatus_id')->get();

        return view('rol.index', compact('roles'));
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

        DB::beginTransaction();

        try {
            
            $rol = new Role();
            $rol->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $rol->estatus = 1;
            $rol->save();

            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Rol creado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $rol = Role::find($role->id);

        if ($rol != null) {
            return response()->json(['code' => 200, 'data' => $rol]);
        }
        return response()->json(['code' => 400, 'msg' => 'Rol no encontrado']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El nombre es requerido']);
        }

        DB::beginTransaction();

        try {
            
            $rol = Role::find($id);
            $rol->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $rol->save();

            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Rol actualizado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $rol = Role::find($role->id);

        if ($rol != null) {
            if ($rol->estatus_id == 1) {
                $rol->estatus_id = 2;
                $mensaje = 'Rol deshabilitado';
            } else {
                $rol->estatus_id = 1;
                $mensaje = 'Rol habilitado';
            }
            $rol->save();
            
            return response()->json(['code' => 200, 'msg' => $mensaje]);
        }
        return response()->json(['code' => 400, 'msg' => 'Estatus no encontrado']);
    }
}