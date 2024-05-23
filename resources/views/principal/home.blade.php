@extends('layouts.master')

@section('title') @lang('translation.Dashboards') @endsection
@section('css')
    <!-- Plugins css -->
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row col-md-12" style="text-align: center;">
        <input type="hidden" id="fecha" value="{{ Auth::user()->marcar_inicio }}">
    {{--  1=Inspección, 2=Gestoría, 0= ambos  --}}
    @if (Auth::user()->rol_id == 1 || $user->panel == 1)
        <a href="{{ route('modulo.inspeccion') }}" class="col-md-6">
            <div>
                <div class="col-lg-6" id="mod_inspeccion">
                    <div class="card bg-primary text-white-50">
                        <div class="card-body text-center">
                            <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                            <h1 class="mt-0 mb-4 text-white"> Inspección </h1>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endif
    @if (Auth::user()->rol_id == 1 || $user->panel == 2)
        <a href="{{ route('gestoria.index') }}" class="col-md-6">
            <div>
                <div class="col-lg-6" id="mod_gestoria">
                    <div class="card bg-primary text-white-50">
                        <div class="card-body text-center">
                            <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                            <h1 class="mt-0 mb-4 text-white"> Gestoría </h1>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endif
</div>

@include('principal.bienvenida')
@endsection

@section('script')
    <script>

        var fechajv = $('#fecha').val();
        
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var fecha = d.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;

        if (fechajv != fecha){
            setTimeout(function () {
                $('#bienvenida').modal('show');
            }, 2000);
        }

        $("#btnContinuar").click(function() {
            var url = "{{ route('marcar.inicio') }}";
            $.get(url, function( data ) {
                if(data.code == 200){
                    $('#bienvenida').modal('hide');
                } else {
                    window.location.reload();
                }
            });
        });
    </script>
@endsection

