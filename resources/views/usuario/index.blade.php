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
                <button type="button" data-bs-toggle="modal" data-bs-target="#add_usuario"
                    class="btn btn-success btn-rounded waves-effect waves-light mb-2"><i
                        class="mdi mdi-plus me-1"></i> Agregar</button>
            </div>
        </div>
        <div class="row col-md-12">
            @foreach ($usuarios as $usuario)
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="favorite-icon">
                                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                            </div>
                            <img src="{{ URL::asset('build/images/companies/adobe.svg') }}" alt="" height="50" class="mb-3">
                            <h5 class="fs-17 mb-2"><a href="job-details" class="text-dark">{{ $usuario->nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}</a></h5>
                            <small>{{ $usuario->rol }}</small>
                            <div class="mt-4">
                                <button class="btn btn-soft-success editUsuario" data-id="{{ $usuario->id }}"><i class="mdi mdi-pencil font-size-8 me-1"></i> Editar </button></li>
                                
                                @if ($usuario->estatus_id == 1)
                                    <button class="btn btn-soft-danger inActivarUsuario" data-id="{{ $usuario->id }}" data-estatus="1"><i class="mdi mdi-account-convert font-size-16 text-danger me-1"></i>Suspender</button>   
                                @else
                                    <button class="btn btn-soft-warning inActivarUsuario" data-id="{{ $usuario->id }}" data-estatus="2"><i class="mdi mdi-account-convert font-size-16 text-warning me-1"></i>Activar</button>
                                @endif
                                <button class="btn btn-soft-info" data-id="{{ $usuario->id }}"><i class="mdi mdi-cached font-size-16 text-info me-1"></i>Resetear PIN</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @include('usuario.add')
    @include('usuario.edit')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            //Crear usuarios
            $('#saveUsuario').click(function () {
                var id = $(this).attr('data-id');
                var metodo = $(this).attr('data-metodo');
                if($('#nombre').val() == '' || $('#primer_apellido').val() == '' || $('#email').val() == '' || $('#rol_id').val() == '' || $('#entidad_id').val() == ''){
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
                    url :"{{ route('usuario.store') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#nombre').val(),
                        primer_apellido: $('#primer_apellido').val(),
                        segundo_apellido: $('#segundo_apellido').val(),
                        email: $('#email').val(),
                        rol_id: $('#rol_id').val(),
                        entidad_id: $('#entidad_id').val()
                    },
                    success: function (data) {
                        if (data.code == 201) {
                            console.log('f');
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
                            console.log('fasas');
                            Swal.fire({
                                title: data.msg,
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }

                    },
                    error: function (data) {
                        console.log('aaaa');
                    }
                });
            });

            //Mostrar modal para actualizar estatus
            $(document).on('click','.editUsuario',function(){
                var id = $(this).attr('data-id');
                $.get('usuario/' + id, function (data) {
                    $('#up_id').val(data.data.id);
                    $('#up_nombre').val(data.data.nombre);
                    $('#up_primer_apellido').val(data.data.primer_apellido);
                    $('#up_segundo_apellido').val(data.data.segundo_apellido);
                    $('#up_email').val(data.data.email);
                    $('#up_rol_id option[value="'+data.data.rol_id+'"]').attr("selected", "selected");
                    $('#up_entidad_id option[value="'+data.data.sede_id+'"]').attr("selected", "selected");
                    $('#update_usuario').modal('show');
                })
            });

            //Actualizar usuario
            $('#updateUsuario').click(function () {
                var id = $('#up_id').val();
                if($('#up_nombre').val() == '' || $('#up_primer_apellido').val() == '' || $('#up_email').val() == '' || $('#up_rol_id').val() == '' || $('#up_entidad_id').val() == ''){
                    Swal.fire({
                        title: 'Hay campos vacíos',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $('#update_usuario').modal('hide');
                $.ajax({
                    type: 'PATCH',
                    url: 'usuario/'+id,
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#up_nombre').val(),
                        primer_apellido: $('#up_primer_apellido').val(),
                        segundo_apellido: $('#up_segundo_apellido').val(),
                        email: $('#up_email').val(),
                        rol_id: $('#up_rol_id').val(),
                        entidad_id: $('#up_entidad_id').val()
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

            //Inhabilitar
            $('.inActivarUsuario').click(function () {
                var id = $(this).attr('data-id');
                var estatus = $(this).attr('data-estatus');
                var estado = '';
                if(estatus == 1){
                    estado = 'suspender';
                } else {
                    estado = 'habilitar';
                }
                Swal.fire({
                    title: '¿Desea '+estado+' a este usuario?',
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
                            url: 'usuario/'+id,
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
