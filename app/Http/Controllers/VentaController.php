<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\ClienteVehiculo;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        //
    }

    public function cancelarVenta(Request $request) {
        // dd($request->all());

        $venta = Venta::where('id', $request->venta_id)->first();
        
        if ($venta) {
            $venta->estatus_id = 6;
            $venta->motivo =  \Helper::capitalizeFirst($request->motivo, "1");
            $venta->save();

            return response()->json(['code' => 200, 'msg' => 'Transacción cancelada!']);
        } else {
            return response()->json(['code' => 404, 'msg' => 'Transacción no encontrada!']);
        }
    }

    public function pendienteVenta(Request $request) {
        
        $venta = Venta::where('id', $request->venta_id)->where('estatus_id', 3)->first();
        
        if ($venta) {
            
            $venta->estatus_id = 5;
            $venta->save();
            
            $cliente_id =  ClienteVehiculo::where('id', $venta->vehiculo_id)->select('cliente_id')->pluck('cliente_id')->first();
            $cliente = Cliente::find($cliente_id);
            $cliente->estatus_id = 5;
            $cliente->save();

            return response()->json(['code' => 200, 'msg' => 'Transacción pendiente de pago!']);
        } else {
            return response()->json(['code' => 404, 'msg' => 'Transacción no encontrada!']);
        }
    }

    public function finalizarVenta(Request $request) {

        $venta = Venta::where('id', $request->venta_id)->first();
        $cliente_id =  ClienteVehiculo::where('id', $venta->vehiculo_id)->select('cliente_id')->pluck('cliente_id')->first();

        if ($venta) {
            $date = Carbon::now();
            $date = $date->format('Y-m-d H:i:s');

            $venta->estatus_id = 4;
            $venta->fecha_pago = $date;
            $venta->tipo_pago = 1; //1= Efectivo
            $venta->save();

            return response()->json(['code' => 200, 'msg' => 'Transacción finalizada, recibo generado!', 'url' => route('clientes.edit', ['cliente' => $cliente_id ])]);
        } else {
            return response()->json(['code' => 404, 'msg' => 'Transacción no encontrada!']);
        }
    }
}
