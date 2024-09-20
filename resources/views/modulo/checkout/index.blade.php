@extends('layouts.master')

@section('title')
    Servicios Recepcionados
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="col-sm-12" style="align-content: center">
        <div class="card-body">
            <h3 class="card-title mb-4 text-center">Desglosado de Servicios</h3>

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
                                <td> @if ($servicio['costo'] == null)  $0.00 @elseif($servicio['servicio_id'] == 3) {{$servicio['costo'] }} @else ${{$servicio['costo'] }} @endif </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="1"><h6 class="m-0 text-end">Sub Total:</h6></td>
                            <td> ${{ $venta->total }} </td>
                        </tr>
                        <tr>
                            <td colspan="1"><h6 class="m-0 text-end">Total:</h6></td>
                            <td> ${{ $venta->total }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row mt-4">
                <div class="col-sm-6">
                    <a href="{{ url()->previous() }}" class="btn text-muted d-none d-sm-inline-block btn-link">
                        <i class="mdi mdi-arrow-left me-3"></i> Volver </a>
                </div>
                <div class="col-sm-6">
                    <div class="text-end">
                        <button class="btn btn-success mostrar_tipo_pago" data-id="{{ $venta->id }}">
                            <i class="mdi mdi-truck-fast me-1"></i> Proceder al pago  </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modulo.checkout.tipo_de_pago')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>

        $(".mostrar_tipo_pago").click(function() {

            $('#venta_id').val($(this).attr('data-id'));
            $('#modal_tipo_de_pago').modal('show')
        });

        $('#payService').click(function () {

            var id = $('#venta_id').val();
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
                            venta_id: id,
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
@endsection  --}}


{{--  @extends('layouts.master')

@section('title')
    Desgloes de servicios
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
                                <td> @if ($servicio['costo'] == null)  $0.00 @elseif($servicio['servicio_id'] == 3) {{$servicio['costo'] }} @else ${{$servicio['costo'] }} @endif </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th> Derechos anuales</th>
                            <td> @if($venta->derechos_anuales ==null) $0.00 @else ${{ $venta->derechos_anuales }} @endif</td>
                        </tr>
                        <tr>
                            <th> Costo de Servicio: </th>
                            <td> @if($venta->costo_servicio_fijo ==null) $0.00 @else ${{ $venta->costo_servicio_fijo }} @endif</td>
                        </tr>
                        <tr>
                            <td colspan="1"><h6 class="m-0 text-end">Sub Total:</h6></td>
                            <td> ${{ $total }}.00 </td>
                        </tr>
                        <tr>
                            <td colspan="1"><h6 class="m-0 text-end">Total:</h6></td>
                            <td> ${{ $total }}.00 </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row mt-4">
                <div class="col-sm-6">
                    <a href="{{ route('modulo.inspeccion') }}" class="btn text-muted d-none d-sm-inline-block btn-link">
                        <i class="mdi mdi-arrow-left me-3"></i> Volver </a>
                </div> <!-- end col -->
                <div class="col-sm-6">
                    <div class="text-end">
                        <button class="btn btn-success mostrar_tipo_pago" data-id="{{ $venta->id }}">
                            <i class="mdi mdi-truck-fast me-1"></i> Proceder al pago  </button>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
    @include('modulo.checkout.tipo_de_pago')
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>

        $(".mostrar_tipo_pago").click(function() {

            $('#venta_id').val($(this).attr('data-id'));
            $('#modal_tipo_de_pago').modal('show')
        });

        $('#payService').click(function () {

            var id = $('#venta_id').val();
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
                            venta_id: id,
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
@endsection  --}}
