@extends('layouts.master')

@section('title')
    Gestoría
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-sm-12 text-center" style="margin-left: 41%;">
        <div class="col-sm-2 col-sm-2">
            <label class="card-radio-label mb-3">
                <input type="radio" name="suma_total" id="suma_total" class="card-radio-input" checked="">
                <div class="card-radio">
                    @if (isset($cliente)) <small> {{ $cliente->nombre }} </small><br>@endif
                    <input type="hidden" name="venta_id" id="venta_id" @if (isset($venta)) value="{{ $venta->id }}" @endif>
                    <i class="bx bx-cart font-size-24 text-primary align-middle me-2"></i><span>Total: {{$total_checkout}}</span>
                </div>
            </label>
        </div>
    </div>
    {{--  <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title"> Datos del cliente </h4>
            <div class="card-body">
                <div class="row col-md-12 mb-4">
                    <div class="col-md-3">
                        <label for="nombre" class="col-form-label"> Nombre </label>
                        <input type="text" class="form-control form-control-md" name="nombre" id="nombre" @if (isset($cliente)) value="{{ $cliente->nombre }}" @endif>
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="col-form-label"> Email </label>
                        <input type="email" class="form-control form-control-md" name="email" id="email" @if (isset($cliente)) value="{{ $cliente->email }}" @endif>
                    </div>
                    <div class="col-md-3">
                        <label for="telefono" class="col-form-label"> Teléfono </label>
                        <input type="text" class="form-control form-control-md" name="telefono" id="telefono" @if (isset($cliente)) value="{{ $cliente->telefono }}" @endif>
                    </div>
                    <div class="col-md-3">
                        <label for="seguro_social" class="col-form-label"> Seguro Social </label>
                        <input type="text" class="form-control form-control-md" name="seguro_social" id="seguro_social" @if (isset($cliente)) value="{{ $cliente->seguro_social }}" @endif>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="identificacion" class="col-form-label"> Licencia/Identificación </label>
                        <input type="text" class="form-control form-control-sm" name="identificacion" id="identificacion" @if (isset($cliente)) value="{{ $cliente->identificacion }}" @endif>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    
                    <div class="row col-sm-12 text-center">
                        <div class="col-md-3">
                            <button class="btn btn-soft-info col-md-8 waves-effect waves-light btn-lg" id="btnSaveClienteGestoria"> Guardar </a>
                        </div>
                        @if ($total_checkout != 0)
                            <div class="col-sm-4 col-sm-2">
                                <a type="button"  class="btn btn-soft-info col-md-8 waves-effect waves-light btn-lg"> CONTINUAR A PAGAR </a>
                            </div>
                        @endif
                        <div class="col-sm-4 col-sm-2">
                            <button type="button" class="btn btn-soft-warning col-md-8 waves-effect waves-light btn-lg" data-id="{{ $venta->id }}"> PENDIENTE </button>
                        </div>
                        <div class="col-sm-3 col-sm-2">
                            <button type="button" class="btn btn-soft-danger col-md-8 waves-effect waves-light btn-lg " data-id="{{ $venta->id }}"> CANCELAR </button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>  --}}
    <div class="row col-md-12">
        <div class="col-lg-3 servicioGestoria" data-id="00" id="serviciosGestoria">
            <div class="card bg-success text-white-50">
                <div class="card-body text-center">
                    <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                    <h1 class="mt-0 mb-4 text-white"> Registro </h1>
                </div>
            </div>
        </div>
        @if (isset($venta) && $venta->id != null)
            @foreach ($gestorias as $gestoria)
                <div class="col-lg-3 servicioGestoria" data-id="{{ $gestoria->id }}" id="serviciosGestoria">
                    <div class="card bg-success text-white-50">
                        <div class="card-body text-center">
                            <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                            <h1 class="mt-0 mb-4 text-white"> {{ $gestoria->nombre }} </h1>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <div class="col-md-12 text-center">
                    
            <div class="row col-sm-12 text-center">
                @if ($total_checkout != 0)
                    <div class="col-sm-4 col-sm-2">
                        <a type="button" href="{{ route('checkout.index')}}" class="btn btn-soft-info col-md-8 waves-effect waves-light btn-lg"> PAGAR </a>
                    </div>
                    <div class="col-sm-4 col-sm-2">
                        <button type="button" class="btn btn-soft-warning col-md-8 waves-effect waves-light btn-lg btnPendienteGestoria" data-id="{{ $venta->id }}"> PENDIENTE </button>
                    </div>
                @endif
                @if (isset($venta) && $venta->id != null)
                    <div class="col-sm-3 col-sm-2">
                        <button type="button" class="btn btn-soft-danger col-md-8 waves-effect waves-light btn-lg btnCancelarGestoria" data-id="{{ $venta->id }}"> CANCELAR </button>
                    </div>
                @endif
            </div>
            
        </div>
    </div>
    @include('modulo.gestoria.servicio.registro')
    @include('modulo.gestoria.servicio.transaccion')
    @include('modulo.gestoria.servicio.licencia')
    @include('modulo.gestoria.servicio.vehiculo')

    @include('modulo.gestoria.subservicio.subtransaccion')
    @include('modulo.gestoria.subservicio.subRotulo')
    @include('modulo.gestoria.subservicio.subRenovacion')
    @include('modulo.gestoria.subservicio.subAprendizaje')
    @include('modulo.gestoria.subservicio.subConducir')
    @include('modulo.gestoria.subservicio.subDireccion')
    @include('modulo.gestoria.subservicio.subTraspaso')
    @include('modulo.gestoria.subservicio.subVentaCondicional')
    @include('modulo.gestoria.subservicio.subGravamenes')
    @include('modulo.gestoria.subservicio.subRegistro')
    @include('modulo.gestoria.subservicio.subNotificacion')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            //Sección para mostrar modales principales
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
                    case '00':
                        $('#add_vehiculo_gestoria').modal('show')
                        break;
                }
            });

            //Sección para cada modal
            $(".btnGestoriaTransaccion").click(function() {
                var id = $(this).attr('data-id');
                if (id == 1) {
                    $('#subTransaccion').modal('show');
                }
                if (id == 2) {
                    $('#subRotulo').modal('show');
                }
            });

            //Mostra el modal acorde al servicio en el modal de licencias
            $(".btnGestoriaLicencia").click(function() {
                var id = $(this).attr('data-id');
                switch (id) {
                    case '3':
                        $('#subRenovacion').modal('show');
                        break;
                    case '4':
                        $('#subAprendizaje').modal('show')
                        break;
                    case '5':
                        $('#subConducir').modal('show')
                        break;
                    case '6':
                        $('#subDireccion').modal('show')
                        break;
                }
                
            });

            //Mostra el modal acorde al servicio en el modal de licencias
            $(".btnGestoriaVehiculo").click(function() {
                var id = $(this).attr('data-id');
                switch (id) {
                    case '7':
                        $('#subTraspaso').modal('show');
                        break;
                    case '8':
                        $('#subVentaCondicional').modal('show')
                        break;
                    case '9':
                        $('#subGravamenes').modal('show')
                        break;
                    case '10':
                        $('#subRegistros').modal('show')
                        break;
                    case '11':
                        $('#subNotificaciones').modal('show')
                        break;
                }
                
            });

            //Función que guarda y crea al cliente para iniciar la transacción
            $('#btnSaveClienteGestoria').click(function () {
                if($('#nombre').val() == '' || $('#email').val() == '' || $('#telefono').val() == '' || $('#seguro_social').val() == '' || $('#identificacion').val() == ''){
                    Swal.fire({
                        title: 'Hay campos vacíos',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
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
                    url :"{{ route('gestoria.cliente') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#nombre').val(),
                        email: $('#email').val(),
                        telefono: $('#telefono').val(),
                        seguro_social: $('#seguro_social').val(),
                        identificacion: $('#identificacion').val()
                    },
                    success: function (data) {
                        if (data.code == 200 || data.code == 201) {
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

            // Función y expresión regular para validar un correo electrónico
            function validarEmail(email) {
                const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                return regex.test(email);
            }

            //Función que guarda el servicio seleccionado en el modal de transacciones (segundo modal - primera opción)
            $('#saveGestoriaTransaccion').click(function () {
                if($(".btnValorTransaccion").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.transaccion') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        transaccion_id: $("input[type=radio][name=valorTransaccion]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de Título removible (segundo modal - segunda opción)
            $('#saveGestoriaTitulo').click(function () {
                if($(".btnValorTitulo").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.titulo') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        titulo_id: $("input[type=radio][name=valorTitulo]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de Título removible (Tercer modal - primera opción)
            $('#saveGestoriaRenovacion').click(function () {
                if($(".btnValorRenovacion").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.renovacion') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        renovacion_id: $("input[type=radio][name=valorRenovacion]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de aprendizaje (Tercer modal - segunda opción)
            $('#saveGestoriaAprendizaje').click(function () {
                if($(".btnValorAprendizaje").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.aprendizaje') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        aprendizaje_id: $("input[type=radio][name=valorAprendizaje]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de aprendizaje (Tercer modal - tercera opción)
            $('#saveGestoriaConducir').click(function () {
                if($(".btnValorConducir").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.conducir') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        conducir_id: $("input[type=radio][name=valorConducir]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de aprendizaje (Tercer modal - cuarta opción)
            $('#saveGestoriaDireccion').click(function () {
                if($(".btnValorDireccion").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.direccion') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        direccion_id: $("input[type=radio][name=valorDireccion]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de vehículo (Cuarto modal - primera opción)
            $('#saveGestoriaTraspaso').click(function () {
                if($(".btnValorTraspaso").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.traspaso') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        traspaso_id: $("input[type=radio][name=valorTraspaso]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de vehículo (Cuarto modal - segunda opción)
            $('#saveGestoriaVentaCondicional').click(function () {
                if($(".btnValorVentaCondicional").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.venta.condicional') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        venta_condicional_id: $("input[type=radio][name=valorVentaCondicional]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de vehículo (Cuarto modal - tercera opción)
            $('#saveGestoriaGravamen').click(function () {
                if($(".btnValorGravamen").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.gravamen') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        gravamen_id: $("input[type=radio][name=valorGravamen]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de vehículo (Cuarto modal - cuarta opción)
            $('#saveGestoriaRegistro').click(function () {
                if($(".btnValorRegistro").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.registro') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        registro_id: $("input[type=radio][name=valorRegistro]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función que guarda el servicio seleccionado en el modal de vehículo (Cuarto modal - quinta opción)
            $('#saveGestoriaNotificacion').click(function () {
                if($(".btnValorNotificacion").is(':checked') == false){
                    Swal.fire({
                        title: 'Debe seleccionar una opción',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('gestoria.notificacion') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        notificacion_id: $("input[type=radio][name=valorNotificacion]:checked").val(),
                        venta_id: $('#venta_id').val()
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
            });

            //Función para cancelar el registro actual
            $('.btnCancelarGestoria').click(function () {
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
                    showLoaderOnConfirm: true,
                    inputValidator: function (value) {
                        return !value && 'Debe ingresar un motivo'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type : 'POST',
                            url :"{{ route('gestoria.cancelar') }}",
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

            //Función para pasar a pendiente el registro actual
            $('.btnPendienteGestoria').click(function () {
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
                            url :"{{ route('gestoria.pendiente') }}",
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
    </script>
@endsection
