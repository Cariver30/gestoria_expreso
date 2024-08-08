@extends('layouts.master')

@section('title')
    Clientes
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card job-filter">
            <div class="card-body p-3">
                <form action="javascript:void(0);">
                    <div class="row g-3">
                        <div class="col-xxl-4 col-lg-3">
                            <div class="position-relative">
                                <select class="form-select" style="cursor: pointer;" id="search_seguro_social" name="search_seguro_social">
                                    <option value="" disabled selected hidden>Seguro Social </option>
                                    @foreach ($seguros_sociales as $seguros_social)
                                        <option value="{{$seguros_social->id}}">{{ $seguros_social->seguro_social }}</option>
                                    @endforeach
                                </select>
                                {{--  <input type="text" class="form-control" autocomplete="off" name="search_seguro_social" id="search_seguro_social" placeholder="Seguro social">  --}}
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-2 col-lg-3">
                            <div class="position-relative">
                                <select class="form-select" style="cursor: pointer;" id="search_tablilla" name="search_tablilla">
                                    <option value="" disabled selected hidden> Tablilla </option>
                                    @foreach ($tablillas as $tablilla)
                                        <option value="{{$tablilla->id}}">{{ $tablilla->tablilla }}</option>
                                    @endforeach
                                </select>
                                {{--  <input type="text" class="form-control" autocomplete="off" name="search_tablilla" id="search_tablilla" placeholder="Tablilla">  --}}
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-2 col-lg-3">
                            <div class="position-relative">
                                <select class="form-select" style="cursor: pointer;" id="mes_vencimiento" name="mes_vencimiento">
                                    <option value="" disabled selected hidden >Mes de Vencimiento</option>
                                    @foreach ($meses as $mes)
                                        <option value="{{$mes->id}}" @if (isset($vehiculo) && $mes->id == $vehiculo->mes_vencimiento_id) selected @endif>{{ $mes->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end col-->

                        <div class="col-xxl-2 col-lg-3">
                            <div class="position-relative h-100 hstack gap-3">
                                <button type="submit" class="btn btn-primary h-100 w-100" onclick="filterData();"><i
                                        class="bx bx-search-alt align-middle"></i> Ver Todos </button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
    {{--  <div class="card">
        <div class="card-body text-center">
            <div class="row col-md-12">
                <div class="col">
                    <input type="text" class="form-control form-control-md" name="search_seguro_social" id="search_seguro_social" placeholder="Seguro social">
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-md" name="search_tablilla" id="search_tablilla" placeholder="Tablilla">
                </div>
                <div class="col-md-3 mb-3">
                    <select class="form-select" style="cursor: pointer;" id="mes_vencimiento" name="mes_vencimiento">
                        <option value="" disabled selected hidden >Mes de Vencimiento</option>
                        @foreach ($meses as $mes)
                            <option value="{{$mes->id}}" @if (isset($vehiculo) && $mes->id == $vehiculo->mes_vencimiento_id) selected @endif>{{ $mes->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-warning waves-effect waves-light">
                        <i class="bx bx-search font-size-16 align-middle me-2"></i> Buscar
                    </button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-warning waves-effect waves-light">
                        <i class="bx bx-user font-size-16 align-middle me-2"></i> Ver todos
                    </button>
                </div>
            </div>
        </div>
    </div>  --}}
    <div class="row col-md-12">
        @if (count($clientes) == 0)
            <div class="card">
                <div class="card-body text-center">
                    SIN CLIENTES DISPONIBLES
                    </div>
                </div>
            </div>
        @else
            @foreach ($clientes as $cliente)
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="favorite-icon">
                                <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                            </div>
                            <img src="{{ URL::asset('build/images/companies/adobe.svg') }}" alt="" height="50" class="mb-3">
                            <h5 class="fs-17 mb-2"><a href="" class="text-dark">{{ $cliente->nombre }} </a></h5>
                            <small>{{ $cliente->seguro_social }}</small><br>
                            @if ($cliente->estatus_id == 5)
                                <span class="badge bg-warning">{{ $cliente->estatus }}</span>
                            @endif
                            <div class="mt-4">
                                {{--  <a class="btn btn-soft-success waves-effect waves-light" style="margin-right: 10px;" data-id="{{ $cliente->id }}"><i class="mdi mdi-pencil font-size-16 me-1"></i> Editar </a></li>  --}}
                                <a class="btn btn-soft-info waves-effect waves-light" style="margin-right: 1px;" href="{{ route('clientes.edit', $cliente->id)}}"><i class="mdi mdi-eye-outline font-size-16 me-1"></i>Ver detalle</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
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