@extends('layouts.master')

@section('title')
    Gestoría
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row col-md-12">
    @foreach ($gestorias as $gestoria)
        <div class="col-lg-4 servicioGestoria" data-id="{{ $gestoria->id }}">
            <div class="card bg-success text-white-50">
                <div class="card-body text-center">
                    <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                    <h1 class="mt-0 mb-4 text-white"> {{ $gestoria->nombre }} </h1>
                </div>
            </div>
        </div>
    @endforeach
</div>
@include('modulo.gestoria.transaccion')
@include('modulo.gestoria.licencia')
@include('modulo.gestoria.vehiculo')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            //Sección para mostrar modales
            $(".servicioGestoria").click(function() {
                var id = $(this).attr('data-id');
                switch (id) {
                    case '1':
                        $('#transacciones').modal('show');
                        break;
                    case '2':
                        $('#licencias').modal('show')
                        break;
                    case '3':
                        $('#vehiculos').modal('show')
                        break;
                }
            });
        });
    </script>
@endsection
