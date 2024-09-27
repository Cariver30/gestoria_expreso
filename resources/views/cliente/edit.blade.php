@extends('layouts.master')

@section('title')
    Editar cliente
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <form method="POST" action="{{ route('clientes.update', $cliente->id) }}" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
            <h4 class="card-title"> Datos del cliente </h4>
            <div class="card-body">
                <div class="row col-md-12">
                    <div class="col-md-4 mb-3">
                        <label for="nombre" class="col-form-label"> Nombre </label>
                        <input type="text" class="form-control form-control-sm" name="nombre" value="{{ $cliente->nombre}}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="email" class="col-form-label"> Email </label>
                        <input type="email" class="form-control form-control-sm" name="email" value="{{ $cliente->email}}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="telefono" class="col-form-label"> Teléfono </label>
                        <input type="text" class="form-control form-control-sm" name="telefono" value="{{ $cliente->telefono}}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="seguro_social" class="col-form-label"> Seguro Social </label>
                        <input type="text" class="form-control form-control-sm" name="seguro_social" value="{{ $cliente->seguro_social}}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="identificacion" class="col-form-label"> Licencia/Identificación </label>
                        <input type="text" class="form-control form-control-sm" name="identificacion" value="{{ $cliente->identificacion}}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="identificacion" class="col-form-label"> Licencia </label><br>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalAmpliarImagen" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"><i class="mdi mdi-eye me-1"></i> Visualizar </button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="identificacion" class="col-form-label"> </label>
                    <button type="submit" class="btn btn-primary" >Guardar</button>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="modalAmpliarImagen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Licencia </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('licencias/'.$cliente->img_licencia) }}" alt="product-img" title="product-img" width="250"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if ($cliente->tipo_cliente == 1)
                <h4 class="card-title mb-3"> Vehículos </h4>
                <div class="">
                    <ul class="verti-timeline list-unstyled">
                        @foreach ($vehiculos as $vehiculo)
                            <li class="event-list active">
                                <div class="event-timeline-dot">
                                    <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="bx bx-car h4 text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark"> {{ $vehiculo->vehiculo }}</a></h5></span>
                                            <span class="text-primary"> - {{ $vehiculo->tablilla}} </span><br>
                                            <span class="text-primary"> - {{ $vehiculo->compania }} </span><br>
                                            <span class="text-primary"> - {{ $vehiculo->marca }} </span><br>
                                            <span class="text-primary"> {{ Carbon\Carbon::parse($vehiculo->created_at)->format('d-m-Y H:i:s') }} </span><br>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <h4 class="card-title mb-3"> Servicios </h4>
                <div class="">
                    <ul class="verti-timeline list-unstyled">
                        @if ($data == 0)
                            <span class="text-danger"> Sin servicios recepcionados </span>
                        @elseif ($data == 1)
                            <span class="text-success"> Transacción en curso </span>
                        @else
                            @foreach ($servicios as $servicio)
                                <li class="event-list active">
                                    <div class="event-timeline-dot">
                                        <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="bx bx-person h4 text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div>
                                                <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark"> {{ $servicio['nombre'] }}</a></h5></span>
                                                <span class="text-primary"> Costo ${{ $servicio['costo']}} </span><br>
                                                {{--  <span class="text-primary"> {{ Carbon\Carbon::parse($servicio['created_at'])->format('d-m-Y H:i:s') }} </span><br>  --}}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-2"> Ordenes </h4>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap dt-responsive nowrap w-100 table-check"
                            id="order-list">
                            <thead class="table-light" align="center">
                                <tr>
                                    <th class="align-middle"> Fecha </th>
                                    <th class="align-middle"> Estatus </th>
                                    <th class="align-middle"> Motivo </th>
                                    <th class="align-middle"> Metodo de Pago </th>
                                    <th class="align-middle"> Fecha de Pago </th>
                                    <th class="align-middle"> Total </th>
                                    <th class="align-middle"> Acción </th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                {{--  @foreach ($ordenes as $orden)
                                    <tr>
                                        <td> {{ Carbon\Carbon::parse($orden->updated_at)->format('d-m-Y H:i') }} </td>
                                        <td> 
                                            @if ($orden['estatus_id'] == 3)
                                                <span class="badge bg-info">{{ $orden->estatus }}</span>
                                            @elseif($orden['estatus_id'] == 4)
                                                <span class="badge bg-success">{{ $orden->estatus }}</span>
                                            @elseif($orden['estatus_id'] == 5)
                                                <span class="badge bg-warning">{{ $orden->estatus }}</span>
                                            @elseif($orden['estatus_id'] == 6)
                                                <span class="badge bg-danger">{{ $orden->estatus }}</span>
                                            @endif
                                        </td>
                                        <td> @if ($orden->motivo == null) Sin Información  @else {{ $orden->motivo }} @endif </td>
                                        <td> @if ($orden->tipo_pago == 1) Efectivo @else Sin Información  @endif </td>
                                        <td> @if ($orden->fecha_pago == null) Sin información @else {{ Carbon\Carbon::parse($orden->fecha_pago)->format('d-m-Y H:i') }} @endif</td>
                                        <td> ${{ $orden->total }} </td>
                                        <td>
                                            @if ($orden->estatus_id == 4 || $orden->estatus_id == 5 || $orden->estatus_id == 6)
                                                <a href="{{ route('ver.recibo', ['id' => $orden->id]) }}" type="button" class="btn btn-secondary waves-effect waves-light" style="margin-left: 10px;"> Ver recibo </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach  --}}
                            </tbody>
                        </table>
                    </div>
                    <!-- end table responsive -->
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection