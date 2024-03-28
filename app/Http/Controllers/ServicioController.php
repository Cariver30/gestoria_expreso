<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::select('id', 'nombre', 'costo')->get();
        
        return view('servicio.index', compact('servicios'));
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
        $input = $request->all();

        $rules = [
            'nombre' => 'required',
            'costo' => 'required',
        ];

        $messages = [
            'nombre.required' => 'El nombre es un campo requerido',
            'costo.required'  => 'El costo es un campo requerido'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            
            $servicio = new Servicio();
            $servicio->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $servicio->costo = $request->costo;
            $servicio->save();

            DB::commit();

            Session::flash('success', 'Servicio registrado');
            return redirect()->route('servicio.index');

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servicio $servicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $rules = [
            'nombre' => 'required',
            'costo' => 'required',
        ];

        $messages = [
            'nombre.required' => 'El nombre es un campo requerido',
            'costo.required'  => 'El costo es un campo requerido'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            
            $servicio = Servicio::find($id);
            $servicio->nombre = \Helper::capitalizeFirst($request->nombre, "1");
            $servicio->costo = $request->costo;
            $servicio->save();

            DB::commit();

            Session::flash('success', 'Servicio actualizado');
            return redirect()->route('servicio.index');

        }catch (\PDOException $e){
            DB::rollBack();
            return back()->withErrors(['Error' => substr($e->getMessage(), 0, 150)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $servicio)
    {
        //
    }
}
