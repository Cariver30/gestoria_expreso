@extends('layouts.master')

@section('title')
    Usuarios
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-sm-12">
        <div class="col-sm-12">
            <div class="text-sm-end">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add_rol"
                    class="btn btn-success btn-rounded waves-effect waves-light mb-2"><i
                        class="mdi mdi-plus me-1"></i> Agregar</button>
            </div>
        </div>
        <div class="row col-md-12">
            @foreach ($roles as $rol)
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="favorite-icon">
                                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                            </div>
                            <img src="{{ URL::asset('images/expreso.jpeg') }}" alt="" height="50" class="mb-3">
                            <h5 class="fs-17 mb-2"><a href="job-details" class="text-dark">{{ $rol->nombre }} </a></h5>
                            <div class="mt-4">
                                <button class="btn btn-soft-success editRol" data-id="{{ $rol->id }}"><i class="mdi mdi-pencil font-size-8 me-1"></i> Editar </a></li>
                                <button class="btn btn-soft-danger waves-effect waves-light inActivarRol" data-id="{{ $rol->id }}" data-estatus="{{ $rol->estatus_id }}"><i class="mdi mdi-trash-can-outline font-size-8 text-danger me-1"></i>@if ($rol->estatus_id == 1) Desactivar @else Activar @endif</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @include('rol.add')
    @include('rol.edit')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            let ch_entidad = document.querySelector('#change_entidad');
            ch_entidad.addEventListener('change', function () {
                var id = $(this).val();
                $.get('sede/cambiar/' + id, function (data) {
                    Swal.fire({
                        title: data.msg,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                });
            });

            //Crear Rol
            $('#saveRol').click(function () {
                if($('#nombre').val() == ''){
                    Swal.fire({
                        title: 'El nombre del rol es requerido',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $('#add_rol').modal('hide');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('roles.store') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#nombre').val()
                    },
                    success: function (data) {
                        if (data.code == 201) {
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
                        } else {
                            Swal.fire({
                                title: data.msg,
                                icon: "warning",
                                position: 'top-center',
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
            $(document).on('click','.editRol',function(){
                var id = $(this).attr('data-id');
                $.get('roles/' + id, function (data) {
                    $('#up_id').val(data.data.id);
                    $('#up_nombre').val(data.data.nombre);
                    $('#update_rol').modal('show');
                })
            });

            //Actualizar rol
            $('#updateRol').click(function () {
                var id = $('#up_id').val();
                if($('#up_nombre').val() == ''){
                    Swal.fire({
                        title: 'El nombre del rol es requerido',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $('#update_rol').modal('hide');
                $.ajax({
                    type: 'PATCH',
                    url: 'roles/'+id,
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#up_nombre').val()
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
                        } else {
                            Swal.fire({
                                title: data.msg,
                                icon: "warning",
                                position: 'top-center',
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

            //Ajax
            $('.inActivarRol').click(function () {
                var id = $(this).attr('data-id');
                var estatus = $(this).attr('data-estatus');
                var estado = '';
                if(estatus == 1){
                    estado = 'desactivar';
                } else {
                    estado = 'activar';
                }
                Swal.fire({
                    title: '¿Seguro de '+estado+' este rol?',
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
                            url: 'roles/'+id,
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
                                    }, 2000);
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
