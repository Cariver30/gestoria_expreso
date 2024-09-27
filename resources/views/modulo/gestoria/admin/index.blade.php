@extends('layouts.master')

@section('title')
    Servicios
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-sm-12">
        {{--  <div class="col-sm-12">
            <div class="text-sm-end mb-4">
                <button type="button" data-bs-toggle="modal" data-bs-target="#add_servicio_gestoria"
                    class="btn btn-success btn-rounded waves-effect waves-light mb-2"><i
                        class="mdi mdi-plus me-1"></i> Agregar</button>
            </div>
        </div>  --}}
        <div class="row col-md-12">
            @foreach ($gestorias as $gestoria)
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="favorite-icon">
                                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                            </div>
                            <img src="{{ URL::asset('build/images/companies/adobe.svg') }}" alt="" height="50" class="mb-3">
                            <h5 class="fs-17 mb-2"><a href="job-details" class="text-dark">{{ $gestoria->nombre }} </a></h5>
                            <div class="mt-4">
                                <button class="btn btn-soft-success waves-effect waves-light editServicioGestoria" data-id="{{ $gestoria->id }}" data-nombre="{{ $gestoria->nombre }}"><i class="mdi mdi-pencil font-size-8 me-1"></i> Editar </a>
                                {{--  <button class="btn btn-soft-danger waves-effect waves-light inActivarServicio" data-id="{{ $gestoria->id }}"><i class="mdi mdi-trash-can-outline font-size-8 text-danger me-1"></i></button>  --}}
                            </div>
                            <a href="{{ route('gestoria.edit', ['gestorium' => $gestoria->id])}}" class="btn btn-soft-info waves-effect waves-light"><i class="mdi mdi-plus font-size-8 text-info me-1"></i> Servicios </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @include('modulo.gestoria.admin.edit')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            //Mostrar modal para actualizar servicio
            $(document).on('click','.editServicioGestoria',function(){
                var id = $(this).attr('data-id');
                var nombre = $(this).attr('data-nombre');
                $('#up_servicio_gestoria_id').val(id);
                $('#up_servicio_gestoria_nombre').val(nombre);
                $('#up_servicio_gestoria_modal').modal('show');
            });

            //Actualizar servicio
            $('#upServicioGestoria').click(function () {
                var id = $('#up_servicio_gestoria_id').val();
                if($('#up_servicio_gestoria_nombre').val() == ''){
                    Swal.fire({
                        title: 'El nombre del servicio es requerido',
                        icon: "warning",
                        position: 'top-center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false;
                }
                $.ajax({
                    type: 'PATCH',
                    url: '{{ route('gestoria.update', ['gestorium' => 'id'])}}',
                    data : { 
                        _token: "{{ csrf_token() }}",
                        id: $('#up_servicio_gestoria_id').val(),
                        nombre: $('#up_servicio_gestoria_nombre').val()
                    },
                    success: function (data) {
                        if (data.code == 200) {
                            $('#up_servicio_gestoria_modal').modal('hide');
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
