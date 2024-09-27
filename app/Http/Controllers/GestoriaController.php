<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Venta;
use App\Models\Sede;
use App\Models\Cliente;
use App\Models\Gestoria;
use Illuminate\Http\Request;
use App\Models\GestoriaServicio;
use App\Models\GestoriaSubServicio;
use App\Models\DetalleVentaGestoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
        // Validar si hay un registro en curso
        $venta = \Helper::registroEnCurso();

        if ($venta) {
            $total_checkout = DetalleVentaGestoria::where('venta_id', $venta->id)->sum('precio');
        } else {
            $total_checkout = 0;
        }

        //datos precargados de modales de subservicios
        $subtransacciones = GestoriaSubServicio::where('gestoria_servicio_id', 1)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $rotulosRemovibles = GestoriaSubServicio::where('gestoria_servicio_id', 2)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $subRenovaciones = GestoriaSubServicio::where('gestoria_servicio_id', 3)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $subAprendizajes = GestoriaSubServicio::where('gestoria_servicio_id', 4)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $subConducir = GestoriaSubServicio::where('gestoria_servicio_id', 5)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $subDirecciones = GestoriaSubServicio::where('gestoria_servicio_id', 6)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $subTraspasos = GestoriaSubServicio::where('gestoria_servicio_id', 7)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $subVentasCondicionales = GestoriaSubServicio::where('gestoria_servicio_id', 8)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $subGravamenes = GestoriaSubServicio::where('gestoria_servicio_id', 9)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $subRegistros = GestoriaSubServicio::where('gestoria_servicio_id', 10)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        $subNotificaciones = GestoriaSubServicio::where('gestoria_servicio_id', 11)->where('estatus_id', 1)->select('id', 'nombre', 'costo')->get();
        // dd($cliente);

        return view('modulo.gestoria.index', compact(
                                                    'user',
                                                    'entidades',
                                                    'gestorias',
                                                    'transacciones',
                                                    'licencias',
                                                    'vehiculos',
                                                    'cliente',
                                                    'total_checkout',
                                                    'venta',
                                                    'subtransacciones',
                                                    'rotulosRemovibles',
                                                    'subRenovaciones',
                                                    'subAprendizajes',
                                                    'subConducir',
                                                    'subDirecciones',
                                                    'subTraspasos',
                                                    'subVentasCondicionales',
                                                    'subGravamenes',
                                                    'subRegistros',
                                                    'subNotificaciones'
                                                ));
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

        if ($request->has('fileLicencia')) {
            $file = $request->file('fileLicencia');
            $extension = $file->getClientOriginalExtension();
            $destino = public_path('licencias');
            $filename = time().'.'.$extension;
            $file->move($destino, $filename);
        } else {
            return response()->json(['code' => 400, 'msg' => 'Debe cargar la licencia']);
        }

        DB::beginTransaction();

        try {

            $cliente = Cliente::where('seguro_social', $request->seguro_social)->first();
            
            if ($cliente) {
                $cliente->nombre = \Helper::capitalizeFirst($request->nombre, "1");
                $cliente->email = $request->email;
                $cliente->telefono = $request->telefono;
                $cliente->identificacion = $request->identificacion;
                if ($cliente->estatus_id == 4) {
                    $cliente->estatus_id = 3;
                }
                if (File::exists($cliente->img_licencia)) {
                    File::delete($cliente->img_licencia);
                    $cliente->img_licencia = $filename;
                }

                $cliente->save();

                $venta = Venta::where('cliente_id', $cliente->id)->where('estatus_id', 3)->first();

                if ($venta == null) {
                    //Se crea la venta
                    $venta = new Venta();
                    $venta->estatus_id = 3;
                    $venta->total = 0;
                    $venta->tipo_servicio = 2; //2 es gestoría
                    $venta->usuario_id = Auth::user()->id;
                    $venta->cliente_id = $cliente->id;
                    $venta->save();
                }

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
                $cliente->img_licencia = $filename;
                $cliente->usuario_id = Auth::user()->id;
                $cliente->estatus_id = 3;
                $cliente->tipo_cliente = 2;
                $cliente->save();

                //Se crea la venta
                $venta = new Venta();
                $venta->estatus_id = 3;
                $venta->total = 0;
                $venta->tipo_servicio = 2; //2 es gestoría
                $venta->usuario_id = Auth::user()->id;
                $venta->cliente_id = $cliente->id;
                $venta->save();
                    
                DB::commit();

                return response()->json(['code' => 201, 'msg' => 'Transacción iniciada', 'id' => $cliente->id]);
            }
        }catch (\PDOException $e){
            DB::rollBack();
            return response()->json(['code' => 201, 'msg' => substr($e->getMessage(), 0, 150)]);
        }
    }

    public function addTransaccion(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 1)->first();
        $costo = GestoriaSubServicio::where('id', $request->transaccion_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 1;
        }

        $detalleVentaGestoria->subservicio_id = $request->transaccion_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addTitulo(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 2)->first();
        $costo = GestoriaSubServicio::where('id', $request->titulo_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 2;
        }

        $detalleVentaGestoria->subservicio_id = $request->titulo_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addRenovacion(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 3)->first();
        $costo = GestoriaSubServicio::where('id', $request->renovacion_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 3;
        }

        $detalleVentaGestoria->subservicio_id = $request->renovacion_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addAprendizaje(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 4)->first();
        $costo = GestoriaSubServicio::where('id', $request->aprendizaje_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 4;
        }

        $detalleVentaGestoria->subservicio_id = $request->aprendizaje_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addConducir(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 5)->first();
        $costo = GestoriaSubServicio::where('id', $request->conducir_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 5;
        }

        $detalleVentaGestoria->subservicio_id = $request->conducir_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addDireccion(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 6)->first();
        $costo = GestoriaSubServicio::where('id', $request->direccion_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 6;
        }

        $detalleVentaGestoria->subservicio_id = $request->direccion_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addTraspaso(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 7)->first();
        $costo = GestoriaSubServicio::where('id', $request->traspaso_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 7;
        }

        $detalleVentaGestoria->subservicio_id = $request->traspaso_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addVentaCondicional(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 8)->first();
        $costo = GestoriaSubServicio::where('id', $request->venta_condicional_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 8;
        }

        $detalleVentaGestoria->subservicio_id = $request->venta_condicional_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addGravamen(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 9)->first();
        $costo = GestoriaSubServicio::where('id', $request->gravamen_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 9;
        }

        $detalleVentaGestoria->subservicio_id = $request->gravamen_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addRegistro(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 10)->first();
        $costo = GestoriaSubServicio::where('id', $request->registro_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 10;
        }

        $detalleVentaGestoria->subservicio_id = $request->registro_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function addNotificacion(Request $request) {

        $detalleVentaGestoria = DetalleVentaGestoria::where('venta_id', $request->venta_id)->where('servicio_id', 11)->first();
        $costo = GestoriaSubServicio::where('id', $request->notificacion_id)->select('costo')->pluck('costo')->first();

        if ($detalleVentaGestoria == null) {
            $detalleVentaGestoria = new DetalleVentaGestoria();
            $detalleVentaGestoria->servicio_id = 10;
        }

        $detalleVentaGestoria->subservicio_id = $request->notificacion_id;
        $detalleVentaGestoria->venta_id = $request->venta_id;
        $detalleVentaGestoria->precio = $costo;
        $detalleVentaGestoria->save();

        \Helper::updateTotalVenta($request->venta_id);

        return response()->json(['code' => 200, 'msg' => 'Registro actualizado']);
    }

    public function pendiente(Request $request) {
        $venta = Venta::where('id', $request->venta_id)->first();
        
        if ($venta) {

            DB::beginTransaction();

            try {
                $venta->estatus_id = 5;
                $venta->save();

                $cliente = Cliente::find($venta->cliente_id);
                $cliente->estatus_id = 5;
                $cliente->save();

                DB::commit();

                return response()->json(['code' => 200, 'msg' => 'Transacción pendiente de pago!']);
            
            }catch (\PDOException $e){
                DB::rollBack();
                return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
            }
        } else {
            return response()->json(['code' => 404, 'msg' => 'Transacción no encontrada!']);
        }
    }

    public function cancelar(Request $request) {
        $venta = Venta::where('id', $request->venta_id)->first();
        
        if ($venta) {

            DB::beginTransaction();

            try {
                $venta->estatus_id = 6;
                $venta->motivo =  \Helper::capitalizeFirst($request->motivo, "1");
                $venta->save();

                $cliente = Cliente::find($venta->cliente_id);
                $cliente->estatus_id = 4;
                $cliente->save();

                DB::commit();

                return response()->json(['code' => 200, 'msg' => 'Transacción cancelada!']);
            
            }catch (\PDOException $e){
                DB::rollBack();
                return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
            }
        } else {
            return response()->json(['code' => 404, 'msg' => 'Transacción no encontrada!']);
        }
    }
}
