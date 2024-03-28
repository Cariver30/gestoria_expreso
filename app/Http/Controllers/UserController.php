<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\User;
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
        $usuarios = User::select('users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email')->get();

        return view('usuario.index', compact('usuarios'));
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
        $input = $request->all();

        $rules = [
            'nombre' => 'required',
            'primer_apellido' => 'required',
            'email' => 'required',
            //'perfil_id' => 'required'
        ];

        $messages = [
            'nombre.required'   => 'El nombre es un campo requerido',
            'primer_apellido.required'   => 'El primer apellido es un campo requerido',
            'email.required'   => 'El email es un campo requerido',
            //'perfil_id.required'   => 'El perfil es un campo requerido'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
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
            $usuario->dob = '2024-04-01';
            $usuario->avatar = 'images/avatar-1.jpg';
            $usuario->save();

            DB::commit();

            Session::flash('success', 'Usuario registrado');
            return redirect()->route('usuario.index');

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $rules = [
            'nombre' => 'required',
            'primer_apellido' => 'required',
            'email' => 'required',
            //'perfil_id' => 'required'
        ];

        $messages = [
            'nombre.required'   => 'El nombre es un campo requerido',
            'primer_apellido.required'   => 'El primer apellido es un campo requerido',
            'email.required'   => 'El email es un campo requerido',
            //'perfil_id.required'   => 'El perfil es un campo requerido'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            
            $usuario = User::find($id);
            $usuario->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $usuario->primer_apellido = \Helper::capitalizeFirst($request->primer_apellido, "1");
            $usuario->segundo_apellido = (!is_null($request->segundo_apellido) ? \Helper::capitalizeFirst($request->segundo_apellido, "1") : null );
            $usuario->email = $request->email;
            $usuario->password = ($request->pin != null) ? Hash::make($request->pin) : $usuario->pin ;
            $usuario->pin = ($request->pin != null) ? Hash::make($request->pin) : $usuario->pin ;
            //$usuario->perfil_id = $request->perfil_id;
            $usuario->save();

            DB::commit();

            Session::flash('success', 'Usuario actualizado');
            return redirect()->route('usuario.index');

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
        //
    }

    function generarPin() {
        $pin = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
        $max = strlen($pattern)-1;
        for($i=0;$i < 4;$i++) $pin .= $pattern[mt_rand(0,$max)];
        return $pin;
    }
}
