<?php
    namespace App\Helpers;
    
    use DB;
    use App\Models\Sede;
    use App\Models\User;
    use App\Models\Venta;
    use App\Models\Cliente;
    use App\Models\SubServicio;
    use App\Models\ClienteVehiculo;
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

    public static function getTotalCheckout($venta_id) {
        $venta = Venta::where('id', $venta_id)->first();
        $esResta = 0;
        
        //Se va calculando el total
        if ($venta->costo_inspeccion_id != null) {
            $costoInspección = SubServicio::where('id', $venta->costo_inspeccion_id)->select('costo')->pluck('costo')->first();
        } else {
            $costoInspección = $venta->costo_inspeccion_admin;
        }
        if ($venta->costo_marbete_id != null) {
            $costoMarbete = SubServicio::where('id', $venta->costo_marbete_id)->select('costo')->pluck('costo')->first();
        } else {
            $costoMarbete = $venta->costo_marbete_admin;
        }
        if ($venta->costo_marbete_acaa_id != null) {
            $costoMarbeteAcaa = SubServicio::where('id', $venta->costo_marbete_acaa_id)->select('costo')->pluck('costo')->first();
        } else {
            $costoMarbeteAcaa = 0;
        }

        if ($venta->costo_seguro_id != null) {
            $costoSeguro = SubServicio::where('id', $venta->costo_seguro_id)->select('costo')->pluck('costo')->first();
            if ($venta->costo_seguro_id == 1 || $venta->costo_seguro_id == 2) {
                $esResta = 1;
            }
        } else {
            $costoSeguro = 0;
        }

        $total_sin_seguro = $costoInspección + $costoMarbete + $venta->costo_servicio_fijo + $venta->derechos_anuales + $costoMarbeteAcaa;
        if ($esResta == 0) {
            $total = $total_sin_seguro + $costoSeguro;
        } else {
            $total = $total_sin_seguro - $costoSeguro;
        }
        

        return $total;
    }

    public static function validaBtnPago($venta) {

        $venta = Venta::where('id', $venta)->first();
        $flag = 0;

        //Se va calculando el total
        // if ($venta->costo_inspeccion_id != null || $venta->costo_inspeccion_admin != null) {
        //     $flag += 1;
        // }
        
        if ($venta->costo_marbete_id != null || $venta->costo_marbete_admin != null) {
            $flag += 1;
        }

        if ($venta->costo_seguro_id != null) {
            $flag += 1;
        }

        if ($flag == 1) {
            $valida = 1;
        } else {
            $valida = 0;
        }
        // dd($valida);

        return $valida;
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
}
