<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Sede;
use App\Models\SubServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function validarLogin(Request $request) {
        // $costosInspeccion = SubServicio::where('servicio_id', 1)->get();
        // $marbetes = SubServicio::where('servicio_id', 2)->get();
        // $seguros = SubServicio::where('servicio_id', 7)->get();
        $pin = $request->digit1.$request->digit2.$request->digit3.$request->digit4;
        $user = User::leftJoin('roles', 'users.rol_id', 'roles.id')
                    ->leftJoin('sedes', 'users.sede_id', 'sedes.id')
                    ->where('pin', $pin)
                    ->select(
                        'users.id', 'users.nombre','users.primer_apellido', 'users.segundo_apellido', 'users.email',
                        'users.estatus_id', 'users.rol_id', 'roles.nombre as rol', 'sedes.nombre as sede', 'sedes.acceso_panel as panel')
                    ->first();

                    // dd($user);
        if($user) {
            Auth::loginUsingId($user->id);
            $entidades = Sede::where('estatus_id', 1)->select('id', 'nombre')->get();
            if (Auth::user()->rol_id == 3) {
                $valida_entidades = DB::table('usuario_sedes')->where('usuario_id', Auth::user()->id)->count();
            } else {
                $valida_entidades = 0;
            }

            return view('principal.home', compact('user', 'entidades', 'valida_entidades'));

        } else {
            return back()->with(['status' => 'PIN Inválido']);
        }
    }
}
