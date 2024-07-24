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
        $venta = \Helper::registroEnCurso();
        // dd($venta);
        $servicios = \Helper::getServicioDesglose($venta->id);
        $total = \Helper::getTotalCheckout($venta->id);
        // dd($total);

        return view('modulo.checkout.index', compact('entidades', 'servicios', 'total', 'venta'));
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
}
