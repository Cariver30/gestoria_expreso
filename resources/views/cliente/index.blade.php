@extends('layouts.master')

@section('content')
    <div class="row col-md-12">
        @foreach ($clientes as $cliente)
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img src="{{ URL::asset('build/images/companies/adobe.svg') }}" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="" class="text-dark">{{ $cliente->nombre }} </a></h5>
                        <div class="mt-4">
                            <button class="btn btn-soft-success waves-effect waves-light" data-id="{{ $cliente->id }}"><i class="mdi mdi-pencil font-size-16 text-danger me-1"></i> Editar </a></li>
                            <button class="btn btn-soft-info waves-effect waves-light" data-id="{{ $cliente->id }}"><i class="mdi mdi-trash-can-outline font-size-16 text-danger me-1"></i>Ver detalle</button>
                            <button class="btn btn-soft-danger waves-effect waves-light" data-id="{{ $cliente->id }}"><i class="mdi mdi-trash-can-outline font-size-16 text-danger me-1"></i>Agregar servicio</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection