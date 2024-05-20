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
                        <div class="mt-4">
                            <button class="btn btn-soft-success waves-effect waves-light" data-id="{{ $cliente->id }}"><i class="mdi mdi-pencil font-size-16 text-danger me-1"></i> Editar </a></li>
                            <button class="btn btn-soft-info waves-effect waves-light" data-id="{{ $cliente->id }}"><i class="mdi mdi-trash-can-outline font-size-16 text-danger me-1"></i>Ver detalle</button>
                            <button class="btn btn-soft-danger waves-effect waves-light" data-id="{{ $cliente->id }}"><i class="mdi mdi-trash-can-outline font-size-16 text-danger me-1"></i>Agregar servicio</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
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
        });
    </script>
@endsection