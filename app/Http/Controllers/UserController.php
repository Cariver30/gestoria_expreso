<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role;
use App\Models\Sede;
use App\Mail\UserPin;
use App\Mail\UserPinReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        if (Auth::user()->rol_id == 2) { // Optimizar
            $usuarios = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                            ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                            ->where('sede_id', Auth::user()->sede_id)
                            ->select(
                                'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                                'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede'
                            )->get();
        } else {
            $usuarios = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                            ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                            ->select(
                                'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                                'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede'
                            )->get();
        }

        $roles = Role::select('id', 'nombre')->where('estatus_id', 1)->get();
        
        $entidades = \Helper::entidadUsuario();

        $user = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                    ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                    ->where('users.id', Auth::user()->id)
                    ->select(
                        'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                        'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede', 'sedes.acceso_panel as panel')
                    ->first();
        
        return view('usuario.index', compact('usuarios', 'roles', 'entidades', 'user'));
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
        // dd($request->all());
        if ($request->nombre == '' || $request->primer_apellido == '' || $request->email == '' || $request->rol_id == '' || $request->pin == '') {
            return response()->json(['code' => 400, 'msg' => 'Hay campos vacíos']);
        }

        $valida_pin = User::where('pin', $request->pin)->first();
        if ($valida_pin) {
            return response()->json(['code' => 400, 'msg' => '¡El PIN ingresado ya existe!']);
        }

        DB::beginTransaction();

        try {
            $pin = $request->pin;
            
            $user = new User();
            $user->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $user->primer_apellido = \Helper::capitalizeFirst($request->primer_apellido, "1");
            $user->segundo_apellido = (!is_null($request->segundo_apellido) ? \Helper::capitalizeFirst($request->segundo_apellido, "1") : null );
            $user->email = $request->email;
            $user->email_verified_at = now();
            $user->password = Hash::make($pin);
            $user->pin = $pin;
            $user->estatus_id = 1;
            $user->dob = '2024-04-01';
            $user->avatar = 'images/user-dummy-img.jpg';
            $user->rol_id = $request->rol_id;
            $user->sede_id = ($request->rol_id == 1) ? 1 : $request->entidades[0];
            $user->save();

            $entidades = $request->entidades;
            foreach ($entidades as $entidad) {
                DB::table('usuario_sedes')->insert([
                    'usuario_id' => $user->id,
                    'sede_id' => $entidad 
                ]);
            }

            DB::commit();

            Mail::to($user->email)->send(new UserPin($user, $pin));
            // Mail::to('xbox.07@hotmail.com')->cc('yamihdz@gmail.com')->send(new UserPin($user, $pin));
            // Mail::to('xbox.07@hotmail.com')->send(new UserPin($user, $pin));

            return response()->json(['code' => 201, 'msg' => 'Usuario creado']);

        }catch (\PDOException $e){
            DB::rollBack();
            dd($e);
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
        // dd($request->all());
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
            $usuario->pin = $request->pin;
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
                $usuario->estatus_id = 2;
                $mensaje = 'Usuario suspendido';
            } else {
                $usuario->estatus_id = 1;
                $mensaje = 'Usuario activado';
            }
            $usuario->save();
            // dd($mensaje);
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

    function marcarInicio() {

        $date = Carbon::now();
        $date = $date->format('Y-m-d');

        $user = User::find(Auth::user()->id);
        $user->marcar_inicio = $date;
        $user->save();
        
        return response()->json(['code' => 200]);
    }

    function cambiarEntidad($id) {
        
        $user = User::find(Auth::user()->id);
        $user->sede_id = $id;
        $user->save();

        return response()->json(['code' => 200, 'msg' => '¡Cambio de sede correctamente!']);
    }

    function resetPin($id) {
        // dd($id);
        //Se genera PIN para el inicio de sesión, el cual tambien se envía por correo al usuario.
        $flag = true;

        while ($flag == true) {
            $pin = $this->generarPin();
            $valida_pin = User::where('pin', $pin)->first();
            if ($valida_pin == null) {
                $flag = false;
            }
        }

        if ($flag == false) {
            $user = User::find($id);
            $user->pin = $pin;
            $user->save();

            $nombre = $user->nombre;

            Mail::to('xbox.07@hotmail.com')->cc('yamihdz@gmail.com')->send(new UserPinReset($nombre, $pin));

            return response()->json(['code' => 200, 'msg' => '¡PIN resetado correctamente!']);
        }
    }
}
