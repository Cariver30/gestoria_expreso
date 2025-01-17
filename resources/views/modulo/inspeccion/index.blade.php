@extends('layouts.master')

@section('title')
    Inspección
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-sm-12 text-center" style="margin-left: 35%;">
        <div class="col-sm-3 col-sm-2">
            <label class="card-radio-label mb-3">
                <input type="radio" name="suma_total" id="suma_total" class="card-radio-input" checked="">
                <div class="card-radio">
                    <small>@if (isset($cliente)) {{ $cliente->nombre }} @endif </small><br>
                    <i class="bx bx-cart font-size-24 text-primary align-middle me-2"></i><span>Total: {{ $total_checkout}}</span>
                </div>
            </label>
        </div>
    </div>
<div class="row col-md-12">
    <div class="col-lg-3" id="inspeccionVehiculo">
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Inspección </h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3" @if (isset($venta) && $venta->id != null) id="ventaMarbetes" @endif>
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Marbetes </h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3" @if (isset($venta) && $venta->id != null) id="seguro" @endif>
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Seguros </h1>     
            </div>
        </div>
    </div>
    <div class="col-lg-3" @if (isset($venta) && $venta->id != null) id="extras" @endif>
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Extras </h1>
               
            </div>
        </div>
    </div>
</div>
@if (isset($venta) && $venta->estatus_id == 3)
    <div class="row col-sm-12 text-center">
        @if ($venta->total != 0)
            <div class="col-sm-4 col-sm-2">
                <a type="button" href="{{ route('checkout.index')}}" class="btn btn-soft-info col-md-8 waves-effect waves-light btn-lg"> PAGAR </a>
            </div>
            <div class="col-sm-4 col-sm-2">
                <button type="button" class="btn btn-soft-warning col-md-8 waves-effect waves-light btn-lg pendientePorPagar" data-id="{{ $venta->id }}"> PENDIENTE </button>
            </div>
        @endif
        <div class="col-sm-3 col-sm-2">
            <button type="button" class="btn btn-soft-danger col-md-8 waves-effect waves-light btn-lg finalizarProceso" data-id="{{ $venta->id }}"> CANCELAR </button>
        </div>
    </div>
@endif
@include('modulo.inspeccion.vehiculo.add')
@include('modulo.inspeccion.marbete.add')
@include('modulo.inspeccion.seguro.add')
@include('modulo.inspeccion.extras.add')
@include('modulo.inspeccion.extras.licencia')
@include('modulo.inspeccion.extras.notificacion')
@include('modulo.inspeccion.extras.costo_servicio')
@include('modulo.inspeccion.extras.venta_multa')
@include('modulo.inspeccion.marbete.marbeteacaa')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
        function validateFileType(){ // Se válida el formato de la imagen a subir
            var fileName = document.getElementById("file_licencia").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                //TO DO
            }else{
                alert("Only jpg/jpeg and png files are allowed!");
            }   
        }

        function unCheckRadio(rbutton) {
            rbutton.checked=(rbutton.checked) ? false : true;
        }
    </script>
    <script>
        $(document).ready(function() {

            // Función y expresión regular para validar un correo electrónico
            function validarEmail(email) {
                const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                return regex.test(email);
            }

            //Se obtiene el dato de un cliente ya registrado
            var seguroSocial = document.getElementById('seguro_social');
            seguroSocial.addEventListener("change", function (evt) {
                var numSeguroSocial = $('#seguro_social').val();
                if(numSeguroSocial.length == 4) {
                    $.get('consulta/seguro-social/' + numSeguroSocial, function (data) {
                        if(data.code == 200){
                            $('#nombre').val(data.data.nombre);
                            $('#email').val(data.data.email);
                            $('#telefono').val(data.data.telefono);
                            $('#identificacion').val(data.data.identificacion);
                        } else if(data.code == 400){
                            $('#nombre').val('');
                            $('#email').val('');
                            $('#telefono').val('');
                            $('#identificacion').val('');
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'El seguro social debe de ser de 4 dígitos',
                        icon: "warning",
                        showConfirmButton: false
                    });
                    $('#seguro_social').val('');
                    return false;
                }
            }, false);

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

            // Se deshabilita cuando ya se tiene una venta en curso.
            var total_checkout = {{$total_checkout}};
            if(total_checkout != 0){
                $('#change_entidad').prop('disabled', true);
            }

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
                    case '4':
                        $('#extra_licencia').modal('show');
                        break;
                    case '5':
                        $('#extra_notificacion').modal('show')
                        break;
                    case '6':
                        $('#extra_costo_servicio').modal('show')
                        break;
                    case '9':
                        $('#extra_venta_multas').modal('show')
                        break;
                }
            });

            //Crear Cliente-vehículo
            $('#saveVehiculo').click(function (e) {
                e.preventDefault();
                var formData = $("#RegistroInspeccion").submit(function (e) {
                    return;
                });
                if($('#seguro_social').val() == ''){
                    Swal.fire({
                        title: '¡Debe ingresar el seguro social!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#nombre').val() == ''){
                    Swal.fire({
                        title: '¡Debe ingresar el nombre!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#email').val() == ''){
                    Swal.fire({
                        title: '¡Debe ingresar un email!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if (!validarEmail($('#email').val())) {
                    Swal.fire({
                        title: '¡Ingrese un correo válido!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#telefono').val() == ''){
                    Swal.fire({
                        title: '¡Debe ingresar un teléfono!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#compania').val() == ''){
                    Swal.fire({
                        title: '¡Debe ingresar el nombre de la compañía!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#compania').val() == ''){
                    Swal.fire({
                        title: '¡Debe ingresar el nombre de la compañía!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#identificacion').val() == ''){
                    Swal.fire({
                        title: '¡Debe ingresar la identificación!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#vehiculo').val() == ''){
                    Swal.fire({
                        title: 'El campo vehículo es requerido!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#tablilla').val() == '') {
                    Swal.fire({
                        title: '¡Debe ingresar la tablilla!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#marca').val() == ''){
                    Swal.fire({
                        title: 'El campo de marca es requerido',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#anio').val() == ''){
                    Swal.fire({
                        title: 'El campo de año es requerido',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#mes_vencimiento').val() == ''){
                    Swal.fire({
                        title: 'El campo de mes de vencimiento es requerido',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if(!document.querySelector('input[name="valorInspeccion"]:checked')) {
                    Swal.fire({
                        title: '¡Debe seleccionar una opción de costo de inspección!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
              

                var formData = new FormData(formData[0]);
                $.ajax({
                    type : 'POST',
                    url :"{{ route('clientes.store') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formData,
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
                        } else if (data.code == 200) {
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
                        } else if (data.code == 400) {
                            Swal.fire({
                                title: data.msg,
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        } else {
                            Swal.fire({
                                title: data.msg,
                                icon: "warning",
                                showConfirmButton: false,
                            });
                        }

                    },
                    contentType: false,
                    processData: false,
                    cache: false,
                    error: function (data) {
                    }
                });
            });
            



            //------------------------------------------------------- SEGUROS --------------------------------------------------------------
            //Se detecta el change para habilitar el input de núm de vaucher cuando es seguro privado
            $("#seguro_id").on("change", function() {
                var seguro_id = $(this).val();
                if(seguro_id == 1){
                    document.getElementById("opcion_vaucher").style.display = "initial";
                }else{
                    document.getElementById("opcion_vaucher").style.display = "none";
               }
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
                if($('#costoServicio').prop('checked') == false){
                    Swal.fire({
                        title: '¡Debe seleccionar el costo de servicio!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($(".btnValorMarbete").is(':checked') == false){
                    Swal.fire({
                        title: '¡Debe seleccionar una opción de marbete!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($(".marbeteacaa").is(':checked') == false){
                    Swal.fire({
                        title: '¡Debe seleccionar un marbete acaa!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                {{--  if($(".btnValorMarbete").is(':checked') == false){  --}}
                    $.ajax({
                        type : 'POST',
                        url :"{{ route('vehiculo.marbete') }}",
                        data : { 
                            _token: "{{ csrf_token() }}",
                            marbete_id: $("input[type=radio][name=valorMarbete]:checked").val(),
                            costo_marbete_admin: $('#costo_marbete_admin').val(),
                            marbete_five_id : $("input[type=radio][name=costoServicio]:checked").val(),
                            derecho_anual : $('#derecho_anual').val(),
                            marbete_acaa_id: $("input[type=radio][name=marbeteacaa]:checked").val()
                        },
                        success: function (data) {
                            if (data.code == 200) {
                                $('#select_marbete').modal('hide');
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
                            // console.log(data);
                        }
                    });
                {{--  } else {
                    $.ajax({
                        type : 'POST',
                        url :"{{ route('vehiculo.marbete') }}",
                        data : { 
                            _token: "{{ csrf_token() }}",
                            marbete_id: $("input[type=radio][name=valorMarbete]:checked").val(),
                            costo_marbete_admin: $('#costo_marbete_admin').val(),
                            marbete_five_id : $("input[type=radio][name=costoServicio]:checked").val(),
                            derecho_anual : $('#derecho_anual').val(),
                            marbete_acaa_id: $("input[type=radio][name=marbeteacaa]:checked").val(),
                            venta_id: $('#venta_id').val()
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
                }  --}}
            });

            // Botón que guarda el marbete ACAA seleccionado
            $('#saveMarbeteAcaa').click(function () {
                if($(".marbeteacaa").is(':checked') == false){
                    Swal.fire({
                        title: '¡Debe seleccionar un marbete acaa!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('vehiculo.marbete.acaa') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        venta_id: $('#venta_id').val(),
                        marbete_acaa_id: $("input[type=radio][name=marbeteacaa]:checked").val()
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
            });      

            // Botón que guarda el seguro seleccionado en el modal del módulo de Inspección
            $('#saveInspeccionSeguro').click(function () {
                if($(".valorSeguro").is(':checked') == false){
                    Swal.fire({
                        title: '¡Debe seleccionar un seguro!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('vehiculo.seguro') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        venta_id: $('#venta_id').val(),
                        seguro_id: $("input[type=radio][name=valorSeguro]:checked").val()
                    },
                    success: function (data) {
                        if (data.code == 200) {
                            $('#modal_inspeccion_seguro').modal('hide');
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
            });

            // Botón que guarda en servicios extra - Licencia
            $('#saveExtraLicencia').click(function () {
                if($(".valorExtraLicencia").is(':checked') == false){
                    Swal.fire({
                        title: '¡Debe seleccionar un tipo de licencia!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('vehiculo.extras.licencia') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        licencia_id: $("input[type=radio][name=valorExtraLicencia]:checked").val()
                    },
                    success: function (data) {
                        if (data.code == 200) {
                            $('#extra_licencia').modal('hide');
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
            });

            // Botón que guarda en servicios extra - Notificaciones
            $('#saveExtraNotificacion').click(function () {
                if($(".valorExtraNotificacion").is(':checked') == false){
                    Swal.fire({
                        title: '¡Debe seleccionar un tipo de notificación!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('vehiculo.extras.notificacion') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        notificacion_id: $("input[type=radio][name=valorExtraNotificacion]:checked").val()
                    },
                    success: function (data) {
                        if (data.code == 200) {
                            $('#extra_notificacion').modal('hide');
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
                        // console.log(data);
                    }
                }); 
            });

             // Botón que guarda en servicios extra - Multas de Ley
             $('#saveExtraMulta').click(function () {
                if($(".valorExtraMulta").is(':checked') == false){
                    Swal.fire({
                        title: '¡Debe seleccionar un tipo de multa de ley!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('vehiculo.extras.multa') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        multa_id: $("input[type=radio][name=valorExtraMulta]:checked").val()
                    },
                    success: function (data) {
                        if (data.code == 200) {
                            $('#extra_venta_multas').modal('hide');
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
                        // console.log(data);
                    }
                }); 
            });

            $('.finalizarProceso').click(function () {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: "Motivo",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "on"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: 'Cancelar!',
                    showLoaderOnConfirm: false,
                    inputValidator: function (value) {
                        return !value && 'Debe ingresar un motivo'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type : 'POST',
                            url :"{{ route('cancelar.venta') }}",
                            data : { 
                                _token: "{{ csrf_token() }}",
                                venta_id: id,
                                motivo : result.value
                            },
                            success: function (data) {
                                if (data.code == 200) {
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
                                // console.log(data);
                            }
                        }); 
                    }
                });
            });

            $('.pendientePorPagar').click(function () {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: "La venta pasará a pendiente por pagar, ¿está seguro?",
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: 'Cancelar!',
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type : 'POST',
                            url :"{{ route('pendiente.venta') }}",
                            data : { 
                                _token: "{{ csrf_token() }}",
                                venta_id: id
                            },
                            success: function (data) {
                                if (data.code == 200) {
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
                                // console.log(data);
                            }
                        }); 
                    }
                });
            });
            
        });

        // Selector de tipo de registro
        $("#tipo_registro").on("change", function() {
            var tipo_registro = $(this).val();
            if(tipo_registro == 1){
                document.getElementById("cliente_select_id").style.display = "initial";
                document.getElementById("cliente_select_tablilla").style.display = "initial";
                $(".cliente_select_tablilla").attr("disabled", "disabled");
                $("#tablilla").attr("readOnly", true);
            }else{
                document.getElementById("cliente_select_id").style.display = "none";
                document.getElementById("cliente_select_tablilla").style.display = "none";
                $("#tablilla").attr("readOnly", false);
                $('#seguro_social').val('');
                $('#nombre').val('');
                $('#email').val('');
                $('#telefono').val('');
                $('#identificacion').val('');
                $('#compania').val('');
                $('#vehiculo').val('');
                $('#tablilla').val('');
                $('#marca').val('');
                $('#anio').val('');
                $('#mes_vencimiento').val('');
           }
        });

        //Obtener las tablillas de un cliente para agregar servicio
        $(".buscarTablillaCliente").on("change", function() {
            var idCliente = $("#getClientes").val();
            $.ajax({
                type : 'GET',
                url :"{{ route('cliente.tablillas') }}",
                data : { 
                    _token: "{{ csrf_token() }}",
                    idCliente: idCliente,
                },
                success: function (data) {
                    if (data.code == 200) {
                        $(".select_tablilla_vehiculo").attr("disabled", false);
                        console.log(data.cliente);
                        var fila = '';
                        for (let i = 0; i < data.vehiculos.length; i++) {
                            fila += '<option value="'+data.vehiculos[i].tablilla+'">'+data.vehiculos[i].vehiculo+' - '+data.vehiculos[i].tablilla+'</option>';
                        }
                        $(".select_tablilla_vehiculo").append(fila)
                        $('#seguro_social').val(data.cliente.seguro_social);
                        $('#nombre').val(data.cliente.nombre);
                        $('#email').val(data.cliente.email);
                        $('#telefono').val(data.cliente.telefono);
                        $('#identificacion').val(data.cliente.identificacion);
                    } else {
                        Swal.fire({
                            title: data.msg,
                            icon: "warning",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#seguro_social').val('');
                        $('#nombre').val('');
                        $('#email').val('');
                        $('#telefono').val('');
                        $(".select_tablilla_vehiculo").val('');
                        $(".select_tablilla_vehiculo").attr("disabled", true);
                    }
                },
                error: function (data) {
                    // console.log(data);
                }
            });
        });

        //get data vehículo por tablilla
        $(".select_tablilla_vehiculo").on("change", function() {
            var getDataTablilla = $(this).val();
            $.ajax({
                type : 'GET',
                url :"{{ route('cliente.tablilla.vehiculo') }}",
                data : { 
                    _token: "{{ csrf_token() }}",
                    getDataTablilla: getDataTablilla,
                },
                success: function (data) {
                    if (data.code == 200) {
                        console.log(data.vehiculo[0]);
                        $('#anio').val(data.vehiculo[0].anio);
                        $('#marca').val(data.vehiculo[0].marca);
                        $('#vehiculo').val(data.vehiculo[0].vehiculo);
                        $('#compania').val(data.vehiculo[0].compania);
                        $('#tablilla').val(data.vehiculo[0].tablilla);
                        $('#mes_vencimiento option[value="'+data.vehiculo[0].mes_vencimiento_id+'"]').attr("selected", "selected");
                    }
                },
                error: function (data) {
                    // console.log(data);
                }
            });
        });

    </script>
@endsection