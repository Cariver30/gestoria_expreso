<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\ClienteVehiculo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();

        return view('cliente.index', compact('clientes'));
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
        if ($request->nombre == '' || $request->email == '' || $request->telefono == '' || $request->compania == '' || $request->vehiculo == '' || $request->tablilla == '' || $request->marca == '' || $request->anio == '' || $request->seguro_social == '' || $request->mes_vencimiento == '' || $request->costo_inspeccion == '') {
            return response()->json(['code' => 400, 'msg' => 'Hay campos vacios']);
        }

        DB::beginTransaction();

        try {
            //Se crea el cliente
            $cliente = new Cliente();
            $cliente->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $cliente->email = $request->email;
            $cliente->telefono = $request->telefono;
            $cliente->seguro_social = $request->seguro_social;
            $cliente->usuario_id = Auth::user()->id;
            $cliente->estatus_id = 5;
            $cliente->save();

            //Se crea el vehículo
            $clienteVehiculo = new ClienteVehiculo();
            $clienteVehiculo->compania = \Helper::capitalizeFirst($request->compania, "1");
            $clienteVehiculo->vehiculo = \Helper::capitalizeFirst($request->vehiculo, "1");
            $clienteVehiculo->tablilla = $request->tablilla;
            $clienteVehiculo->marca = \Helper::capitalizeFirst($request->marca, "1");
            $clienteVehiculo->anio = $request->anio;
            $clienteVehiculo->mes_vencimiento_id = $request->mes_vencimiento;
            $clienteVehiculo->costo_inspeccion_id = $request->costo_inspeccion;
            $clienteVehiculo->cliente_id = $cliente->id;
            $clienteVehiculo->estatus_id = 3;
            $clienteVehiculo->save();

            DB::commit();

            return response()->json(['code' => 201, 'msg' => 'Cliente registrado', 'id' => $cliente->id]);

        }catch (\PDOException $e){
            DB::rollBack();
            return response()->json(['code' => 201, 'msg' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        dd('sd');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }

    public function vehiculoMarbete(Request $request) {
        dd($request->all());
    }
}
