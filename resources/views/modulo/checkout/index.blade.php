@extends('layouts.master')

@section('title')
    Usuarios
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="col-sm-12" style="align-content: center">
        <div class="card-body">
            <h3 class="card-title mb-4 text-center">Desglosado de Servicios Recepcionados</h3>

            <div class="table-responsive mb-3" align="center">
                <table class="table align-middle mb-0 table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Servicio</th>
                            <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servicios as $servicio)
                            <tr>
                                <th> {{ $servicio['nombre'] }} </th>
                                {{--  <td> $ @if ($servicio['id'] == 1 || $servicio['id'] == 2 && $servicio['servicio_id'] == 3)-@endif{{$servicio['costo'] }} </td>  --}}
                                <td> ${{$servicio['costo'] }} </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th> Derechos anuales</th>
                            <td> ${{ $venta->derechos_anuales }} </td>
                        </tr>
                        <tr>
                            <th> Costo de Servicio: </th>
                            <td> ${{ $venta->costo_servicio_fijo }} </td>
                        </tr>
                        <tr>
                            <td colspan="1"><h6 class="m-0 text-end">Sub Total:</h6></td>
                            <td> ${{ $total }} </td>
                        </tr>
                        <tr>
                            <td colspan="1"><h6 class="m-0 text-end">Total:</h6></td>
                            <td> ${{ $total }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row col-sm-12 text-center" align="center">
                {{--  <div class="col-sm-3 col-sm-2">
                    <button type="button" class="btn btn-soft-info col-md-8 waves-effect waves-light btn-lg"><i class="bx bx-printer font-size-24 text-primary align-middle me-2"></i> Imprimir </button>
                </div>  --}}
                <div class="col-sm-12 col-sm-2">
                    <button type="button" class="btn btn-soft-success col-md-4 waves-effect waves-light btn-lg pagarVehiculo" data-id="{{ $vehiculo_id }}">PAGAR </button>
                </div>
                {{--  
                <div class="col-sm-3 col-sm-2">
                    <button type="button" class="btn btn-soft-danger col-md-8 waves-effect waves-light btn-lg finalizarProceso" data-id="{{ $vehiculo_id }}"> CANCELAR </button>
                </div>  --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $('.pagarVehiculo').click(function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "La transacción se cerrará, ¿está seguro?",
                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: 'Cancelar!',
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type : 'POST',
                        url :"{{ route('finalizar.venta') }}",
                        data : { 
                            _token: "{{ csrf_token() }}",
                            vehiculo_id: id,
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
                                    window.location = data.url
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
                }
            });
        });
    </script>
@endsection
