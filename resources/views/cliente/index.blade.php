@extends('layouts.master')

@section('title')
    Clientes
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card job-filter">
                <div class="card-body p-3">
                    <form action="javascript:void(0);">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-lg-3">
                                <div class="position-relative">
                                    <select class="form-select select2 search_seguro_social" style="cursor: pointer;" id="search_seguro_social" @if (count($seguros_sociales) == 0) disabled @endif>
                                        <option value="" disabled selected hidden>Seguro Social </option>
                                        @foreach ($seguros_sociales as $seguros_social)
                                            <option value="{{$seguros_social->seguro_social }}">{{ $seguros_social->seguro_social }} - {{ $seguros_social->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-lg-3">
                                <div class="position-relative">
                                    <select class="form-select select2 search_tablilla" style="cursor: pointer;" @if (count($tablillas) == 0) disabled @endif>
                                        <option value="" disabled selected hidden> Tablilla </option>
                                        @foreach ($tablillas as $tablilla)
                                            <option value="{{$tablilla->tablilla}}">{{ $tablilla->tablilla }} - {{ $tablilla->vehiculo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-lg-3">
                                <div class="position-relative">
                                    <select class="form-select select2 search_mes_vencimiento" style="cursor: pointer;" @if (count($tablillas) == 0) disabled @endif>
                                        <option value="" disabled selected hidden >Mes de Vencimiento</option>
                                        @foreach ($meses as $mes)
                                            <option value="{{$mes->id}}" @if (isset($vehiculo) && $mes->id == $vehiculo->mes_vencimiento_id) selected @endif>{{ $mes->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-3 col-lg-3">
                                <div class="position-relative h-100 hstack gap-3">
                                    <button type="submit" class="btn btn-primary h-100 w-100" onclick="verTodos();" @if (count($seguros_sociales) == 0) disabled @endif><i class="bx bx-search-alt align-middle"></i> Ver Todos </button>
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
    {{--  <div class="row col-md-12" id="clientes-list">
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
                                <a class="btn btn-soft-info waves-effect waves-light" style="margin-right: 1px;" href="{{ route('clientes.edit', $cliente->id)}}"><i class="mdi mdi-eye-outline font-size-16 me-1"></i>Ver detalle</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>  --}}
    <div class="row" id="client-list">
        
    </div>
@endsection

@section('script')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
    <!-- cliente-list js -->
    <script src="{{ URL::asset('build/js/pages/client-list.init.js') }}"></script>
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
        });
    </script>
@endsection