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
                    <small>@if (isset($cliente)) {{ $cliente->nombre }} @endif </small><br>
                    <input type="hidden" name="vehiculo_id" id="vehiculo_id" value="{{ $vehiculo_id }}">
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
                <h1 class="mt-0 mb-4 text-white"> Inspección </h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3" @if ($vehiculo_id != null) id="ventaMarbetes" @endif>
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Marbetes </h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3" @if ($vehiculo_id != null) id="seguro" @endif>
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Seguros </h1>     
            </div>
        </div>
    </div>
    <div class="col-lg-3" @if ($vehiculo_id != null) id="extras" @endif>
        <div class="card bg-success text-white-50">
            <div class="card-body text-center">
                <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                <h1 class="mt-0 mb-4 text-white"> Extras </h1>
               
            </div>
        </div>
    </div>
</div>
@if ($en_curso == 1)
    <div class="row col-sm-12 text-center">
        {{--  @if ($nextPago != 0)  --}}
            <div class="col-sm-4 col-sm-2">
                <a type="button" href="{{ route('checkout.index')}}" class="btn btn-soft-info col-md-8 waves-effect waves-light btn-lg"> CONTINUAR A PAGAR </a>
            </div>
        {{--  @endif  --}}
        <div class="col-sm-4 col-sm-2">
            <button type="button" class="btn btn-soft-warning col-md-8 waves-effect waves-light btn-lg pendientePorPagar" data-id="{{ $vehiculo_id }}"> PENDIENTE </button>
        </div>
        <div class="col-sm-3 col-sm-2">
            <button type="button" class="btn btn-soft-danger col-md-8 waves-effect waves-light btn-lg finalizarProceso" data-id="{{ $vehiculo_id }}"> CANCELAR </button>
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

            $('input[type=number]').keypress(function(key) {
                if(key.charCode < 48 || key.charCode > 57) return false;
            });

            function validarEmail(email) {
                // Expresión regular para validar un correo electrónico
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

            // Se deshabilita cuando ya se tiene una venta en curso.
            var total_checkout = {{$total_checkout}};
            if(total_checkout != 0){
                $('#change_entidad').prop('disabled', true);
            }

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

             //Crear Cliente-vehículo
            $('#saveVehiculo').click(function () {
                if($('#tipo_registro').val() == 0 && $('#tablilla').val() == '') {
                    Swal.fire({
                        title: 'La tablilla es requerida',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                } else if($('#nombre').val() == '' || $('#email').val() == '' || $('#telefono').val() == '' || $('#compania').val() == '' || $('#vehiculo').val() == '' || $('#marca').val() == '' || $('#anio').val() == '' || $('#seguro_social').val() == '' || $('#mes_vencimiento').val() == '' || $('#identificacion').val() == ''){
                    Swal.fire({
                        title: 'Hay campos vacíos',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                var reg_tablilla = 0;
                if($('#tipo_registro').val() == 0){
                    reg_tablilla = $('#tablilla').val();
                } else {
                    reg_tablilla = $('.select_tablilla_vehiculo').val();
                }
                if (!validarEmail($('#email').val())) {
                    Swal.fire({
                        title: 'Ingrese un correo válido',
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
                        tablilla: reg_tablilla,
                        marca: $('#marca').val(),
                        anio: $('#anio').val(),
                        seguro_social: $('#seguro_social').val(),
                        mes_vencimiento: $('#mes_vencimiento').val(),
                        costo_inspeccion: $('#costo_inspeccion_id').val(),
                        identificacion: $('#identificacion').val(),
                        costo_inspeccion_admin: $('#costo_admin').val(),
                        vehiculo_id: $('#vehiculo_id').val(),
                        tipo_registro: $('#tipo_registro').val()
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
                        } else {
                            Swal.fire({
                                title: data.msg,
                                icon: "warning",
                                showConfirmButton: false,
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
                            marbete_five_id : $('#marbete_five_id').val(),
                            derecho_anual : $('#derecho_anual').val()
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

            // Botón que guarda el seguro seleccionado en el modal del módulo de Inspección
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
                $.ajax({
                    type : 'POST',
                    url :"{{ route('vehiculo.seguro') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        seguro_id: $('#seguro_id').val()
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

            $('.finalizarProceso').click(function () {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: "Motivo por el cual finaliza",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "on"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: 'Cancelar!',
                    showLoaderOnConfirm: true,
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
                                vehiculo_id: id,
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
                                vehiculo_id: id,
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
            
        });

        // Selector de tipo de registro
        $("#tipo_registro").on("change", function() {
            var tipo_registro = $(this).val();
            if(tipo_registro == 1){
                document.getElementById("cliente_select_id").style.display = "initial";
                document.getElementById("cliente_select_tablilla").style.display = "initial";
                $(".cliente_select_tablilla").attr("disabled", "disabled");
                $("#tablilla").attr("disabled", "disabled");
            }else{
                document.getElementById("cliente_select_id").style.display = "none";
                document.getElementById("cliente_select_tablilla").style.display = "none";
                $("#tablilla").attr("disabled", false);
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
                            {{--  console.log(data.vehiculos[i].tablilla);  --}}
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