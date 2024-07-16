<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Checkout;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entidades = \Helper::entidadUsuario();

        // Validar si hay un registro en curso
        $vehiculo_id = \Helper::registroEnCurso();
        $venta = Venta::where('id', $vehiculo_id)->first();
        $servicios = \Helper::getServicioDesglose($vehiculo_id);
        $total = \Helper::getTotalCheckout($vehiculo_id);
        // dd($servicios);

        return view('modulo.checkout.index', compact('entidades', 'servicios', 'total', 'venta', 'vehiculo_id'));
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

        return view('modulo.checkout.vehiculo', compact('entidades', 'servicios', 'total', 'venta', 'id'));
    }
}
