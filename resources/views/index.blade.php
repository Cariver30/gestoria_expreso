@extends('layouts.master')

@section('title') @lang('translation.Dashboards') @endsection
@section('css')
    <!-- Plugins css -->
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{--  @section('css')
    <style>
        .credentialing {
            --bg-color: #B8F9D3;
            --bg-color-light: #e2fced;
            --text-color-hover: #4C5656;
            --box-shadow-color: rgba(184, 249, 211, 0.48);
          }
          
          .card {
            width: 220px;
            height: 321px;
            background: #fff;
            border-top-right-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            box-shadow: 0 14px 26px rgba(0,0,0,0.04);
            transition: all 0.3s ease-out;
            text-decoration: none;
          }
          
          .card:hover {
            transform: translateY(-5px) scale(1.005) translateZ(0);
            box-shadow: 0 24px 36px rgba(0,0,0,0.11),
              0 24px 46px var(--box-shadow-color);
          }
          
          .card:hover .overlay {
            transform: scale(4) translateZ(0);
          }
          
          .card:hover .circle {
            border-color: var(--bg-color-light);
            background: var(--bg-color);
          }
          
          .card:hover .circle:after {
            background: var(--bg-color-light);
          }
          
          .card:hover p {
            color: var(--text-color-hover);
          }
          
          .card:active {
            transform: scale(1) translateZ(0);
            box-shadow: 0 15px 24px rgba(0,0,0,0.11),
              0 15px 24px var(--box-shadow-color);
          }
          
          .card p {
            font-size: 17px;
            color: #4C5656;
            margin-top: 30px;
            z-index: 1000;
            transition: color 0.3s ease-out;
          }
          
          .circle {
            width: 131px;
            height: 131px;
            top: 15px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid var(--bg-color);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease-out;
          }
          
          .circle:after {
            content: "";
            width: 118px;
            height: 118px;
            display: block;
            position: absolute;
            background: var(--bg-color);
            border-radius: 50%;
            transition: opacity 0.3s ease-out;
          }
          
          .circle svg {
            z-index: 10000;
            transform: translateZ(0);
          }
          
          .overlay {
            width: 118px;
            position: absolute;
            height: 118px;
            border-radius: 50%;
            background: var(--bg-color);
            top: 15px;
            left: 50px;
            z-index: 0;
            transition: transform 0.3s ease-out;
          }
    </style>
    
@endsection  --}}
@section('content')
    {{--  <div class="body row">
        <div class="col-md-4">
            <a class="card credentialing" href="#">
                <div class="overlay"></div>
                <div class="circle">
                    <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="27 21 64 72" height="72px" width="64px">
            
                        <desc>Created with Sketch.</desc>
                        <defs>
                            <polygon points="60.9784821 18.4748913 60.9784821 0.0299638385 0.538377293 0.0299638385 0.538377293 18.4748913" id="path-1"></polygon>
                        </defs>
                        <g transform="translate(27.000000, 21.000000)" fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="Group-12">
                            <g id="Group-5">
                                <g transform="translate(2.262327, 21.615176)" id="Group-3">
                                    <mask fill="white" id="mask-2">
                                        
                                    </mask>
                                    <g id="Clip-2"></g>
                                    <path mask="url(#mask-2)" fill="#59A785" id="Fill-1" d="M7.17774177,18.4748913 L54.3387782,18.4748913 C57.9910226,18.4748913 60.9789911,15.7266455 60.9789911,12.3681986 L60.9789911,6.13665655 C60.9789911,2.77820965 57.9910226,0.0299638385 54.3387782,0.0299638385 L7.17774177,0.0299638385 C3.52634582,0.0299638385 0.538377293,2.77820965 0.538377293,6.13665655 L0.538377293,12.3681986 C0.538377293,15.7266455 3.52634582,18.4748913 7.17774177,18.4748913"></path>
                                </g>
                                <polygon points="62.0618351 55.9613216 7.2111488 60.3692832 1.50838775 5.79374073 56.3582257 1.38577917" transform="translate(31.785111, 30.877531) rotate(-2.000000) translate(-31.785111, -30.877531)" fill="#FFFFFF" id="Fill-4"></polygon>
                                <ellipse ry="9.17325562" rx="9.95169733" cy="21.7657707" cx="30.0584472" opacity="0.216243004" fill="#25D48A" id="Oval-3"></ellipse>
                                <g fill="#54C796" transform="translate(16.959615, 6.479082)" id="Group-4">
                                    <polygon points="10.7955395 21.7823628 0.11873799 11.3001058 4.25482787 7.73131106 11.0226557 14.3753897 27.414824 1.77635684e-15 31.3261391 3.77891399" id="Fill-6"></polygon>
                                </g>
                                <path fill="#59B08B" id="Fill-8" d="M4.82347935,67.4368303 L61.2182039,67.4368303 C62.3304205,67.4368303 63.2407243,66.5995595 63.2407243,65.5765753 L63.2407243,31.3865871 C63.2407243,30.3636029 62.3304205,29.5263321 61.2182039,29.5263321 L4.82347935,29.5263321 C3.71126278,29.5263321 2.80095891,30.3636029 2.80095891,31.3865871 L2.80095891,65.5765753 C2.80095891,66.5995595 3.71126278,67.4368303 4.82347935,67.4368303"></path>
                                <path fill="#4FC391" id="Fill-10" d="M33.3338063,67.4368303 L61.2181191,67.4368303 C62.3303356,67.4368303 63.2406395,66.5995595 63.2406395,65.5765753 L63.2406395,31.3865871 C63.2406395,30.3636029 62.3303356,29.5263321 61.2181191,29.5263321 L33.3338063,29.5263321 C32.2215897,29.5263321 31.3112859,30.3636029 31.3112859,31.3865871 L31.3112859,65.5765753 C31.3112859,66.5995595 32.2215897,67.4368303 33.3338063,67.4368303"></path>
                                <path fill="#FEFEFE" id="Fill-15" d="M29.4284029,33.2640869 C29.4284029,34.2202068 30.2712569,34.9954393 31.3107768,34.9954393 C32.3502968,34.9954393 33.1931508,34.2202068 33.1931508,33.2640869 C33.1931508,32.3079669 32.3502968,31.5327345 31.3107768,31.5327345 C30.2712569,31.5327345 29.4284029,32.3079669 29.4284029,33.2640869"></path>
                                <path fill="#5BD6A2" id="Fill-12" d="M8.45417501,71.5549073 L57.5876779,71.5549073 C60.6969637,71.5549073 63.2412334,69.2147627 63.2412334,66.3549328 L63.2412334,66.3549328 C63.2412334,63.4951029 60.6969637,61.1549584 57.5876779,61.1549584 L8.45417501,61.1549584 C5.34488919,61.1549584 2.80061956,63.4951029 2.80061956,66.3549328 L2.80061956,66.3549328 C2.80061956,69.2147627 5.34488919,71.5549073 8.45417501,71.5549073"></path>
                            </g>
                        </g>
                    </svg>
                </div>
                <p>Credentialing</p>
            </a>
        </div>
        <div class="col-md-4">
            <a class="card credentialing" href="#">
                <div class="overlay"></div>
                <div class="circle">
                    <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="27 21 64 72" height="72px" width="64px">
            
                        <desc>Created with Sketch.</desc>
                        <defs>
                            <polygon points="60.9784821 18.4748913 60.9784821 0.0299638385 0.538377293 0.0299638385 0.538377293 18.4748913" id="path-1"></polygon>
                        </defs>
                        <g transform="translate(27.000000, 21.000000)" fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="Group-12">
                            <g id="Group-5">
                                <g transform="translate(2.262327, 21.615176)" id="Group-3">
                                    <mask fill="white" id="mask-2">
                                        
                                    </mask>
                                    <g id="Clip-2"></g>
                                    <path mask="url(#mask-2)" fill="#59A785" id="Fill-1" d="M7.17774177,18.4748913 L54.3387782,18.4748913 C57.9910226,18.4748913 60.9789911,15.7266455 60.9789911,12.3681986 L60.9789911,6.13665655 C60.9789911,2.77820965 57.9910226,0.0299638385 54.3387782,0.0299638385 L7.17774177,0.0299638385 C3.52634582,0.0299638385 0.538377293,2.77820965 0.538377293,6.13665655 L0.538377293,12.3681986 C0.538377293,15.7266455 3.52634582,18.4748913 7.17774177,18.4748913"></path>
                                </g>
                                <polygon points="62.0618351 55.9613216 7.2111488 60.3692832 1.50838775 5.79374073 56.3582257 1.38577917" transform="translate(31.785111, 30.877531) rotate(-2.000000) translate(-31.785111, -30.877531)" fill="#FFFFFF" id="Fill-4"></polygon>
                                <ellipse ry="9.17325562" rx="9.95169733" cy="21.7657707" cx="30.0584472" opacity="0.216243004" fill="#25D48A" id="Oval-3"></ellipse>
                                <g fill="#54C796" transform="translate(16.959615, 6.479082)" id="Group-4">
                                    <polygon points="10.7955395 21.7823628 0.11873799 11.3001058 4.25482787 7.73131106 11.0226557 14.3753897 27.414824 1.77635684e-15 31.3261391 3.77891399" id="Fill-6"></polygon>
                                </g>
                                <path fill="#59B08B" id="Fill-8" d="M4.82347935,67.4368303 L61.2182039,67.4368303 C62.3304205,67.4368303 63.2407243,66.5995595 63.2407243,65.5765753 L63.2407243,31.3865871 C63.2407243,30.3636029 62.3304205,29.5263321 61.2182039,29.5263321 L4.82347935,29.5263321 C3.71126278,29.5263321 2.80095891,30.3636029 2.80095891,31.3865871 L2.80095891,65.5765753 C2.80095891,66.5995595 3.71126278,67.4368303 4.82347935,67.4368303"></path>
                                <path fill="#4FC391" id="Fill-10" d="M33.3338063,67.4368303 L61.2181191,67.4368303 C62.3303356,67.4368303 63.2406395,66.5995595 63.2406395,65.5765753 L63.2406395,31.3865871 C63.2406395,30.3636029 62.3303356,29.5263321 61.2181191,29.5263321 L33.3338063,29.5263321 C32.2215897,29.5263321 31.3112859,30.3636029 31.3112859,31.3865871 L31.3112859,65.5765753 C31.3112859,66.5995595 32.2215897,67.4368303 33.3338063,67.4368303"></path>
                                <path fill="#FEFEFE" id="Fill-15" d="M29.4284029,33.2640869 C29.4284029,34.2202068 30.2712569,34.9954393 31.3107768,34.9954393 C32.3502968,34.9954393 33.1931508,34.2202068 33.1931508,33.2640869 C33.1931508,32.3079669 32.3502968,31.5327345 31.3107768,31.5327345 C30.2712569,31.5327345 29.4284029,32.3079669 29.4284029,33.2640869"></path>
                                <path fill="#5BD6A2" id="Fill-12" d="M8.45417501,71.5549073 L57.5876779,71.5549073 C60.6969637,71.5549073 63.2412334,69.2147627 63.2412334,66.3549328 L63.2412334,66.3549328 C63.2412334,63.4951029 60.6969637,61.1549584 57.5876779,61.1549584 L8.45417501,61.1549584 C5.34488919,61.1549584 2.80061956,63.4951029 2.80061956,66.3549328 L2.80061956,66.3549328 C2.80061956,69.2147627 5.34488919,71.5549073 8.45417501,71.5549073"></path>
                            </g>
                        </g>
                    </svg>
                </div>
                <p>Credentialing</p>
            </a>
        </div>
        <div class="col-md-4">
            <a class="card credentialing" href="#">
            <div class="overlay"></div>
            <div class="circle">
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="27 21 64 72" height="72px" width="64px">
        
                    <desc>Created with Sketch.</desc>
                    <defs>
                        <polygon points="60.9784821 18.4748913 60.9784821 0.0299638385 0.538377293 0.0299638385 0.538377293 18.4748913" id="path-1"></polygon>
                    </defs>
                    <g transform="translate(27.000000, 21.000000)" fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="Group-12">
                        <g id="Group-5">
                            <g transform="translate(2.262327, 21.615176)" id="Group-3">
                                <mask fill="white" id="mask-2">
                                    
                                </mask>
                                <g id="Clip-2"></g>
                                <path mask="url(#mask-2)" fill="#59A785" id="Fill-1" d="M7.17774177,18.4748913 L54.3387782,18.4748913 C57.9910226,18.4748913 60.9789911,15.7266455 60.9789911,12.3681986 L60.9789911,6.13665655 C60.9789911,2.77820965 57.9910226,0.0299638385 54.3387782,0.0299638385 L7.17774177,0.0299638385 C3.52634582,0.0299638385 0.538377293,2.77820965 0.538377293,6.13665655 L0.538377293,12.3681986 C0.538377293,15.7266455 3.52634582,18.4748913 7.17774177,18.4748913"></path>
                            </g>
                            <polygon points="62.0618351 55.9613216 7.2111488 60.3692832 1.50838775 5.79374073 56.3582257 1.38577917" transform="translate(31.785111, 30.877531) rotate(-2.000000) translate(-31.785111, -30.877531)" fill="#FFFFFF" id="Fill-4"></polygon>
                            <ellipse ry="9.17325562" rx="9.95169733" cy="21.7657707" cx="30.0584472" opacity="0.216243004" fill="#25D48A" id="Oval-3"></ellipse>
                            <g fill="#54C796" transform="translate(16.959615, 6.479082)" id="Group-4">
                                <polygon points="10.7955395 21.7823628 0.11873799 11.3001058 4.25482787 7.73131106 11.0226557 14.3753897 27.414824 1.77635684e-15 31.3261391 3.77891399" id="Fill-6"></polygon>
                            </g>
                            <path fill="#59B08B" id="Fill-8" d="M4.82347935,67.4368303 L61.2182039,67.4368303 C62.3304205,67.4368303 63.2407243,66.5995595 63.2407243,65.5765753 L63.2407243,31.3865871 C63.2407243,30.3636029 62.3304205,29.5263321 61.2182039,29.5263321 L4.82347935,29.5263321 C3.71126278,29.5263321 2.80095891,30.3636029 2.80095891,31.3865871 L2.80095891,65.5765753 C2.80095891,66.5995595 3.71126278,67.4368303 4.82347935,67.4368303"></path>
                            <path fill="#4FC391" id="Fill-10" d="M33.3338063,67.4368303 L61.2181191,67.4368303 C62.3303356,67.4368303 63.2406395,66.5995595 63.2406395,65.5765753 L63.2406395,31.3865871 C63.2406395,30.3636029 62.3303356,29.5263321 61.2181191,29.5263321 L33.3338063,29.5263321 C32.2215897,29.5263321 31.3112859,30.3636029 31.3112859,31.3865871 L31.3112859,65.5765753 C31.3112859,66.5995595 32.2215897,67.4368303 33.3338063,67.4368303"></path>
                            <path fill="#FEFEFE" id="Fill-15" d="M29.4284029,33.2640869 C29.4284029,34.2202068 30.2712569,34.9954393 31.3107768,34.9954393 C32.3502968,34.9954393 33.1931508,34.2202068 33.1931508,33.2640869 C33.1931508,32.3079669 32.3502968,31.5327345 31.3107768,31.5327345 C30.2712569,31.5327345 29.4284029,32.3079669 29.4284029,33.2640869"></path>
                            <path fill="#5BD6A2" id="Fill-12" d="M8.45417501,71.5549073 L57.5876779,71.5549073 C60.6969637,71.5549073 63.2412334,69.2147627 63.2412334,66.3549328 L63.2412334,66.3549328 C63.2412334,63.4951029 60.6969637,61.1549584 57.5876779,61.1549584 L8.45417501,61.1549584 C5.34488919,61.1549584 2.80061956,63.4951029 2.80061956,66.3549328 L2.80061956,66.3549328 C2.80061956,69.2147627 5.34488919,71.5549073 8.45417501,71.5549073"></path>
                        </g>
                    </g>
                </svg>
            </div>
            <p>Credentialing</p>
        </a>
        </div>
    </div>  --}}
<div class="row col-md-12">
    <a href="http://www.google.com" class="col-md-6">
        <div class="row col-md-12">
            <div class="col-lg-4" id="mod_inspeccion">
                <div class="card bg-primary text-white-50">
                    <div class="card-body text-center">
                        <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                        <h1 class="mt-0 mb-4 text-white"> Inspección </h1>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="http://www.google.com" class="col-md-6">
        <div class="row col-md-12">
            <div class="col-lg-4" id="mod_gestoria">
                <div class="card bg-primary text-white-50">
                    <div class="card-body text-center">
                        <i class="mdi mdi-car me-3 text-white" style="font-size: 100px;"></i>
                        <h1 class="mt-0 mb-4 text-white"> Inspección </h1>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>


    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{--  <form method="POST" action="#" autocomplete="off">
                        @csrf  --}}
                        <div class="row col-md-12">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="col-form-label"> Nombre </label>
                                <input type="text" class="form-control form-control-sm" name="nombre" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="compania" class="col-form-label"> Compañia </label>
                                <input type="text" class="form-control form-control-sm" name="compania" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="telefono" class="col-form-label"> Teléfono </label>
                                <input type="text" class="form-control form-control-sm" name="telefono">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="vehiculo" class="col-form-label"> Vehículo </label>
                                <input type="text" class="form-control form-control-sm" name="vehiculo" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marca" class="col-form-label"> Marca </label>
                                <input type="text" class="form-control form-control-sm" name="marca" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="anio" class="col-form-label"> Año </label>
                                <input type="text" class="form-control form-control-sm" name="anio" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cuatroDigitos" class="col-form-label"> últimos 4 dígitos de SS </label>
                                <input type="text" class="form-control form-control-sm" name="cuatroDigitos" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="col-form-label"> Email </label>
                                <input type="email" class="form-control form-control-sm" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="vencimiento" class="col-form-label"> Mes de Vencimiento </label>
                                <input type="text" class="form-control form-control-sm" name="vencimiento" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marbetesPendientes" class="col-form-label"> Masbertes Pendientes </label>
                                <input type="text" class="form-control form-control-sm" name="marbetesPendientes" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rol_id" class="col-form-label"> Costo de Inspección </label>
                                <select class="form-select form-select-sm" style="cursor: pointer;" id="rol_id">
                                    <option value="" selected>Selecciona una opción</option>
                                    @foreach ($costosInspeccion as $costo)
                                        <option value="{{ $costo->id}}">{{ $costo->nombre}} - ${{ $costo->costo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{--  <form method="POST" action="{{ route('pdf.data') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <div class="dropzone">
                                        <div class="fallback">
                                            <input name="filepdf" type="file">
                                        </div>
                                        <div class="dz-message needsclick">
                                            <div class="mb-3">
                                                <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                            </div>
        
                                            <h4> Adjunta un archivo o click para cargar el archivo</h4>
                                        </div>
                                    </div>
            
                                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                                        <li class="mt-2" id="dropzone-preview-list">
                                            <!-- This is used as the file preview template -->
                                            <div class="border rounded">
                                                <div class="d-flex p-2">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm bg-light rounded">
                                                            <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                                src="https://img.themesbrand.com/judia/new-document.png"
                                                                alt="Dropzone-Image">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="pt-1">
                                                            <h5 class="fs-md mb-1" data-dz-name>&nbsp;</h5>
                                                            <p class="fs-sm text-muted mb-0" data-dz-size></p>
                                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-3">
                                                        <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Send Files</button>
                                    </div>
                                </div>
                            </form>  --}}
                            <form action="{{ route('pdf.data') }}" method="post" enctype="multipart/form-data" >
                                @csrf
                                <input type="file" name="urlpdf" >
                                <input type="submit" value="subir">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary">Guardar</button>
                        </div>
                    {{--  </form>  --}}
                </div>
            </div>
        </div>
    </div>

    @include('principal.selectMarbete')
    @include('principal.selectSeguro')

@endsection
@section('script')
    <script>
        $("#inspeccionVehiculo").click(function() {
            $('#staticBackdrop').modal('show')
        });
        $("#ventaMarbetes").click(function() {
            $('#select_marbete').modal('show')
        });
        $("#seguro").click(function() {
            $('#select_seguro').modal('show')
        });
        
        $("#seguro_id").on("change", function() {
            var seguro_id = $(this).val();
            if(seguro_id == 1){
                document.getElementById("opcion_vaucher").style.display = "initial";
            }else{
                document.getElementById("opcion_vaucher").style.display = "none";
           }
        });
    </script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>

    <!-- Form file upload init js -->
    <script src="{{ URL::asset('build/js/pages/form-file-upload.init.js') }}"></script>
@endsection