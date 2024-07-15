<?php

namespace App\Http\Controllers;

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

        $vehiculo = ClienteVehiculo::find($request->vehiculo_id);
        if ($vehiculo) {
            $vehiculo->estatus_id = 6;
            $vehiculo->motivo = $request->motivo;
            $vehiculo->save();

            $cliente = Cliente::find($vehiculo->cliente_id);
            $cliente->estatus_id = 1;
            $cliente->save();

            return response()->json(['code' => 200, 'msg' => 'Transacción cancelada!']);
        } else {
            return response()->json(['code' => 404, 'msg' => 'Transacción no encontrada!']);
        }
    }

    public function pendienteVenta(Request $request) {

        $vehiculo = ClienteVehiculo::find($request->vehiculo_id);
        if ($vehiculo) {
            $vehiculo->estatus_id = 5;
            $vehiculo->save();

            $cliente = Cliente::find($vehiculo->cliente_id);
            $cliente->estatus_id = 5;
            $cliente->save();

            $venta = Venta::where('vehiculo_id', $request->vehiculo_id)->first();
            $venta->estatus_id = 5;
            $venta->save();

            return response()->json(['code' => 200, 'msg' => 'Transacción pendiente de pago!']);
        } else {
            return response()->json(['code' => 404, 'msg' => 'Transacción no encontrada!']);
        }
    }

    public function finalizarVenta(Request $request) {

        $vehiculo = Venta::where('vehiculo_id', $request->vehiculo_id)->where('estatus_id',3 )->first();

        if ($vehiculo) {
            $clienteVehiculo = ClienteVehiculo::where('id', $request->vehiculo_id)->update(array('estatus_id' => 4));
            $venta = Venta::where('vehiculo_id', $request->vehiculo_id)->update(array('estatus_id' => 4, 'tipo_pago' => 1));
            $cliente = \Helper::getCliente($request->vehiculo_id);
            Cliente::where('id', $cliente->id)->update(array('estatus_id' => 4));

            return response()->json(['code' => 200, 'msg' => 'Transacción finalizada!', 'url' => route('clientes.edit', ['cliente' => $cliente->id ])]);
        } else {
            return response()->json(['code' => 404, 'msg' => 'Transacción no encontrada!']);
        }
    }
}
