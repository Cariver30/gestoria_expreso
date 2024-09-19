<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Sede;
use App\Models\Cliente;
use App\Models\Gestoria;
use Illuminate\Http\Request;
use App\Models\GestoriaServicio;
use App\Models\GestoriaSubServicio;
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

        $cliente = Cliente::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->first();
        $total_checkout = 0;
        // Validar si hay un registro en curso
        $venta = \Helper::registroEnCurso();
        // dd($cliente);

        return view('modulo.gestoria.index', compact('user', 'entidades', 'gestorias', 'transacciones', 'licencias', 'vehiculos', 'cliente', 'total_checkout', 'venta'));
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
            // dd( $subservicios);
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

    public function updateSubServicio(Request $request, $id) {
        // dd($id);
        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El Nombre es requerido']);
        }

        DB::beginTransaction();

        try {
            
            $sub_servicio = GestoriaServicio::find($id);
            $sub_servicio->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $sub_servicio->save();

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Sub Servicio actualizado']);

        }catch (\PDOException $e){
            DB::rollBack();
            // dd($e);
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    public function getSubServicios($id) {
        $servicio = GestoriaServicio::where('id', $id)->select('nombre')->first();
        $subservicios = GestoriaSubServicio::where('gestoria_servicio_id', $id)->select('id', 'nombre', 'costo')->get();
        $entidades = Sede::where('estatus_id', 1)->select('id', 'nombre')->get();
        
        return view('modulo.gestoria.admin.editSubServicioTable', compact('id', 'servicio', 'subservicios', 'entidades'));
    }

    public function addSubServicioUltimo(Request $request) {

        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El nombre es requerido']);
        }

        DB::beginTransaction();

        try {
            $ss_gestoria = new GestoriaSubServicio();
            $ss_gestoria->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $ss_gestoria->costo = $request->costo;
            $ss_gestoria->gestoria_servicio_id = $request->s_gestoria_id;
            $ss_gestoria->estatus_id = 1;
            $ss_gestoria->save();

            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Sub servicio '.$request->nombre.' registrado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    public function upSubServicioUltimo(Request $request, $id) {

        // dd($id);
        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El nombre es requerido']);
        }

        DB::beginTransaction();

        try {
            $ss_gestoria = GestoriaSubServicio::find($id);
            $ss_gestoria->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $ss_gestoria->costo = $request->costo;
            $ss_gestoria->save();

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Sub servicio '.$request->nombre.' actualizado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    public function crearCliente(Request $request) {

        if ($request->nombre == '' || $request->email == '' || $request->telefono == '' || $request->seguro_social == '' || $request->identificacion == '') {
            return response()->json(['code' => 400, 'msg' => 'Hay campos vacíos']);
        }

        DB::beginTransaction();

        try {

            $cliente = Cliente::where('seguro_social', $request->seguro_social)->first();

            if ($cliente) {
                $cliente->nombre = \Helper::capitalizeFirst($request->nombre, "1");
                $cliente->email = $request->email;
                $cliente->telefono = $request->telefono;
                $cliente->identificacion = $request->identificacion;
                $cliente->save();

                DB::commit();

                return response()->json(['code' => 200, 'msg' => 'Datos actualizados', 'id' => $cliente->id]);
            } else {
                //Se crea el cliente
                $cliente = new Cliente();
                $cliente->nombre = \Helper::capitalizeFirst($request->nombre, "1");
                $cliente->email = $request->email;
                $cliente->telefono = $request->telefono;
                $cliente->seguro_social = $request->seguro_social;
                $cliente->identificacion = $request->identificacion;
                $cliente->img_licencia = 'N/A';
                $cliente->usuario_id = Auth::user()->id;
                $cliente->estatus_id = 3;
                $cliente->save();
                    
                DB::commit();

                return response()->json(['code' => 201, 'msg' => 'Transacción iniciada', 'id' => $cliente->id]);
            }
        }catch (\PDOException $e){
            DB::rollBack();
            return response()->json(['code' => 201, 'msg' => substr($e->getMessage(), 0, 150)]);
        }
    }
}
