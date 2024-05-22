@extends('layouts.master')

@section('title')
    Editar cliente
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <form method="POST" action="{{ route('clientes.update', $cliente->id) }}" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="row col-md-12">
            <div class="col-md-3 mb-3">
                <label for="nombre" class="col-form-label"> Nombre </label>
                <input type="text" class="form-control form-control-sm" name="nombre" value="{{ $cliente->nombre}}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="email" class="col-form-label"> Email </label>
                <input type="email" class="form-control form-control-sm" name="email" value="{{ $cliente->email}}" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="telefono" class="col-form-label"> Teléfono </label>
                <input type="text" class="form-control form-control-sm" name="telefono" value="{{ $cliente->telefono}}" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="seguro_social" class="col-form-label"> Seguro Social </label>
                <input type="text" class="form-control form-control-sm" name="seguro_social" value="{{ $cliente->seguro_social}}" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="identificacion" class="col-form-label"> Identificación </label>
                <input type="text" class="form-control form-control-sm" name="identificacion" value="{{ $cliente->identificacion}}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="identificacion" class="col-form-label"> </label>
                <button type="submit" class="btn btn-primary" >Guardar</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection