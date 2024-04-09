<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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
        $costosInspeccion = SubServicio::where('servicio_id', 1)->get();
        $marbetes = SubServicio::where('servicio_id', 2)->get();
        $seguros = SubServicio::where('servicio_id', 7)->get();
        $pin = $request->digit1.$request->digit2.$request->digit3.$request->digit4;
        $user = User::select('id')->where('pin', $pin)->first();
        if($user) {
            Auth::loginUsingId($user->id);
            return view('index', compact('costosInspeccion', 'marbetes', 'seguros'));
        } else {
            return back();
        }
    }
}
