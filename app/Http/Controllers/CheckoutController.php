<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Models\ClienteVehiculo;
use App\Models\DetalleVentaGestoria;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $entidades = \Helper::entidadUsuario();
        // // Validar si hay un registro en curso
        // $venta = \Helper::registroEnCurso();
        // $servicios = \Helper::getServicioDesglose($venta->id);
        // $total = \Helper::getTotalCheckout($venta->id);

        // return view('modulo.checkout.index', compact('entidades', 'servicios', 'total', 'venta'));
        
        
        // Nueva versión
        $entidades = \Helper::entidadUsuario();
        $venta = Venta::where('estatus_id', 3)->where('usuario_id', Auth::user()->id)->first();
        $servicios = \Helper::getServicios($venta->id);
        // dd($servicios);

        return view('modulo.checkout.index', compact('entidades', 'servicios', 'venta'));
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
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkout $checkout)
    {
        //
    }

    public function payCheckoutVehicle ($id) {
        $entidades = \Helper::entidadUsuario();

        
        $venta = Venta::where('id', $id)->first();
        $servicios = \Helper::getServicioDesglose($id);
        $total = \Helper::getTotalCheckout($id);
        // dd($venta, $servicios, $total);

        return view('modulo.checkout.vehiculo', compact('entidades', 'servicios', 'total', 'venta', 'id'));
    }

    public function verRecibo($id) {

        // $entidades = \Helper::entidadUsuario();
        // $venta = Venta::find($id);
        // $vehiculo = ClienteVehiculo::where('id', $venta->vehiculo_id)->first();
        // $cliente = Cliente::where('id', $vehiculo->cliente_id)->first();
        // $servicios = \Helper::getServicioDesglose($id);
        // $total = \Helper::getTotalCheckout($id);
        
        // return view('modulo.checkout.recibo', compact('venta', 'servicios', 'total', 'entidades', 'cliente'));

        $entidades = \Helper::entidadUsuario();
        $venta = Venta::find($id);
        $cliente = Cliente::where('id', $venta->cliente_id)->first();
        $servicios = \Helper::getServicios($venta->id);        
        
        return view('modulo.checkout.recibo', compact('entidades', 'venta', 'cliente', 'servicios'));
    }
}
