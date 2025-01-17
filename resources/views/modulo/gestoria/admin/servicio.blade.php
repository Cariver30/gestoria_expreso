@extends('layouts.master')

@section('title')
    Sub Servicios
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    {{--  <div class="row col-md-12">
        <div class="row col-md-12">
            <input type="hidden" name="servicio_id" id="servicio_id" value="{{ $id }}">
            <h3 class="col-md-6">{{ $servicio->nombre }}</h3>
        </div>
        <div class="row col-md-12">
            <div class="col-md-6 text-start">
                <a href="{{ url()->previous() }}" type="button" class="btn btn-lg btn-primary col-md-3"> Volver </a>
            </div>
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
                                                <button class="btn btn-soft-success editSubserviciGestoria" data-id="{{ $subservicio->id }}" data-nombre="{{ $subservicio->nombre }}" data-costo="{{ $subservicio->costo }}"><i class="mdi mdi-pencil font-size-8 me-1"></i> Editar </a></li>
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
    </div>  --}}
    <div class="row col-sm-12">
        {{--  <div class="col-sm-12">
            <div class="text-sm-end mb-4">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add_servicio_gestoria"
                    class="btn btn-success btn-rounded waves-effect waves-light mb-2"><i
                        class="mdi mdi-plus me-1"></i> Agregar</button>
            </div>
        </div>  --}}
        <div class="row col-md-12">
            @foreach ($subservicios as $subservicio)
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="favorite-icon">
                                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                            </div>
                            <img src="{{ URL::asset('build/images/companies/adobe.svg') }}" alt="" height="50" class="mb-3">
                            <h5 class="fs-17 mb-2"><a href="job-details" class="text-dark">{{ $subservicio->nombre }} </a></h5>
                            <div class="mt-4">
                                <button class="btn btn-soft-success waves-effect waves-light editSubservicioGestoria" data-id="{{ $subservicio->id }}" data-nombre="{{ $subservicio->nombre }}"><i class="mdi mdi-pencil font-size-16 me-1"></i> Editar </a>
                            </div>
                            <a href="{{ route('servicio.subservicio.gestoria', ['id' => $subservicio->id])}}" class="btn btn-soft-info waves-effect waves-light"><i class="mdi mdi-plus font-size-16 text-info me-1"></i> Sub Servicios </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    @include('modulo.gestoria.admin.editSubservicio')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            //Crear subservicio en gestoría
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

            //Mostrar modal para actualizar sub servicio gestoria
            $(document).on('click','.editSubservicioGestoria',function(){
                $('#sub_servicio_gestoria_id').val($(this).attr('data-id'));
                $('#up_sub_nombre_gestoria').val($(this).attr('data-nombre'));
                $('#edit_subServicio_gestoria').modal('show');
            });

            //Actualizar subservicio gestoría
            $('#btnUpdateSubservicioGestoria').click(function () {
                if($('#up_sub_nombre_gestoria').val() == ''){
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
                    url: '/update/gestoria/subservicio/'+ $('#sub_servicio_gestoria_id').val(),
                    data : { 
                        _token: "{{ csrf_token() }}",
                        nombre: $('#up_sub_nombre_gestoria').val()
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
