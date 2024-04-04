<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                        ->select('users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email', 'users.estatus_id', 'users.rol_id', 'roles.nombre as rol')
                        ->get();

        $roles = Role::select('id', 'nombre')->where('estatus_id', 1)->get();
        $entidades = Sede::select('id', 'nombre')->where('estatus_id', 1)->get();
        
        return view('usuario.index', compact('usuarios', 'roles', 'entidades'));
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
        if ($request->nombre == '' || $request->primer_apellido == '' || $request->email == '' || $request->rol_id == '' || $request->entidad_id == '') {
            return response()->json(['code' => 400, 'msg' => 'Hay campos vacios']);
        }

        DB::beginTransaction();

        try {
            //Se genera PIN para el inicio de sesión, el cual tambien se envía por correo al usuario.
            $pin = $this->generarPin();
            
            $usuario = new User();
            $usuario->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $usuario->primer_apellido = \Helper::capitalizeFirst($request->primer_apellido, "1");
            $usuario->segundo_apellido = (!is_null($request->segundo_apellido) ? \Helper::capitalizeFirst($request->segundo_apellido, "1") : null );
            $usuario->email = $request->email;
            $usuario->email_verified_at = now();
            $usuario->password = Hash::make($pin);
            $usuario->pin = Hash::make($pin);
            $usuario->estatus_id = 1;
            $usuario->dob = '2024-04-01';
            $usuario->avatar = 'images/avatar-1.jpg';
            $usuario->rol_id = $request->rol_id;
            $usuario->sede_id = $request->entidad_id;
            $usuario->save();

            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Usuario creado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user != null) {
            return response()->json(['code' => 200, 'data' => $user]);
        }
        return response()->json(['code' => 400, 'msg' => 'Usuario no encontrado']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->nombre == '' || $request->primer_apellido == '' || $request->email == '' || $request->rol_id == '') {
            return response()->json(['code' => 400, 'msg' => 'Hay campos vacios']);
        }

        DB::beginTransaction();

        try {
            $usuario = User::find($id);
            $usuario->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $usuario->primer_apellido = \Helper::capitalizeFirst($request->primer_apellido, "1");
            $usuario->segundo_apellido = (!is_null($request->segundo_apellido) ? \Helper::capitalizeFirst($request->segundo_apellido, "1") : null );
            $usuario->email = $request->email;
            $usuario->rol_id = $request->rol_id;
            $usuario->sede_id = $request->entidad_id;
            $usuario->save();

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Usuario actualizado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);

        if ($usuario != null) {
            if ($usuario->estatus_id == 1) {
                $usuario->estatus_id = 1;
                $mensaje = 'Usuario Desactivado';
            } else {
                $usuario->estatus_id = 2;
                $mensaje = 'Usuario Activado';
            }
            $usuario->save();
            return response()->json(['code' => 200, 'msg' => $mensaje]);
        }
        return response()->json(['code' => 400, 'msg' => 'Usuario no encontrado']);
    }

    function generarPin() {
        $pin = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < 4;$i++) $pin .= $pattern[mt_rand(0,$max)];
        return $pin;
    }
}
