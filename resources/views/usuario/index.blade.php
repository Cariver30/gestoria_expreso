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
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="favorite-icon">
                                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                            </div>
                            <img src="{{ URL::asset('images/expreso.jpeg') }}" alt="" height="50" class="mb-3">
                            <h4 class="fs-17 mb-2"><a href="job-details" class="text-dark">{{ $usuario->nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}</a></h4>
                            <h5>{{ $usuario->rol }}</h5>
                            @foreach ($usuario->sucursales as $sucursal)
                                <h6>{{ $sucursal }}</h6>
                            @endforeach
                            <div class="mt-4">
                                <button class="btn btn-soft-success editUsuario" data-id="{{ $usuario->id }}"><i class="mdi mdi-pencil font-size-8 me-1"></i> Editar </button></li>
                                
                                @if ($usuario->estatus_id == 1)
                                    <button class="btn btn-soft-danger inActivarUsuario" data-id="{{ $usuario->id }}" data-estatus="1"><i class="mdi mdi-account-convert font-size-16 text-danger me-1"></i>Suspender</button>   
                                @else
                                    <button class="btn btn-soft-warning inActivarUsuario" data-id="{{ $usuario->id }}" data-estatus="2"><i class="mdi mdi-account-convert font-size-16 text-warning me-1"></i>Activar</button>
                                @endif
                                <button class="btn btn-soft-info resetPin" data-id="{{ $usuario->id }}"><i class="mdi mdi-cached font-size-16 text-info me-1"></i>Resetear PIN</button>
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
    <script src="{{ URL::asset('build/js/pages/project-create.init.js') }}"></script>
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

            //Crear usuarios
            $('#saveUsuario').click(function () {
                var id = $(this).attr('data-id');
                var rol_id = $('#rol_id').val();
                if($('#nombre').val() == '' || $('#primer_apellido').val() == '' || $('#email').val() == '' || $('#rol_id').val() == '' || $('#pin').val() == ''){
                    Swal.fire({
                        title: 'Hay campos vacíos',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if(rol_id != 1) {
                    var entidadAsignada = []
                    var assignedTo = document.querySelectorAll('#select-element .assignto-list li a.active');
                    if (assignedTo.length > 0) {
                        Array.from(assignedTo).forEach(function (ele) {
                            var idPath = ele.querySelector(".avatar-xs img").getAttribute('id');
                            entidadAsignada.push(idPath);
                        });
                    } else {
                        Swal.fire({
                            title: '¡Debe seleccionar al menos una entidad!',
                            icon: "warning",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        return false;
                    }
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
                        entidades: entidadAsignada,
                        pin: $('#pin').val(),
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
                    $('#up_pin').val(data.data.pin);
                    $('#up_primer_apellido').val(data.data.primer_apellido);
                    $('#up_segundo_apellido').val(data.data.segundo_apellido);
                    $('#up_email').val(data.data.email);
                    $('#up_rol_id option[value="'+data.data.rol_id+'"]').attr("selected", "selected");
                    var listEntidadesActual = document.getElementById("entidadUsuarioEdit");
                    var entidades = data.user_entidades;
                    let html = '';
                    for (const element of entidades) { // You can use `let` instead of `const` if you like
                        html = html + '<button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light" style="margin: 1px;"> '+ element +' </button>'
                    }
                    $('#entidadUsuarioEdit').append(html);
                    $('#update_usuario').modal('show');
                })
            });

            //Actualizar usuario
            $('#updateUsuario').click(function () {
                var id = $('#up_id').val();
                var rol_id = $('#rol_id').val();
                if($('#up_nombre').val() == '' || $('#up_primer_apellido').val() == '' || $('#up_email').val() == '' || $('#up_rol_id').val() == '' || $('#up_pin').val() == ''){
                    Swal.fire({
                        title: 'Hay campos vacíos',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if(rol_id != 1) {
                    var entidadAsignadaUp = []
                    var editListEntidad = document.querySelectorAll('#select-entidad .entidad-list li a.active');
                    if (editListEntidad.length > 0) {
                        Array.from(editListEntidad).forEach(function (ele) {
                            var idPath = ele.querySelector(".avatar-xs img").getAttribute('id');
                            entidadAsignadaUp.push(idPath);
                        });
                    } else {
                        Swal.fire({
                            title: '¡Debe seleccionar al menos una entidad!',
                            icon: "warning",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        return false;
                    }
                }
                $.ajax({
                    type: 'PUT',
                    url: 'editar/usuario/'+id,
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#up_nombre').val(),
                        primer_apellido: $('#up_primer_apellido').val(),
                        segundo_apellido: $('#up_segundo_apellido').val(),
                        email: $('#up_email').val(),
                        rol_id: $('#up_rol_id').val(),
                        pin: $('#up_pin').val(),
                        entidades: entidadAsignadaUp,
                    },
                    success: function (data) {
                        if (data.code == 200) {
                            $('#update_usuario').modal('hide');
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
            
            $('#cerrar_usuario').click(function () {
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            });

            $('.resetPin').click(function () {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: '¿Desea resetear el PIN?',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    showLoaderOnConfirm: true,
                    confirmButtonColor: "#556ee6",
                    cancelButtonColor: "#f46a6a",
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: 'reset/pin/'+id,
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
