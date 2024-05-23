@extends('layouts.master')

@section('title')
    Gestoría
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row col-md-12">
    @foreach ($gestorias as $gestoria)
        <div class="col-lg-4 servicioGestoria" data-id="{{ $gestoria->id }}">
            <div class="card bg-success text-white-50">
                <div class="card-body text-center">
                    <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                    <h1 class="mt-0 mb-4 text-white"> {{ $gestoria->nombre }} </h1>
                </div>
            </div>
        </div>
    @endforeach
</div>
@include('modulo.gestoria.servicio.transaccion')
@include('modulo.gestoria.servicio.licencia')
@include('modulo.gestoria.servicio.vehiculo')

@include('modulo.gestoria.subservicio.subtransaccion')
@include('modulo.gestoria.subservicio.subRotulo')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            //Sección para mostrar modales principales
            $(".servicioGestoria").click(function() {
                var id = $(this).attr('data-id');
                switch (id) {
                    case '1':
                        $('#transacciones').modal('show');
                        break;
                    case '2':
                        $('#licencias').modal('show')
                        break;
                    case '3':
                        $('#vehiculos').modal('show')
                        break;
                }
            });

            //Sección para cada modal
            $(".btnTransaccionGestoria").click(function() {
                var id = $(this).attr('data-id');
                $.get('get/data/gestoria/subservicio/' + id, function (data) {
                    if(data.code == 200){
                        var listPrecios = document.getElementById("divGestoriaTransaccion");
                        var precios = data.data;
                        let html = '';
                        if(id == 1) {
                            for (const element of precios) { // You can use `let` instead of `const` if you like
                                console.log(element);
                                html = html + '<button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light" style="margin: 1px;" data-id="'+element.id+'"> '+ element.nombre +' $' + element.costo +' </button>'
                            }
                            $('#divGestoriaTransaccion').append(html);
                            $('#subTransaccion').modal('show');
                        } else if(id == 2) {
                            for (const element of precios) { // You can use `let` instead of `const` if you like
                                console.log(element);
                                html = html + '<button type="button" class="btn btn-soft-success col-md-6 waves-effect waves-light" style="margin: 1px;" data-id="'+element.id+'"> '+ element.nombre +' $' + element.costo +' </button>'
                            }
                            $('#divGestoriaRotulo').append(html);
                            $('#subRotulo').modal('show');
                        }
                    }
                });
            });
        });
    </script>
@endsection
