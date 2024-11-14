<?php
    namespace App\Helpers;
    
    use DB;
    use App\Models\Sede;
    use App\Models\User;
    use App\Models\Venta;
    use App\Models\Cliente;
    use App\Models\SubServicio;
    use App\Models\ClienteVehiculo;
    use App\Models\DetalleVentaGestoria;
    use App\Models\DetalleVentaInspeccion;
    use Illuminate\Support\Facades\Auth;


class Helper {
    
    public static function capitalizeFirst($cadena, $all=null){
        if(!$all) {
            $fc = mb_strtoupper(mb_substr($cadena, 0, 1));
            return $fc.mb_strtolower(mb_substr($cadena, 1));
        }
        return mb_convert_case($cadena, MB_CASE_TITLE, 'UTF-8');
    }

    public static function getInfoUsuario() {
        $user = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                    ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                    ->where('users.id', Auth::user()->id)
                    ->select(
                        'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                        'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede', 'sedes.acceso_panel as panel')
                    ->first();

        return $user;
    }

    public static function registroEnCurso() {
        // $cliente_id = Cliente::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->select('id')->pluck('id')->first();
        // // dd($cliente_id);
        // $vehiculo_id = ClienteVehiculo::where('estatus_id', 3)->where('cliente_id', $cliente_id)->select('id')->pluck('id')->first();

        // return $vehiculo_id;
        $venta = Venta::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->first();
        if ($venta && $venta->tipo_servicio == 1) {
            $serv_insp = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 1)->select('subservicio_id')->pluck('subservicio_id')->first();
            $venta->serv_insp = $serv_insp;
            $serv_marbete = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 2)->select('subservicio_id')->pluck('subservicio_id')->first();
            $venta->serv_marbete = $serv_marbete;
            $serv_acca = DetalleVentaInspeccion::where('venta_id', $venta->id)->where('servicio_id', 10)->select('subservicio_id')->pluck('subservicio_id')->first();
            $venta->serv_marbete_acca = $serv_acca;
        }
        return $venta;
    }

    public static function entidadUsuario() {
        if (Auth::user()->rol_id == 1) {
            $entidades = Sede::where('estatus_id', 1)->select('id', 'nombre')->get();
        }else {
            $array_entidades = [];
            $entidades = DB::table('usuario_sedes')->where('usuario_id', Auth::user()->id)->get();
            if (count($entidades) == 0) {
                $entidades = Sede::where('id', Auth::user()->sede_id)->select('id', 'nombre')->get();
            } else {
                foreach ($entidades as $entidad) {
                    $enti = Sede::where('id', $entidad->sede_id)->select('id', 'nombre')->first();
                    array_push($array_entidades, $enti);
                }
                $entidades = collect($array_entidades);
            }
        }
        
        return $entidades;
    }

    public static function entidadesUsuario($id) {
        $array_entidades = [];
        $entidades = DB::table('usuario_sedes')->where('usuario_id', $id)->get();
        if (count($entidades) == 0) {
            $sede_id = User::where('id', $id)->select('sede_id')->pluck('sede_id')->first();
            $entidades = Sede::where('id', $sede_id)->select('id', 'nombre')->get();

            foreach ($entidades as $entidad) {
                array_push($array_entidades, $entidad->nombre);
            }
            $entidades = $array_entidades;
        } else {
            foreach ($entidades as $entidad) {
                $enti = Sede::where('id', $entidad->sede_id)->select('nombre')->first();
                array_push($array_entidades, $enti->nombre);
            }
            $entidades = $array_entidades;
        }

        return $entidades;
    }

    public static function getCliente($venta_id) {


        $cliente_id = Venta::where('id', $venta_id)->select('vehiculo_id')->pluck('vehiculo_id')->first();
        $cliente = Cliente::where('id', $cliente_id)->first();


        // $cliente_id = ClienteVehiculo::where('id', $idVehiculo)->select('cliente_id')->pluck('cliente_id')->first();
        // $cliente = Cliente::where('id', $cliente_id)->first();
        
        return $cliente;
    }

    public static function getVehiculo($venta_id) {
        $vehiculo_id = Venta::where('id', $venta_id)->select('vehiculo_id')->pluck('vehiculo_id')->first();
        $vehiculo = ClienteVehiculo::where('id', $vehiculo_id)->select('id', 'compania', 'vehiculo', 'tablilla', 'marca', 'anio', 'mes_vencimiento_id', 'cliente_id')->first();
        // $vehiculo = ClienteVehiculo::where('id', $idVehiculo)->select('id', 'compania', 'vehiculo', 'tablilla', 'marca', 'anio', 'mes_vencimiento_id', 'cliente_id')->first();
        
        return $vehiculo;
    }

    public static function getTotalCheckout($ventaId) {
        $venta = Venta::where('id', $ventaId)->first();
        $preTotal = DetalleVentaGestoria::where('venta_id', $ventaId)->sum('precio');
        $posTotal = $preTotal + $venta->costo_servicio_fijo + $venta->derechos_anuales;
        $total = $posTotal;
        
        return $total;
    }

    public static function getServicioDesglose($venta_id) {
        $venta = Venta::where('id', $venta_id)->first();
        $array_servicios = [];

        //Se va obteniendo cada servicio registrado
        // Inspección
        if ($venta->costo_inspeccion_id != null) {
            $costoInspección = SubServicio::where('id', $venta->costo_inspeccion_id)->select('id', 'nombre', 'costo', 'servicio_id')->first();
            array_push($array_servicios, $costoInspección);
        } else {
            $costoInspección = $venta->costo_inspeccion_admin;
            $array_inspeccion = [
                'id' => 1,
                'nombre' => 'Inspección customizado',
                'costo' => $costoInspección,
                'servicio_id' => 1
            ];
            array_push($array_servicios, $array_inspeccion);
        }

        // Marbete
        if ($venta->costo_marbete_id != null) {
            $costoMarbete = SubServicio::where('id', $venta->costo_marbete_id)->select('id', 'nombre', 'costo', 'servicio_id')->first();
            array_push($array_servicios, $costoMarbete);
        } else {
            $costoMarbete = $venta->costo_marbete_admin;
            $array_marbete = [
                'id' => 1,
                'nombre' => 'Marbete customizado',
                'costo' => $costoMarbete,
                'servicio_id' => 2
            ];
            array_push($array_servicios, $array_marbete);
        }

        //Marbete ACAA
        if ($venta->costo_marbete_acaa_id != null) {
            $marbete_acaa = SubServicio::where('id', $venta->costo_marbete_acaa_id)->select('id', 'nombre', 'costo', 'servicio_id')->first();
            array_push($array_servicios, $marbete_acaa);
        }

        // Seguros
        if ($venta->costo_seguro_id != null) {
            $costoSeguros = SubServicio::where('id', $venta->costo_seguro_id)->select('id', 'nombre', 'costo', 'servicio_id')->first()->toArray();
            if ($costoSeguros['id'] == 1 || $costoSeguros['id'] == 2) {
                $costoSeguros['costo'] = '-$'.$costoSeguros['costo'];
            }
            array_push($array_servicios, $costoSeguros);
        }
        // dd($array_servicios);
        return $array_servicios;
    }

    public static function goCheckoutInspeccion($id) {
        $vehiculo_id = ClienteVehiculo::where('estatus_id', 3)->where('cliente_id', $cliente_id)->select('id')->pluck('id')->first();

        return $vehiculo_id;
    }

    //Obtener los servicios seleccionado
    public static function getServicios($ventaId) {
        $tipoServicio = Venta::where('id', $ventaId)->select('tipo_servicio')->pluck('tipo_servicio')->first(); 
        if ($tipoServicio == 1) {
            $servicios = DetalleVentaInspeccion::leftJoin('sub_servicios', 'detalle_venta_inspeccions.subservicio_id', 'sub_servicios.id')
                ->where('venta_id', $ventaId)
                ->select('sub_servicios.id', 'sub_servicios.nombre as nombre', 'sub_servicios.costo as costo')
                ->get();
             
        } else {
            $servicios = DetalleVentaGestoria::leftJoin('gestoria_sub_servicios', 'detalle_venta_inspeccions.subservicio_id', 'gestoria_sub_servicios.id')
            ->where('venta_id', $ventaId)
            ->select('gestoria_sub_servicios.nombre as nombre', 'gestoria_sub_servicios.costo as costo')
            ->get();
        }
        return $servicios;
    }

    //Se calcula el total para Inspección
    public static function updateTotalVentaInspeccion($ventaId) {
        
        $venta = Venta::where('id', $ventaId)->first();
        $total = 0;
        
        $preTotales = DetalleVentaInspeccion::where('venta_id', $ventaId)->get();
        // dd($preTotales);
        foreach ($preTotales as $preTotal) {
            if ($preTotal->subservicio_id == 1 || $preTotal->subservicio_id == 2) {
                $total = $total - $preTotal->precio;    
            } else {
                $total = $total + $preTotal->precio;
            }
        }
        $posTotal = $total + $venta->costo_servicio_fijo + $venta->derechos_anuales;
        $venta->total = $posTotal;
        
        $venta->save();
    }

    //Se calcula el total para GESTORÍA
    public static function updateTotalVenta($ventaId) {
        $venta = Venta::where('id', $ventaId)->first();
        if ($venta->tipo_servicio == 1) {
            $total = DetalleVentaGestoria::where('venta_id', $ventaId)->sum('precio');
            $pos = $total + $venta->costo_servicio_fijo + $venta->derechos_anuales;
            $venta->total = $pos;
        } else {
            $venta->total = DetalleVentaGestoria::where('venta_id', $ventaId)->sum('precio');
        }
        
        $venta->save();
    }

}
