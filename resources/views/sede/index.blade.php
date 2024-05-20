@extends('layouts.master')

@section('title')
    Entidades
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-sm-12">
        <div class="col-sm-12">
            <div class="text-sm-end">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add_entidad"
                    class="btn btn-success btn-rounded waves-effect waves-light mb-2"><i
                        class="mdi mdi-plus me-1"></i> Agregar</button>
            </div>
        </div>
        <div class="row col-md-12">
            @foreach ($sedes as $sede)
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="favorite-icon">
                                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                            </div>
                            <img src="{{ URL::asset('build/images/companies/adobe.svg') }}" alt="" height="50" class="mb-3">
                            <h5 class="fs-17 mb-2"><a href="job-details" class="text-dark">{{ $sede->nombre }}</a></h5>
                            <small>{{ $sede->rol }}</small>
                            <div class="mt-4">
                                <button class="btn btn-soft-success editEntidad" data-id="{{ $sede->id }}"><i class="mdi mdi-pencil font-size-8 me-1"></i> Editar </button></li>
                                
                                @if ($sede->estatus_id == 1)
                                    <button class="btn btn-soft-danger inActivarsede" data-id="{{ $sede->id }}" data-estatus="1"><i class="mdi mdi-account-convert font-size-16 text-danger me-1"></i>Deshabilitar</button>   
                                @else
                                    <button class="btn btn-soft-warning inActivarsede" data-id="{{ $sede->id }}" data-estatus="2"><i class="mdi mdi-account-convert font-size-16 text-warning me-1"></i>Activar</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @include('sede.add')
    @include('sede.edit')
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

            //Crear entidad
            $('#saveEntidad').click(function () {
                if($('#nombre').val() == ''){
                    Swal.fire({
                        title: 'El nombre de la entidad es requerido',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#acceso_panel').val() == ''){
                    Swal.fire({
                        title: 'Debe seleccionar por lo menos un acceso',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type : 'POST',
                    url :"{{ route('sedes.store') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#nombre').val(),
                        acceso_panel: $('#acceso_panel').val()
                    },
                    success: function (data) {
                        if (data.code == 201) {
                            $('#add_entidad').modal('hide');
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
            $(document).on('click','.editEntidad',function(){
                var id = $(this).attr('data-id');
                $.get('sedes/' + id, function (data) {
                    $('#up_id').val(data.data.id);
                    $('#up_nombre').val(data.data.nombre);
                    $('#up_acceso_panel option[value="'+data.data.acceso_panel+'"]').attr("selected", "selected");
                    $('#update_entidad').modal('show');
                })
            });

            //Actualizar entidad
            $('#updateSede').click(function () {
                var id = $('#up_id').val();
                if($('#up_nombre').val() == ''){
                    Swal.fire({
                        title: 'El nombre de la entidad es requerido',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#up_acceso_panel').val() == ''){
                    Swal.fire({
                        title: 'Debe seleccionar por lo menos un acceso',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $('#update_entidad').modal('hide');
                $.ajax({
                    type: 'PATCH',
                    url: 'sedes/'+id,
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#up_nombre').val(),
                        acceso_panel: $('#up_acceso_panel').val()
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
            $('.inActivarsede').click(function () {
                var id = $(this).attr('data-id');
                var estatus = $(this).attr('data-estatus');
                var estado = '';
                if(estatus == 1){
                    estado = 'desactivar';
                } else {
                    estado = 'activar';
                }
                Swal.fire({
                    title: '¿Seguro de '+estado+' a esta entidad?',
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
                            url: 'sedes/'+id,
                            data : { 
                                _token: "{{ csrf_token() }}" 
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
