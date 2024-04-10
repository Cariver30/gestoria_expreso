@extends('layouts.master')

@section('title')
    Inspección
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row col-md-12">
    <div class="col-sm-12">
        <div class="text-sm-end">
            <a type="button" href="{{ url()->previous() }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2"><i class="mdi mdi-back me-1"></i> Volver </a>
        </div>
    </div>
    <div class="col-lg-3" id="inspeccionVehiculo">
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Vehículos </h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3" id="ventaMarbetes">
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Marbetes </h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3" id="seguro">
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Seguros </h1>     
            </div>
        </div>
    </div>
    <div class="col-lg-3" id="extras">
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Extras </h1>
               
            </div>
        </div>
    </div>
</div>
@include('modulo.inspeccion.vehiculo.add')
@include('modulo.inspeccion.extras.index')
@include('modulo.inspeccion.marbete.add')
@include('modulo.inspeccion.seguro.add')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#inspeccionVehiculo").click(function() {
                $('#add_vehiculo').modal('show')
            });
            $("#extras").click(function() {
                $('#servicios_extras').modal('show')
            });
            $("#ventaMarbetes").click(function() {
                $('#select_marbete').modal('show')
            });
            $("#seguro").click(function() {
                $('#select_seguro').modal('show')
            });
            
            $("#seguro_id").on("change", function() {
                var seguro_id = $(this).val();
                if(seguro_id == 1){
                    document.getElementById("opcion_vaucher").style.display = "initial";
                }else{
                    document.getElementById("opcion_vaucher").style.display = "none";
               }
            });
        });
    </script>
@endsection
