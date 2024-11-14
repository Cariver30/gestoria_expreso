<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\Mes;
use App\Models\User;
use App\Models\Sede;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\SubServicio;
use Illuminate\Http\Request;
use App\Models\DetalleVenta;
use App\Models\ClienteVehiculo;
use App\Models\VehiculoMarbete;
use App\Models\DetalleVentaGestoria;
use Illuminate\Support\Facades\Auth;
use App\Models\DetalleVentaInspeccion;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::leftJoin('estatus', 'clientes.estatus_id', 'estatus.id')
                            ->select('clientes.id', 'clientes.nombre', 'clientes.estatus_id', 'estatus.nombre as estatus', 'clientes.seguro_social')
                            ->get();

        $user = \Helper::getInfoUsuario();
        $entidades = \Helper::entidadUsuario();
        $meses = Mes::select('id', 'nombre')->get();

        $seguros_sociales = Cliente::select('id', 'nombre', 'seguro_social')->get();
        $tablillas = ClienteVehiculo::select('id', 'vehiculo', 'tablilla')->get();

        return view('cliente.index', compact('clientes', 'user', 'entidades', 'meses', 'seguros_sociales', 'tablillas'));
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

        if ($request->seguro_social == '' || $request->nombre == '' || $request->email == '' || $request->telefono == '' || $request->compania == '' || $request->vehiculo == '' || $request->tablilla == '' || $request->marca == '' || $request->anio == '' || $request->mes_vencimiento == '' || $request->identificacion == '') {
            return response()->json(['code' => 400, 'msg' => 'Hay campos vacíos']);
        }

        DB::beginTransaction();

        try {

            $venta = Venta::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->first();

            if ($venta) {
                $cliente_existente = Cliente::where('id', $venta->cliente_id)->first();
                $cliente_existente->nombre = \Helper::capitalizeFirst($request->nombre, "1");
                $cliente_existente->email = $request->email;
                $cliente_existente->telefono = $request->telefono;
                $cliente_existente->seguro_social = $request->seguro_social;
                $cliente_existente->identificacion = $request->identificacion;

                if ($request->has('fileInspeccion')) {
                    if (File::exists($cliente_existente->img_licencia)) {
                        File::delete($cliente_existente->img_licencia);
                    }

                    $file = $request->file('fileInspeccion');
                    $extension = $file->getClientOriginalExtension();
                    $destino = public_path('licencias');
                    $filename = time().'.'.$extension;
                    $file->move($destino, $filename);
                    
                    $cliente_existente->img_licencia = $filename;
                }
                $cliente_existente->save();

                $costo = SubServicio::where('id', $request->valorInspeccion)->select('costo')->pluck('costo')->first();

                $detalleVentaInspeccion = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 1)->first();
                $detalleVentaInspeccion->subservicio_id = $request->valorInspeccion;
                $detalleVentaInspeccion->precio = $costo;
                $detalleVentaInspeccion->save();

                DB::commit();
                
                $msg = 'Transacción actualizada';
                
                \Helper::updateTotalVentaInspeccion($venta->id);
                    
                return response()->json(['code' => 200, 'msg' => $msg]);

            } else {
                
                //Validación de archivo de licencia
                if (!$request->has('fileInspeccion')) {
                    return response()->json(['code' => 400, 'msg' => 'Debe cargar la licencia']);
                }

                //Se crea el cliente
                $cliente = new Cliente();
                $cliente->nombre = \Helper::capitalizeFirst($request->nombre, "1");
                $cliente->email = $request->email;
                $cliente->telefono = $request->telefono;
                $cliente->seguro_social = $request->seguro_social;
                $cliente->identificacion = $request->identificacion;
                
                //Se guarda la imagen de la licencia
                $file = $request->file('fileInspeccion');
                $extension = $file->getClientOriginalExtension();
                $destino = public_path('licencias');
                $filename = time().'.'.$extension;
                $file->move($destino, $filename);
                
                $cliente->img_licencia = $filename;
                $cliente->tipo_cliente = 1; // 1 es Inspección
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
                $clienteVehiculo->estatus_id = 1;
                $clienteVehiculo->save();
                
                //Se crea la venta
                $venta = new Venta();
                $venta->total = 0;
                $venta->estatus_id = 3;
                $venta->usuario_id = Auth::user()->id;
                $venta->tipo_servicio = 1; //1 es inspección
                $venta->vehiculo_id = $clienteVehiculo->id;
                $venta->cliente_id = $cliente->id;
                $venta->save();
                
                
                $costo = SubServicio::where('id', $request->valorInspeccion)->select('costo')->pluck('costo')->first();
                
                $detalleVentaInspeccion = new DetalleVentaInspeccion();
                $detalleVentaInspeccion->servicio_id = 1;
                $detalleVentaInspeccion->subservicio_id = $request->valorInspeccion; 
                $detalleVentaInspeccion->venta_id = $venta->id;
                $detalleVentaInspeccion->precio = $costo;
                $detalleVentaInspeccion->save();
                
                $msg = 'Transacción iniciada';
                
                DB::commit();
                
                \Helper::updateTotalVentaInspeccion($venta->id);
                    
                return response()->json(['code' => 201, 'msg' => $msg]);
            }
        }catch (\PDOException $e){
            DB::rollBack();
            dd($e);
            return response()->json(['code' => 201, 'msg' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //$cliente = Cliente::select('id', 'nombre', 'email', 'telefono', 'seguro_social', 'identificacion')->where('id', $cliente->id)->first();
        
        //return response()->json(['code' => 200, 'data' => $cliente]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $entidades = \Helper::entidadUsuario();
        $cliente = Cliente::select('id', 'nombre', 'email', 'telefono', 'seguro_social', 'identificacion', 'tipo_cliente', 'img_licencia')->where('id', $cliente->id)->first();
        // dd($cliente);
        if ($cliente->tipo_cliente == 1) {
            $vehiculos = ClienteVehiculo::leftJoin('estatus', 'cliente_vehiculos.estatus_id', 'estatus.id')
                                            ->where('cliente_id', $cliente->id)
                                            ->select(
                                                'cliente_vehiculos.id',
                                                'cliente_vehiculos.compania',
                                                'cliente_vehiculos.vehiculo',
                                                'cliente_vehiculos.tablilla',
                                                'cliente_vehiculos.marca',
                                                'cliente_vehiculos.anio',
                                                'cliente_vehiculos.estatus_id',
                                                'cliente_vehiculos.created_at',
                                                'estatus.nombre as estatus'
                                            )->get();
                                            // dd($vehiculos);
    
            
            $ordenes = Venta::leftJoin('estatus', 'ventas.estatus_id', 'estatus.id')
                                ->where('cliente_id', $cliente->id)
                                ->select('ventas.id', 'ventas.total', 'ventas.fecha_pago', 'ventas.tipo_pago', 'estatus.id as estatus_id', 'estatus.nombre as estatus', 'ventas.updated_at', 'ventas.motivo', 'ventas.tipo_servicio')
                                ->get();

                                
            foreach ($ordenes as $orden) {
                if ($orden->tipo_servicio == 1) {
                    $serv_insp = DetalleVentaInspeccion::where('venta_id', $orden->id)->where('servicio_id', 1)->select('subservicio_id')->pluck('subservicio_id')->first();
                    $orden->serv_insp = $serv_insp;
                }
            
            }
            // dd($ordenes);

            return view('cliente.edit', compact('entidades', 'cliente', 'vehiculos', 'ordenes'));

        } else {
            $data = 1;
            $ordenes = Venta::leftJoin('estatus', 'ventas.estatus_id', 'estatus.id')
                                ->where('cliente_id', $cliente->id)
                                ->select('ventas.id', 'ventas.total', 'ventas.fecha_pago', 'ventas.tipo_pago', 'estatus.id as estatus_id', 'estatus.nombre as estatus', 'ventas.updated_at', 'ventas.motivo')
                                ->get();
            
                                // dd($ordenes);
            
            $servicios = array();
            if (count($ordenes) == 1 && $ordenes[0]->estatus_id == 6){
                $data = 0;
            } else {
                foreach ($ordenes as $orden) {
                    $detalles = DetalleVentaGestoria::leftJoin('gestoria_sub_servicios', 'detalle_venta_gestorias.subservicio_id', 'gestoria_sub_servicios.id')
                                        ->where('venta_id', $orden->id)
                                        ->select('gestoria_sub_servicios.nombre as nombre', 'gestoria_sub_servicios.costo as costo', 'gestoria_sub_servicios.created_at')
                                        ->get()->toArray();

                    foreach ($detalles as $detalle) {
                        array_push($servicios, $detalle);
                    }
                }
                $data = 2;
            }

            // dd($data);
            return view('cliente.edit', compact('entidades', 'cliente', 'ordenes', 'data', 'servicios'));
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {

        $input = $request->all();

        $rules = [
            'nombre' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'seguro_social' => 'required',
            'identificacion' => 'required'
        ];

        $messages = [
            'nombre.required'   => 'El nombre es un campo requerido',
            'email.required'   => 'El email es un campo requerido',
            'telefono.required'   => 'El telefono es un campo requerido',
            'seguro_social.required'   => 'El seguro_social es un campo requerido',
            'identificacion.required'   => 'El seguro_social es un campo requerido'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            
            $cliente = Cliente::find($cliente->id);
            $cliente->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $cliente->email = $request->email;
            $cliente->telefono = $request->telefono;
            $cliente->email = $request->email;
            $cliente->seguro_social = $request->seguro_social;
            $cliente->identificacion = $request->identificacion;
            $cliente->save();

            DB::commit();

            Session::flash('success', 'Cliente actualizado');
            return redirect()->route('clientes.index');

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
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
            $venta = Venta::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->first();

            $costo = SubServicio::where('id', $request->marbete_id)->select('costo')->pluck('costo')->first();

            $detalleVentaInspMarbete = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 2)->first();
            // dd($detalleVentaInspMarbete);
            
            if ($detalleVentaInspMarbete == null) {
                $detalleVentaInspMarbete = new DetalleVentaInspeccion();
            } 

            $detalleVentaInspMarbete->subservicio_id = $request->marbete_id;
            $detalleVentaInspMarbete->servicio_id = 2;
            $detalleVentaInspMarbete->precio = $costo;
            $detalleVentaInspMarbete->venta_id = $venta->id;
            $detalleVentaInspMarbete->save();
            
            $venta->costo_servicio_fijo = ($request->marbete_five_id == 1) ? 5 : null ;
            $venta->derechos_anuales = $request->derecho_anual;
            $venta->save();


            //Marbete ACCA
            $detalleVentaInspMarbeteAcca = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 10)->first();
            // dd($detalleVentaInspMarbeteAcca);

            if ($detalleVentaInspMarbeteAcca == null) {
                $detalleVentaInspMarbeteAcca = new DetalleVentaInspeccion();
            }

            $costo = SubServicio::where('id', $request->marbete_acaa_id)->select('costo')->pluck('costo')->first();
            $detalleVentaInspMarbeteAcca->subservicio_id = $request->marbete_acaa_id;
            $detalleVentaInspMarbeteAcca->servicio_id = 10;
            $detalleVentaInspMarbeteAcca->venta_id = $venta->id;
            $detalleVentaInspMarbeteAcca->precio = $costo;
            $detalleVentaInspMarbeteAcca->save();

            $total = \Helper::updateTotalVentaInspeccion($venta->id);
            
            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Transacción con marbete actualizada']);

        }catch (\PDOException $e){
            DB::rollBack();
            return response()->json(['code' => 201, 'msg' => substr($e->getMessage(), 0, 150)]);
        }
    }

    // Public function vehiculoMarbeteAcaa(Request $request) {
        
    //     DB::beginTransaction();

    //     try {
            
    //         $venta = Venta::where('id', $request->venta_id)->first();
    //         $venta->costo_marbete_acaa_id = $request->marbete_acaa_id;
    //         $venta->save();

    //         $total = \Helper::getTotalCheckout($venta->id);

    //         DB::table('ventas')->where('id', $venta->id)->update(['total' => $total]);
            
    //         DB::commit();

    //         return response()->json(['code' => 201, 'msg' => 'Marbete actualizado']);

    //     }catch (\PDOException $e){
    //         DB::rollBack();
    //         return response()->json(['code' => 201, 'msg' => substr($e->getMessage(), 0, 150)]);
    //     }
    // }

    Public function vehiculoSeguro(Request $request) {

        // Seguros con id=1 y id=2 son preestablecidos, ya que son los seguros que se restan
        $venta = Venta::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->first();

        $costo = SubServicio::where('id', $request->seguro_id)->select('costo')->pluck('costo')->first();
        
        //Se registra en el detalle validando si ya existe primero si es asi, lo actualiza.
        $detalleVentaInspSeguro = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 3)->first();
        
        if ($detalleVentaInspSeguro == null) {
            $detalleVentaInspSeguro = new DetalleVentaInspeccion();
        } 

        $detalleVentaInspSeguro->subservicio_id = $request->seguro_id;
        $detalleVentaInspSeguro->servicio_id = 3;
        $detalleVentaInspSeguro->precio = $costo;
        $detalleVentaInspSeguro->venta_id = $venta->id;
        $detalleVentaInspSeguro->save();
        
        $total = \Helper::updateTotalVentaInspeccion($venta->id);
            
        DB::commit();

        return response()->json(['code' => 200, 'msg' => 'Transacción con seguro actualizado']);
    }

    public function vehiculoExtraLicencia(Request $request) {
        
        $venta = Venta::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->first();

        $costo = SubServicio::where('id', $request->licencia_id)->select('costo')->pluck('costo')->first();
        
        //Se registra en el detalle validando si ya existe primero si es asi, lo actualiza.
        $detalleVentaInspSeguro = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 4)->first();
        
        if ($detalleVentaInspSeguro == null) {
            $detalleVentaInspSeguro = new DetalleVentaInspeccion();
        } 

        $detalleVentaInspSeguro->subservicio_id = $request->licencia_id;
        $detalleVentaInspSeguro->servicio_id = 4;
        $detalleVentaInspSeguro->precio = $costo;
        $detalleVentaInspSeguro->venta_id = $venta->id;
        $detalleVentaInspSeguro->save();
        
        $total = \Helper::updateTotalVentaInspeccion($venta->id);
            
        DB::commit();

        return response()->json(['code' => 200, 'msg' => 'Transacción con servicio extra actualizado']);
    }

    public function vehiculoExtraNotificacion(Request $request) {
        
        $venta = Venta::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->first();

        $costo = SubServicio::where('id', $request->notificacion_id)->select('costo')->pluck('costo')->first();
        
        //Se registra en el detalle validando si ya existe primero si es asi, lo actualiza.
        $detalleVentaInspSeguro = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 5)->first();
        
        if ($detalleVentaInspSeguro == null) {
            $detalleVentaInspSeguro = new DetalleVentaInspeccion();
        } 

        $detalleVentaInspSeguro->subservicio_id = $request->notificacion_id;
        $detalleVentaInspSeguro->servicio_id = 5;
        $detalleVentaInspSeguro->precio = $costo;
        $detalleVentaInspSeguro->venta_id = $venta->id;
        $detalleVentaInspSeguro->save();
        
        $total = \Helper::updateTotalVentaInspeccion($venta->id);
            
        DB::commit();

        return response()->json(['code' => 200, 'msg' => 'Transacción con servicio extra actualizado']);
    }

    public function vehiculoExtraMulta(Request $request) {
        // dd($request->all());
        $venta = Venta::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->first();
        $costo = SubServicio::where('id', $request->multa_id)->select('costo')->pluck('costo')->first();

        //Se registra en el detalle validando si ya existe primero si es asi, lo actualiza.
        $detalleVentaInspExtraMulta = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 9)->first();
        
        if ($detalleVentaInspExtraMulta == null) {
            $detalleVentaInspExtraMulta = new DetalleVentaInspeccion();
        } 

        $detalleVentaInspExtraMulta->subservicio_id = $request->multa_id;
        $detalleVentaInspExtraMulta->servicio_id = 9;
        $detalleVentaInspExtraMulta->precio = $costo;
        $detalleVentaInspExtraMulta->venta_id = $venta->id;
        $detalleVentaInspExtraMulta->save();
        
        $total = \Helper::updateTotalVentaInspeccion($venta->id);
            
        DB::commit();

        return response()->json(['code' => 200, 'msg' => 'Transacción con servicio extra actualizado']);
    }

    public function getTablillaCliente(Request $request) {

        $cliente = Cliente::where('id', $request->idCliente)->select('id', 'nombre', 'seguro_social', 'email', 'telefono', 'identificacion')->first();
        if ($cliente != null) {
            $vehiculos = ClienteVehiculo::where('cliente_id', $cliente->id)->select('vehiculo', 'tablilla')->get();

            return response()->json(['code' => 200, 'vehiculos' => $vehiculos, 'cliente' => $cliente]);
        } else {
            return response()->json(['code' => 400, 'msg' => 'Cliente no existente']);
        }
    }
    public function getTablillaVehiculoCliente(Request $request) {
        
        $vehiculo = ClienteVehiculo::where('tablilla', $request->getDataTablilla)->select('id', 'compania', 'vehiculo', 'marca', 'anio', 'mes_vencimiento_id', 'tablilla')->get();

        if ($vehiculo != null) {

            return response()->json(['code' => 200, 'vehiculo' => $vehiculo]);
        } else {
            return response()->json(['code' => 400, 'msg' => 'Vehículo no existente']);
        }
    }

    Public function getClientes() {
        
        $clientes = Cliente::leftJoin('estatus', 'clientes.estatus_id', 'estatus.id')
                            ->select('clientes.id', 'clientes.nombre', 'clientes.estatus_id', 'estatus.nombre as estatus', 'clientes.seguro_social' )
                            ->get();

                            // dd($clientes);

        return response()->json($clientes);
    }

    public function getClientesFilter($valor) {
        // dd($valor);

        //Seguro social
        $cliente = Cliente::where('seguro_social', $valor)->select('clientes.id', 'clientes.nombre', 'clientes.estatus_id', 'clientes.seguro_social' )->get();

        if (count($cliente) == 0) {
            $cliente_id = ClienteVehiculo::where('tablilla', $valor)->select('cliente_id')->pluck('cliente_id')->first();
            $cliente = Cliente::where('id', $cliente_id)->select('clientes.id', 'clientes.nombre', 'clientes.estatus_id', 'clientes.seguro_social' )->get();
            

            if (count($cliente) == 0) {
                $cliente_id = ClienteVehiculo::where('mes_vencimiento_id', $valor)->select('cliente_id')->pluck('cliente_id')->first();
                $cliente = Cliente::where('id', $cliente_id)->select('clientes.id', 'clientes.nombre', 'clientes.estatus_id', 'clientes.seguro_social' )->get();
            }
        }

        return response()->json($cliente);
    }
}


