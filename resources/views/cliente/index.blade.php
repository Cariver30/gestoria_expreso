@extends('layouts.master')

@section('title')
    Clientes
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-md-12">
        @foreach ($clientes as $cliente)
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="favorite-icon">
                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                        </div>
                        <img src="{{ URL::asset('build/images/companies/adobe.svg') }}" alt="" height="50" class="mb-3">
                        <h5 class="fs-17 mb-2"><a href="" class="text-dark">{{ $cliente->nombre }} </a></h5>
                        <span class="badge bg-success">{{ $cliente->estatus }}</span>
                        <div class="mt-4">
                            {{--  <a class="btn btn-soft-success waves-effect waves-light" style="margin-right: 10px;" data-id="{{ $cliente->id }}"><i class="mdi mdi-pencil font-size-16 me-1"></i> Editar </a></li>  --}}
                            <a class="btn btn-soft-info waves-effect waves-light" style="margin-right: 1px;" href="{{ route('clientes.edit', $cliente->id)}}"><i class="mdi mdi-eye-outline font-size-16 me-1"></i>Ver detalle</a>
                            <button class="btn btn-soft-secondary waves-effect waves-light" style="margin-right: 1px;" data-id="{{ $cliente->id }}"><i class="mdi mdi-plus-outline font-size-16 me-1"></i>Agregar servicio</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{--  @include('cliente.edit')  --}}
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

            @if(Session::has('success'))
                <script>
                    Swal.fire({
                        title: 'Cliente actualizado',
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000
                    });
                </script>
            @endif

            //Modal para editar cliente
            {{--  $(document).on('click','.editCliente',function(){
                var id = $(this).attr('data-id');
                $.get('clientes/' + id, function (data) {
                    $('#up_id').val(data.data.id);
                    $('#up_nombre').val(data.data.nombre);
                    $('#up_email').val(data.data.email);
                    $('#up_telefono').val(data.data.telefono);
                    $('#up_seguro_social').val(data.data.seguro_social);
                    $('#up_identificacion').val(data.data.identificacion);
                    $('#update_cliente').modal('show');
                })
            });  --}}
        });
    </script>
@endsection