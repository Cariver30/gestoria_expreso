<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\Mes;
use App\Models\User;
use App\Models\Sede;
use App\Models\Venta;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\SubServicio;
use Illuminate\Http\Request;
use App\Models\ClienteVehiculo;
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

        $user = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                    ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                    ->where('users.id', Auth::user()->id)
                    ->select(
                        'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                        'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede', 'sedes.acceso_panel as panel')
                    ->first();
        
        $entidades = \Helper::entidadUsuario();
        
        return view('servicio.index', compact('servicios', 'user', 'entidades'));
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
        if ($request->servicio_id == '') {
            return response()->json(['code' => 400, 'msg' => 'Se requiere el id del servicio principal']);
        }

        DB::beginTransaction();

        try {
            
            $servicio = new SubServicio();
            $servicio->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $servicio->servicio_id = $request->servicio_id;
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

    public function updateSubServicio(Request $request, $id) {
        if ($request->nombre == '') {
            return response()->json(['code' => 400, 'msg' => 'El Nombre es requerido']);
        }

        DB::beginTransaction();

        try {
            
            $sub_servicio = SubServicio::find($id);
            $sub_servicio->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $sub_servicio->costo = $request->costo;
            $sub_servicio->save();

            DB::commit();

            return response()->json(['code' => 200, 'msg' => 'Sub Servicio actualizado']);

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
        $seguros = SubServicio::where('servicio_id', 3)->get();
        $meses = Mes::all();
        $extras = Servicio::whereIn('id', [4,5,9])->get();
        $licencias = SubServicio::where('servicio_id', 4)->get();
        $notificaciones = SubServicio::where('servicio_id', 5)->get();
        $costo_servicios = SubServicio::where('servicio_id', 6)->get();
        $venta_multas = SubServicio::where('servicio_id', 9)->get();

        //Entidades para selector
        $entidades = \Helper::entidadUsuario();

        // Validar si hay un registro en curso
        $vehiculo_id = \Helper::registroEnCurso();
        $en_curso = 0;
        if ($vehiculo_id != null) {
            $en_curso = 1;
            $total_checkout = Venta::where('vehiculo_id', $vehiculo_id)->select('total')->pluck('total')->first();
            if (is_null($total_checkout)) {
                $total_checkout = 0;
            }
        } else {
            $total_checkout = 0;
        }

        $user = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                    ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                    ->where('users.id', Auth::user()->id)
                    ->select(
                        'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                        'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede', 'sedes.acceso_panel as panel')
                    ->first();

        return view('modulo.inspeccion.index', compact('costosInspeccion', 'marbetes', 'seguros', 'meses', 'total_checkout', 'extras', 'licencias', 'notificaciones', 'costo_servicios', 'venta_multas', 'user', 'entidades', 'vehiculo_id', 'en_curso'));
    }

    public function getViewGestoria() {

        $user = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                    ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                    ->where('users.id', Auth::user()->id)
                    ->select(
                        'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                        'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede', 'sedes.acceso_panel as panel')
                    ->first();

        $entidades = \Helper::entidadUsuario();

        return view('modulo.gestoria.index', compact('user', 'entidades'));
    }

    public function getTablilla($tablilla) {
        $tablilla = ClienteVehiculo::where('tablilla', $tablilla)->first();
        if ($tablilla != null) {
            return response()->json(['code' => 200, 'msg' => '¡La tablilla ingresada ya existe!']);
        } else {
            return response()->json(['code' => 001]);
        }
    }

    public function editSubServicio($id) {
        $servicio = Servicio::find($id);

        $subservicios = SubServicio::leftJoin('estatus', 'sub_servicios.estatus_id', 'estatus.id')
                                    ->where('servicio_id', $id)
                                    ->select('sub_servicios.id', 'sub_servicios.nombre', 'sub_servicios.costo', 'estatus.nombre as estatus')
                                    ->get();

        $entidades = Sede::where('estatus_id', 1)->select('id', 'nombre')->get();

        return view('servicio.subservicio', compact('subservicios', 'id', 'servicio', 'entidades'));
    }
}
