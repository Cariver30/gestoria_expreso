@extends('layouts.master')

@section('title')
    Sub Servicios
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-md-12">
        <div class="row col-md-12">
            <input type="hidden" name="servicio_id" id="servicio_id" value="{{ $id }}">
            <h3 class="col-md-6 text-end">{{ $servicio->nombre }}</h3>
            <div class="col-md-6 text-end">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add_sub_servicio" class="btn btn-lg btn-primary col-md-3"> Agregar </button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="table-responsive">
                        <table class="table project-list-table table-nowrap align-middle table-borderless">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Costo</th>
                                    <th scope="col">Estatus</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if (count($subservicios) == 0)
                                    <td colspan="4" class="text-center">SIN INFORMACIÓN </td>
                                @else
                                    @foreach ($subservicios as $subservicio)
                                        <tr>
                                            <td><p class="text-muted mb-0">{{ $subservicio->nombre }}</p></td>
                                            <td>@if ($subservicio->costo == '') 0 @else {{ $subservicio->costo }} @endif</td>
                                            <td>@if ($subservicio->estatus == 'Activo') <span class="badge bg-success"> @else <span class="badge bg-danger"> @endif {{ $subservicio->estatus }}</span></td>
                                            <td>
                                                <button class="btn btn-soft-success editSubservicio" data-id="{{ $subservicio->id }}" data-nombre="{{ $subservicio->nombre }}" data-costo="{{ $subservicio->costo }}"><i class="mdi mdi-pencil font-size-8 me-1"></i> Editar </a></li>
                                                <button class="btn btn-soft-danger" data-id="{{ $subservicio->id }}"><i class="mdi mdi-account-convert font-size-8 text-warning me-1"></i> Deshabilitar </a></li>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('servicio.addSubservicio')
    @include('servicio.editSubservicio')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            //Crear subservicio
            $('#btnGuardarSubservicio').click(function () {
                if($('#sub_nombre').val() == ''){
                    Swal.fire({
                        title: '¡El nombre es requerido!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: "{{ route('servicio.store.subservicio') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        servicio_id: $('#servicio_id').val(),
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

            //Mostrar modal para actualizar estatus
            $(document).on('click','.editSubservicio',function(){
                $('#sub_servicio_id').val($(this).attr('data-id'));
                $('#up_sub_nombre').val($(this).attr('data-nombre'));
                $('#up_sub_costo').val($(this).attr('data-costo'));
                $('#edit_sub_servicio').modal('show');
            });

            //Actualizar subservicio
            $('#btnUpdateSubservicio').click(function () {
                if($('#up_sub_nombre').val() == ''){
                    Swal.fire({
                        title: '¡El nombre es requerido!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type: 'PUT',
                    url: '/update/subservicio/'+ $('#sub_servicio_id').val(),
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#up_sub_nombre').val(),
                        costo: $('#up_sub_costo').val()
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
        });
    </script>
@endsection
