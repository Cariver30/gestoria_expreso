@extends('layouts.master')

@section('title')
    Usuarios
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="col-sm-12">
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
                        <tr>
                            <th scope="row">Servicio 1</th>
                            <td>$ 450</td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <h6 class="m-0 text-end">Sub Total:</h6>
                            </td>
                            <td>
                                $ 675
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <h6 class="m-0 text-end">Total:</h6>
                            </td>
                            <td>
                                $ 675
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row col-sm-12 text-center" style="margin-left: 7%;">
                <div class="col-sm-3 col-sm-2">
                    <button type="button" class="btn btn-soft-info col-md-8 waves-effect waves-light btn-lg"><i class="bx bx-printer font-size-24 text-primary align-middle me-2"></i> Imprimir </button>
                </div>
                {{--  <div class="col-sm-4 col-sm-2">
                    <button type="button" class="btn btn-soft-warning col-md-8 waves-effect waves-light btn-lg pendientePorPagar" data-id="{{ $vehiculo_id }}"> PENDIENTE POR PAGAR </button>
                </div>
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
@endsection
