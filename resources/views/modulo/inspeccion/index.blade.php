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
@include('modulo.inspeccion.marbete.add')
@include('modulo.inspeccion.seguro.add')
@include('modulo.inspeccion.extras.index')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            if({{$en_curso}} == 1){
                Swal.fire({
                    title: 'Registro pendiente',
                    icon: "warning",
                    showConfirmButton: false
                });
                document.getElementById("inspeccionVehiculo").removeAttribute("id");
            }



            //Sección para mostrar modales
            $("#inspeccionVehiculo").click(function() {
                $('#add_vehiculo').modal('show')
            });
            $("#ventaMarbetes").click(function() {
                $('#select_marbete').modal('show')
            });
            $("#seguro").click(function() {
                $('#select_seguro').modal('show')
            });
            $("#extras").click(function() {
                $('#servicios_extras').modal('show')
            });
            
            //Se detecta el change para habilitar el input de núm de vaucher cuando es seguro privado
            $("#seguro_id").on("change", function() {
                var seguro_id = $(this).val();
                if(seguro_id == 1){
                    document.getElementById("opcion_vaucher").style.display = "initial";
                }else{
                    document.getElementById("opcion_vaucher").style.display = "none";
               }
            });

             //Crear Cliente- vehículo
            $('#saveVehiculo').click(function () {
                if($('#nombre').val() == '' || $('#email').val() == '' || $('#telefono').val() == '' || $('#compania').val() == '' || $('#vehiculo').val() == '' || $('#tablilla').val() == '' || $('#marca').val() == '' || $('#anio').val() == '' || $('#seguro_social').val() == '' || $('#mes_vencimiento').val() == '' || $('#costo_inspeccion').val() == ''){
                    Swal.fire({
                        title: 'Hay campos vacios',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('clientes.store') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#nombre').val(),
                        email: $('#email').val(),
                        telefono: $('#telefono').val(),
                        compania: $('#compania').val(),
                        vehiculo: $('#vehiculo').val(),
                        tablilla: $('#tablilla').val(),
                        marca: $('#marca').val(),
                        anio: $('#anio').val(),
                        seguro_social: $('#seguro_social').val(),
                        mes_vencimiento: $('#mes_vencimiento').val(),
                        costo_inspeccion: $('#costo_inspeccion_id').val()
                    },
                    success: function (data) {
                        if (data.code == 201) {
                            $('#add_vehiculo').modal('hide');
                            Swal.fire({
                                title: data.msg,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(function(){
                                window.location.reload();
                            }, 1000);
                        } else {
                            Swal.fire({
                                title: data.msg,
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }

                    },
                    error: function (data) {
                    }
                });
            });









            $('.btnCostoInspeccion').click(function () {
                var id = $(this).attr('data-id');
                $('#costo_inspeccion_id').val(id);
            });

            $('.btnInspeccionMarbete').click(function () {
                var id = $(this).attr('data-id');
                $('#marbete_id').val(id);
            });

            $('#saveInspeccionMarbete').click(function () {
                if($('#marbete_id').val() == ''){
                    Swal.fire({
                        title: 'Debe seleccionar un marbete',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('vehiculo.marbete') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        marbete_id: $('#marbete_id').val()
                    },
                    success: function (data) {
                        if (data.code == 201) {
                            Swal.fire({
                                title: data.msg,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $('#select_marbete').modal('hide')
                        } else {
                            Swal.fire({
                                title: data.msg,
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }

                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            });
        });
    </script>
@endsection