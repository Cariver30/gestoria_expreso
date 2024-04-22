<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\Mes;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\ClienteVehiculo;
use App\Models\SubServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::select('id', 'nombre', 'estatus_id')->get();
        
        return view('servicio.index', compact('servicios'));
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
            
            $servicio = new Servicio();
            $servicio->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $servicio->estatus_id = 1;
            $servicio->save();

            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Servicio creado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio)
    {
        $servicio = Servicio::find($servicio->id);

        if ($servicio != null) {
            return response()->json(['code' => 200, 'data' => $servicio]);
        }
        return response()->json(['code' => 400, 'msg' => 'Servicio no encontrado']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servicio $servicio)
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
            $servicio = Servicio::find($id);
            $servicio->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $servicio->estatus_id = 1;
            $servicio->save();

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Servicio actualizado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $servicio)
    {
        $servicio = Servicio::find($servicio->id);

        if ($servicio != null) {
            if ($servicio->estatus_id == 1) {
                $servicio->estatus_id = 2;
                $mensaje = 'Servicio deshabilitado';
            } else {
                $servicio->estatus_id = 1;
                $mensaje = 'Servicio habilitado';
            }
            $servicio->save();
            return response()->json(['code' => 200, 'msg' => $mensaje]);
        }
        return response()->json(['code' => 400, 'msg' => 'Servicio no encontrado']);
    }

    public function addSubServicio(Request $request) {
        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El Nombre es requerido']);
        }
        if ($request->id == '') {
            return response()->json(['code' => 400, 'msg' => 'Se requeire el id del servicio principal']);
        }

        DB::beginTransaction();

        try {
            
            $servicio = new SubServicio();
            $servicio->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $servicio->servicio_id = $request->id;
            $servicio->costo = $request->costo;
            $servicio->estatus_id = 1;
            $servicio->save();

            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Sub Servicio creado']);

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    public function getSubServicio($id) {
        $subservicios = SubServicio::where('servicio_id', $id)->get();
        return response()->json(['code' => 200, 'data' => $subservicios]);
    }

    public function getViewInspeccion() {
        $costosInspeccion = SubServicio::where('servicio_id', 1)->get();
        $marbetes = SubServicio::where('servicio_id', 2)->get();
        $seguros = SubServicio::where('servicio_id', 7)->get();
        $meses = Mes::all();
        
        // $cliente_pendientes = Cliente::select('id')->where('usuario_id', Auth::user()->id)->where('estatus_id', 5)->get();
        // if (count($cliente_pendientes) != 0) {
        //     foreach ($cliente_pendientes as $cliente) {
        //         $pendiente = ClienteVehiculo::where('cliente_id', $cliente->id)->where('estatus_id', 3)->first();
        //         if ($pendiente != null) {
        //             $en_curso = 1;       
        //         } else {
        //             $en_curso = 0;
        //         }
        //     }
        // } else {
        //     $en_curso = 0;
        // }
        
        return view('modulo.inspeccion.index', compact('costosInspeccion', 'marbetes', 'seguros', 'meses'));
        // return view('modulo.inspeccion.index', compact('costosInspeccion', 'marbetes', 'seguros', 'en_curso'));
    }

    public function getViewGestoria() {
        return view('modulo.gestoria.index');
    }

    public function getTablilla($tablilla) {
        $tablilla = ClienteVehiculo::where('tablilla', $tablilla)->first();
        if ($tablilla != null) {
            return response()->json(['code' => 200, 'msg' => '¡La tablilla ingresada ya existe!']);
        } else {
            return response()->json(['code' => 001]);
        }
    }
}
