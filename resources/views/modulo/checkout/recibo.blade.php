@extends('layouts.master')

@section('title')
    Recibo de servicios
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-16">Orden # {{ $venta->id }}</h4>
                        <div class="auth-logo mb-4">
                            <img src="{{ URL::asset('images/logo.jpeg') }}" alt="logo" class="auth-logo-dark" height="20" />
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <address>
                                <strong>Facturado a:</strong><br>
                                {{ $cliente->nombre }}<br>
                                +{{ $cliente->telefono }}<br>
                                {{ $cliente->email}} <br>
                            </address>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <address class="mt-2 mt-sm-0">
                                <strong>Facturado por:</strong><br>
                                El Expreso<br>
                                PO Box 1663<br> 
                                Ciales PR, 00638
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mt-3">
                            <address>
                                <strong>Metodo de Pago:</strong><br>
                                Efectivo<br>
                            </address>
                        </div>
                        <div class="col-sm-6 mt-3 text-sm-end">
                            <address>
                                <strong>Fecha de servicio:</strong><br>
                                {{ Carbon\Carbon::parse($venta->fecha_pago)->format('d-m-Y H:i:s') }} <br><br>
                            </address>
                        </div>
                    </div>
                    <div class="py-2 mt-3">
                        <h3 class="font-size-15 fw-bold text-center"> Resumen de Orden</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap">
                            <thead>
                                <tr>
                                    <th><strong> Servicio </strong></th>
                                    <th class="text-end"><strong> Costo </strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($servicios as $servicio)
                                    <tr>
                                        <th> {{ $servicio['nombre'] }} </th>
                                        <td class="text-end"> @if ($servicio['costo'] == null)  $0.00 @elseif($servicio['servicio_id'] == 3) {{$servicio['costo'] }} @else ${{$servicio['costo'] }} @endif </td>
                                    </tr>
                                @endforeach
                                <tr class="text-end">
                                    <td colspan="1"><h6 class="m-0 text-end">Sub Total:</h6></td>
                                    <td> ${{ $venta->total }} </td>
                                </tr>
                                <tr class="text-end">
                                    <td colspan="1"><h6 class="m-0 text-end">Total:</h6></td>
                                    <td> ${{ $venta->total }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row col-md-12 text-center">
                        <div style="  margin: 0 auto;">
                            {{--  <a href="#" class="btn btn-primary w-md waves-effect waves-light">Send</a>  --}}
                            <a href="{{ URL::previous() }}" class="btn btn-danger waves-effect waves-light me-1 col-md-2"><i class="mdi mdi-arrow-left"></i> Volver </a>
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1 col-md-2"><i class="fa fa-print"></i> Imprimir </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
