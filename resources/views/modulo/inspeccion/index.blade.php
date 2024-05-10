@extends('layouts.master')

@section('title')
    Inspección
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-sm-12 text-center" style="margin-left: 41%;">
        <div class="col-sm-2 col-sm-2">
            <label class="card-radio-label mb-3">
                <input type="radio" name="suma_total" id="suma_total" class="card-radio-input" checked="">
                <div class="card-radio">
                    <i class="bx bx-cart font-size-24 text-primary align-middle me-2"></i><span>Total: {{$total_checkout}}</span>
                </div>
            </label>
        </div>
    </div>
<div class="row col-md-12">
    {{--  <div class="col-sm-12">
        <div class="text-sm-end">
            <a type="button" href="{{ url()->previous() }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2"><i class="mdi mdi-back me-1"></i> Volver </a>
        </div>
    </div>  --}}
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
<div class="row col-sm-12 text-center" style="margin-left: 33%;">
    <div class="col-sm-2 col-sm-2">
        <button type="button" class="btn btn-soft-success col-md-8 waves-effect waves-light btn-lg" data-id=""> PAGAR </button>
    </div>
    <div class="col-sm-2 col-sm-2">
        <button type="button" class="btn btn-soft-danger col-md-8 waves-effect waves-light btn-lg" data-id=""> FINALIZAR </button>
    </div>
</div>
@include('modulo.inspeccion.vehiculo.add')
@include('modulo.inspeccion.marbete.add')
@include('modulo.inspeccion.seguro.add')
@include('modulo.inspeccion.extras.add')
@include('modulo.inspeccion.extras.licencia')
@include('modulo.inspeccion.extras.notificacion')
@include('modulo.inspeccion.extras.costo_servicio')
@include('modulo.inspeccion.extras.venta_multa')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>

    <!-- Form file upload init js -->
    <script src="{{ URL::asset('build/js/pages/form-file-upload.init.js') }}"></script>
    <script type="text/javascript">
        function validateFileType(){
            var fileName = document.getElementById("file_licencia").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                //TO DO
            }else{
                alert("Only jpg/jpeg and png files are allowed!");
            }   
        }
    </script>
    <script>
        $(document).ready(function() {

            {{--  if({{$en_curso}} == 1){
                Swal.fire({
                    title: 'Registro pendiente',
                    icon: "warning",
                    showConfirmButton: false
                });
                document.getElementById("inspeccionVehiculo").removeAttribute("id");
            }  --}}



            //Sección para mostrar modales
            $("#inspeccionVehiculo").click(function() {
                $('#add_vehiculo').modal('show')
            });
            $("#ventaMarbetes").click(function() {
                $('#select_marbete').modal('show')
            });
            $("#seguro").click(function() {
                $('#modal_inspeccion_seguro').modal('show')
            });
            $("#extras").click(function() {
                $('#servicios_extras').modal('show')
            });
             $("#btnInspeccionImpresionLicencia").click(function() {
                $('#servicios_extras').modal('show')
            });
            $('.btnInspeccionExtras').click(function () {
                var id = $(this).attr('data-id');
                switch (id) {
                    case '3':
                        $('#extra_licencia').modal('show');
                        break;
                    case '4':
                        $('#extra_notificacion').modal('show')
                        break;
                    case '5':
                        $('#extra_costo_servicio').modal('show')
                        break;
                    case '9':
                        $('#extra_venta_multa').modal('show')
                        break;
                  }
            });

            

            //Validación de tablilla existente
            var elementTablilla = document.getElementById('tablilla');
            elementTablilla.addEventListener("change", function (evt) {
                var tablilla = $('#tablilla').val();
                $.get('consulta/tablilla/' + tablilla, function (data) {
                    console.log(data.code);
                    if(data.code == 200){
                        Swal.fire({
                            title: data.msg,
                            icon: "warning",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#tablilla').val('');
                    }
                });
            }, false);
            
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
                if($('#nombre').val() == '' || $('#email').val() == '' || $('#telefono').val() == '' || $('#compania').val() == '' || $('#vehiculo').val() == '' || $('#tablilla').val() == '' || $('#marca').val() == '' || $('#anio').val() == '' || $('#seguro_social').val() == '' || $('#mes_vencimiento').val() == '' || $('#identificacion').val() == ''){
                    Swal.fire({
                        title: 'Hay campos vacíos',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                var rol_id = {{ Auth::user()->rol_id }};
                if($('#costo_inspeccion_id').val() == 0 && $('#costo_admin').val() == 0 || $('#costo_admin').val() == ''){
                    Swal.fire({
                        title: '¿El administrador ingresará el costo de inspección?',
                        //text: "You won't be able to revert this!",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar!',
                        cancelButtonText: 'Cancelar!',
                        confirmButtonClass: 'btn btn-success mt-2',
                        cancelButtonClass: 'btn btn-danger ms-2 mt-2',
                        buttonsStyling: false,
                    }).then(function (result) {
                        if (result.value) {
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
                                    costo_inspeccion: $('#costo_inspeccion_id').val(),
                                    identificacion: $('#identificacion').val(),
                                    costo_inspeccion_admin: $('#costo_admin').val()
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
                                            {{--  timer: 2000  --}}
                                        });
                                    }
            
                                },
                                error: function (data) {
                                }
                            });    
                        } else {
                            // Read more about handling dismissals
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    });
                } else {
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
                            costo_inspeccion: $('#costo_inspeccion_id').val(),
                            identificacion: $('#identificacion').val(),
                            costo_inspeccion_admin: $('#costo_admin').val()
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
                                    {{--  timer: 2000  --}}
                                });
                            }
    
                        },
                        error: function (data) {
                        }
                    });
                }
            });

            $('.btnCostoInspeccion').click(function () {
                var id = $(this).attr('data-id');
                $('#costo_inspeccion_id').val(id);
            });

            $('.btnInspeccionMarbete').click(function () {
                var id = $(this).attr('data-id');
                $('#marbete_id').val(id);
            });

            $('.btnInspeccionSeguro').click(function () {
                var id = $(this).attr('data-id');
                $('#seguro_id').val(id);
            });

            $('.costoServicioObligatorio').click(function () {
                $('#marbete_five_id').val(5);
                $('.cardMain').removeClass("border border-success").addClass("bg-success");
                $('.text-success').removeClass("border border-success").addClass("text-white");
            });

            // Botón que guarda el marbete seleccionado en el modal del módulo de Inspección
            $('#saveInspeccionMarbete').click(function () {
                if($('#marbete_five_id').val() == 0){
                    Swal.fire({
                        title: '¡Debe seleccionar el costo de servicio!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                
                if($('#marbete_id').val() == '' && $('#costo_marbete_admin').val() == ''){
                    Swal.fire({
                        title: '¿El administrador ingresará el costo de marbete?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar!',
                        cancelButtonText: 'Cancelar!',
                        confirmButtonClass: 'btn btn-success mt-2',
                        cancelButtonClass: 'btn btn-danger ms-2 mt-2',
                        buttonsStyling: false,
                    }).then(function (result) {
                        if (result.value) {
                            $.ajax({
                                type : 'POST',
                                url :"{{ route('vehiculo.marbete') }}",
                                data : { 
                                    _token: "{{ csrf_token() }}",
                                    marbete_id: $('#marbete_id').val(),
                                    costo_marbete_admin: $('#costo_marbete_admin').val(),
                                    marbete_five_id : $('#marbete_five_id').val()
                                },
                                success: function (data) {
                                    if (data.code == 201) {
                                        Swal.fire({
                                            title: data.msg,
                                            icon: "success",
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        $('#select_marbete').modal('hide');
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
                                    // console.log(data);
                                }
                            });      
                        } else {
                            // Read more about handling dismissals
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    });   
                } else {
                    $.ajax({
                        type : 'POST',
                        url :"{{ route('vehiculo.marbete') }}",
                        data : { 
                            _token: "{{ csrf_token() }}",
                            marbete_id: $('#marbete_id').val(),
                            costo_marbete_admin: $('#costo_marbete_admin').val(),
                            marbete_five_id : $('#marbete_five_id').val()
                        },
                        success: function (data) {
                            if (data.code == 201) {
                                Swal.fire({
                                    title: data.msg,
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                $('#select_marbete').modal('hide');
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
                            // console.log(data);
                        }
                    }); 
                }
            });

            // Botón que guarda el marbete seleccionado en el modal del módulo de Inspección
            $('#saveInspeccionSeguro').click(function () {
                if($('#seguro_id').val() == 0){
                    Swal.fire({
                        title: '¡Debe seleccionar un seguro!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                Swal.fire({
                    title: 'Seguro guardado',
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#modal_inspeccion_seguro').modal('hide');
            });
        });
    </script>
@endsection