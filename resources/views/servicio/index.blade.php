@extends('layouts.master')

@section('title')
    Servicios
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-sm-12">
        <div class="col-sm-12">
            <div class="text-sm-end mb-4">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add_servicio"
                    class="btn btn-success btn-rounded waves-effect waves-light mb-2"><i
                        class="mdi mdi-plus me-1"></i> Agregar</button>
            </div>
        </div>
        <div class="row col-md-12">
            @foreach ($servicios as $servicio)
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="favorite-icon">
                                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                            </div>
                            <img src="{{ URL::asset('build/images/companies/adobe.svg') }}" alt="" height="50" class="mb-3">
                            <h5 class="fs-17 mb-2"><a href="job-details" class="text-dark">{{ $servicio->nombre }} </a></h5>
                            <div class="mt-4">
                                <button class="btn btn-soft-success editServicio" data-id="{{ $servicio->id }}"><i class="mdi mdi-pencil font-size-8 me-1"></i> Editar </a></li>
                                <button class="btn btn-soft-danger waves-effect waves-light inActivarServicio" data-id="{{ $servicio->id }}" data-estatus="{{ $servicio->estatus_id }}"><i class="mdi mdi-trash-can-outline font-size-16 text-danger me-1"></i>@if ($servicio->estatus_id == 1) Desactivar @else Activar @endif</button>
                            </div>
                            @if ($servicio->id == 1)
                                <button class="btn btn-soft-info waves-effect waves-light addCostoInspecion" data-id="{{ $servicio->id }}"><i class="mdi mdi-plus font-size-16 text-info me-1"></i>Costos de Inspección</button>
                            @else
                                <button class="btn btn-soft-info waves-effect waves-light addSubServicio" data-id="{{ $servicio->id }}"><i class="mdi mdi-plus font-size-16 text-info me-1"></i>SubServicios</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @include('servicio.add')
    @include('servicio.edit')
    @include('servicio.addCostoInspeccion')
    @include('servicio.addSubservicio')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            //Crear servicio
            $('#saveServicios').click(function () {
                if($('#nombre').val() == ''){
                    Swal.fire({
                        title: 'El nombre del servicio es requerido',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $('#add_servicio').modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('servicio.store') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#nombre').val()
                    },
                    success: function (data) {
                        if (data.code == 201) {
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

            //Mostrar modal para actualizar estatus
            $(document).on('click','.editServicio',function(){
                var id = $(this).attr('data-id');
                $.get('servicio/' + id, function (data) {
                    $('#up_id').val(data.data.id);
                    $('#up_nombre').val(data.data.nombre);
                    $('#update_servicio').modal('show');
                })
            });

            //Actualizar servicio
            $('#updateServicio').click(function () {
                var id = $('#up_id').val();
                if($('#up_nombre').val() == ''){
                    Swal.fire({
                        title: 'El nombre del servicio es requerido',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $('#update_servicio').modal('hide');
                $.ajax({
                    type: 'PATCH',
                    url: 'servicio/'+id,
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#up_nombre').val()
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

            //Cambiar estatus al servicio
            $('.inActivarServicio').click(function () {
                var id = $(this).attr('data-id');
                var estatus = $(this).attr('data-estatus');
                var estado = '';
                if(estatus == 1){
                    estado = 'desactivar';
                } else {
                    estado = 'activar';
                }
                Swal.fire({
                    title: '¿Seguro de '+estado+' este servicio?',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    showLoaderOnConfirm: true,
                    confirmButtonColor: "#556ee6",
                    cancelButtonColor: "#f46a6a",
                    preConfirm: function () {
                        return new Promise(function (resolve, reject) {
                            setTimeout(function () {
                                resolve()
                            }, 2000)
                        })
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'delete',
                            url: 'servicio/'+id,
                            data : { 
                                _token: "{{ csrf_token() }}" 
                            },
                            success: function (data) {
                                if (data.code == 200) {
                                    Swal.fire({
                                        title: data.msg,
                                        icon: "success",
                                        position: 'top-center',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 1000);
                                }
                            },
                            error: function (data) {
                                // console.log(data);
                            }
                        });
                    }
                })
            });

            //Mostrar modal para agregar costos de inspección
            $(document).on('click','.addCostoInspecion',function(){
                var id = $(this).attr('data-id');
                $('#ci_servicio_id').val(id);
                $('#add_costo_inspeccion').modal('show');
            });

            //Guardar costos de inspección
            $('#saveCostoInspeccion').click(function () {
                if($('#ci_nombre').val() == ''){
                    Swal.fire({
                        title: 'El nombre es requerido',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#ci_costo').val() == ''){
                    Swal.fire({
                        title: 'El costo es requerido',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $('#add_costo_inspeccion').modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('servicio.store.subservicio') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        id: $('#ci_servicio_id').val(),
                        nombre: $('#ci_nombre').val(),
                        costo: $('#ci_costo').val()
                    },
                    success: function (data) {
                        if (data.code == 201) {
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

            //Mostrar modal para agregar subservicios
            $(document).on('click','.addSubServicio',function(){
                var id = $(this).attr('data-id');
                $.get('subservicios/' + id, function (data) {
                    $('#sub_id').val(id);
                    $('#add_sub_servicio').modal('show');
                });
            });

             //Crear subservicio
             $('#saveSubServicios').click(function () {
                if($('#sub_nombre').val() == ''){
                    Swal.fire({
                        title: 'El nombre es requerido',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $('#add_sub_servicio').modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('servicio.store.subservicio') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        id: $('#sub_id').val(),
                        nombre: $('#sub_nombre').val(),
                        costo: $('#sub_costo').val()
                    },
                    success: function (data) {
                        if (data.code == 201) {
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

        });
    </script>
@endsection
