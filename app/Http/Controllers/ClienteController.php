<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Sede;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\SubServicio;
use Illuminate\Http\Request;
use App\Models\ClienteVehiculo;
use App\Models\VehiculoMarbete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();

        $user = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                    ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                    ->where('users.id', Auth::user()->id)
                    ->select(
                        'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                        'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede', 'sedes.acceso_panel as panel')
                    ->first();
                    
        $entidades = Sede::where('estatus_id', 1)->select('id', 'nombre')->get();

        return view('cliente.index', compact('clientes', 'user', 'entidades'));
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
        // dd( $request->costo_inspeccion);
        if ($request->nombre == '' || $request->email == '' || $request->telefono == '' || $request->compania == '' || $request->vehiculo == '' || $request->tablilla == '' || $request->marca == '' || $request->anio == '' || $request->seguro_social == '' || $request->mes_vencimiento == '' || $request->identificacion == '') {
            return response()->json(['code' => 400, 'msg' => 'Hay campos vacíos']);
        }

        DB::beginTransaction();

        try {
            //Se crea el cliente
            $cliente = new Cliente();
            $cliente->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $cliente->email = $request->email;
            $cliente->telefono = $request->telefono;
            $cliente->seguro_social = $request->seguro_social;
            $cliente->identificacion = $request->identificacion;
            $cliente->img_licencia = 'path/img_licencia';
            $cliente->usuario_id = Auth::user()->id;
            $cliente->estatus_id = 3;
            $cliente->save();

            //Se crea el vehículo
            $clienteVehiculo = new ClienteVehiculo();
            $clienteVehiculo->compania = \Helper::capitalizeFirst($request->compania, "1");
            $clienteVehiculo->vehiculo = \Helper::capitalizeFirst($request->vehiculo, "1");
            $clienteVehiculo->tablilla = $request->tablilla;
            $clienteVehiculo->marca = \Helper::capitalizeFirst($request->marca, "1");
            $clienteVehiculo->anio = $request->anio;
            $clienteVehiculo->mes_vencimiento_id = $request->mes_vencimiento;
            $clienteVehiculo->cliente_id = $cliente->id;
            $clienteVehiculo->estatus_id = 3;
            $clienteVehiculo->save();

            //Se crea la venta
            $venta = new Venta();
            $venta->costo_inspeccion_id = ($request->costo_inspeccion == 0) ? null : $request->costo_inspeccion ;
            $venta->costo_inspeccion_admin = ($request->costo_inspeccion_admin == null) ? null : $request->costo_inspeccion_admin;
            $venta->costo_servicio_fijo = 0;
            //Se va calculando el total
            if ($request->costo_inspeccion != 0) {
                $costoInspección = SubServicio::where('id', $request->costo_inspeccion)->select('costo')->pluck('costo')->first();
            } else {
                $costoInspección = $request->costo_inspeccion_admin;
            }

            $total = $costoInspección + $venta->costo_servicio_fijo;
            $venta->total = $total;
            $venta->vehiculo_id = $clienteVehiculo->id;
            $venta->save();
            
            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Cliente registrado', 'id' => $cliente->id]);

        }catch (\PDOException $e){
            DB::rollBack();
            return response()->json(['code' => 201, 'msg' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }

    public function vehiculoMarbete(Request $request) {
        // dd($request->all());

        DB::beginTransaction();

        try {
            $cliente_id = Cliente::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->select('id')->pluck('id')->first();
            $vehiculo_id = ClienteVehiculo::where('estatus_id', 3)->where('cliente_id', $cliente_id)->select('id')->pluck('id')->first();
            $venta = Venta::where('vehiculo_id', $vehiculo_id)->first();

            $venta->costo_marbete_id = ($request->marbete_id == null) ? null : $request->marbete_id;
            $venta->costo_marbete_admin = ($request->costo_marbete_admin == null) ? null : $request->costo_marbete_admin;
            $venta->costo_servicio_fijo = $request->marbete_five_id;

            //Se suma al total
            if ($request->marbete_id != 0) {
                $costoMarbete = SubServicio::where('id', $request->marbete_id)->select('costo')->pluck('costo')->first();
            } else {
                $costoMarbete = $request->costo_marbete_admin;
            }
            // dd($costoMarbete);

            $total = $venta->total + $costoMarbete + $request->marbete_five_id;
            // dd($total);
            $venta->total = $total;
            $venta->save();
            // $marbeteVehiculo = VehiculoMarbete::where('vehiculo_id', $vehiculo_id)->first();

            // if (!$marbeteVehiculo) {
            //     $marbeteVehiculo = new VehiculoMarbete();
            // } 
            // $marbeteVehiculo->vehiculo_id = $vehiculo_id;
            // $marbeteVehiculo->marbete_id = ($request->marbete_id == null) ? null : $request->marbete_id;
            // $marbeteVehiculo->marbete_admin = ($request->costo_marbeta_admin == null) ? null : $request->costo_marbeta_admin;

            // $marbeteVehiculo->save();
            
            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Marbete registrado']);

        }catch (\PDOException $e){
            DB::rollBack();
            dd($e);
            return response()->json(['code' => 201, 'msg' => substr($e->getMessage(), 0, 150)]);
        }
    }
}
