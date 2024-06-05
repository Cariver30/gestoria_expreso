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
            <input type="hidden" id="s_gestoria_id" value="{{ $id }}">
            <h3 class="col-md-12 text-center">{{ $servicio->nombre }}</h3>
        </div>
        <div class="row col-md-12">
            <div class="col-md-6 text-start">
                <a href="{{ url()->previous() }}" type="button" class="btn btn-lg btn-primary col-md-3"> Volver </a>
            </div>
            <div class="col-md-6 text-end">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add_ss_gestoria_modal" class="btn btn-lg btn-primary col-md-3"> Agregar </button>
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
                                            
                                            <td>
                                                <button class="btn btn-soft-success editSSGestoria" data-id="{{ $subservicio->id }}" data-nombre="{{ $subservicio->nombre }}" data-costo="{{ $subservicio->costo }}"><i class="mdi mdi-pencil font-size-8 me-1"></i> Editar </a></li>
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
    @include('modulo.gestoria.admin.subservicios.add_ss_gestoria')
    @include('modulo.gestoria.admin.subservicios.edit_ss_gestoria')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            //Crear subservicio en gestoría
            $('#btnAddSSGestoria').click(function () {
                if($('#ss_gestoria_nombre').val() == ''){
                    Swal.fire({
                        title: '¡El nombre es requerido!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#ss_gestoria_costo').val() == ''){
                    Swal.fire({
                        title: '¡El costo es requerido!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ss.store.gestoria') }}",
                    data : { 
                        _token: "{{ csrf_token() }}",
                        s_gestoria_id: $('#s_gestoria_id').val(),
                        nombre: $('#ss_gestoria_nombre').val(),
                        costo: $('#ss_gestoria_costo').val()
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

            //Mostrar modal para actualizar sub servicio gestoria
            $(document).on('click','.editSSGestoria',function(){
                $('#up_ss_gestoria_id').val($(this).attr('data-id'));
                $('#up_ss_nombre_gestoria').val($(this).attr('data-nombre'));
                $('#up_ss_costo_gestoria').val($(this).attr('data-costo'));
                $('#edit_ss_gestoria').modal('show');
            });

            //Actualizar subservicio gestoría
            $('#btnEditSSGestoria').click(function () {
                if($('#up_ss_nombre_gestoria').val() == ''){
                    Swal.fire({
                        title: '¡El nombre es requerido!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                if($('#up_ss_costo_gestoria').val() == ''){
                    Swal.fire({
                        title: '¡El costo es requerido!',
                        icon: "warning",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type: 'PUT',
                    url: '/sservicio/gestoria/'+ $('#up_ss_gestoria_id').val(),
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#up_ss_nombre_gestoria').val(),
                        costo: $('#up_ss_costo_gestoria').val()
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

            
        });
    </script>
@endsection
