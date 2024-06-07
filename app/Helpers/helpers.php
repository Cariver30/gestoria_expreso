<?php
    namespace App\Helpers;
    
    use DB;
    use App\Models\Sede;
    use App\Models\User;
    use App\Models\Cliente;
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
        $cliente_id = Cliente::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->select('id')->pluck('id')->first();
        // dd($cliente_id);
        $vehiculo_id = ClienteVehiculo::where('estatus_id', 3)->where('cliente_id', $cliente_id)->select('id')->pluck('id')->first();
        // dd($vehiculo_id);

        return $vehiculo_id;
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

    public static function getCliente($idVehiculo) {

        $cliente_id = ClienteVehiculo::where('id', $idVehiculo)->select('cliente_id')->pluck('cliente_id')->first();
        $cliente = Cliente::where('id', $cliente_id)->first();
        
        return $cliente;
    }

    public static function getVehiculo($idVehiculo) {
        $vehiculo = ClienteVehiculo::where('id', $idVehiculo)->select('id', 'compania', 'vehiculo', 'tablilla', 'marca', 'anio', 'mes_vencimiento_id', 'cliente_id')->first();
        
        return $vehiculo;
    }
}
