@extends('layouts.master')

@section('title')
    Servicios
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/toastr/build/toastr.min.css') }}">
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box me-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h2> Servicios </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#add_servicio"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2"><i
                                        class="mdi mdi-plus me-1"></i> Agregar</button>
                            </div>
                        </div>
                    </div>
                    

                    <table id="datatable-servicio" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th> Nombre </th>
                                <th> Costo </th>
                                <th> Acciones </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servicios as $servicio)
                                <tr>
                                    <td>{{ $servicio->nombre }}</td>
                                    <td>{{ $servicio->costo }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="javascript: void(0);" class="dropdown-toggle card-drop px-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical font-size-18"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-start">
                                                <li><a href="#editServicio({{ $servicio->id }})" data-bs-toggle="modal" class="dropdown-item" data-edit-id="{{ $servicio->id }}"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Editar </a></li>
                                                <li><a class="dropdown-item eliminarServicio" style="cursor: pointer;" data-id="{{ $servicio->id }}"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Eliminar </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editServicio({{ $servicio->id }})" tabindex="-1" aria-labelledby="editServicio" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editServicio"> Editar Servicio </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('servicio.update', ['servicio' => $servicio->id]) }}" autocomplete="off">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row col-md-12">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="name" class="col-form-label"> Nombre del servicio </label>
                                                            <input type="text" class="form-control form-control-sm" name="nombre" value="{{ $servicio->nombre }}" required>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label for="costo" class="col-form-label"> Costo </label>
                                                            <input type="text" class="form-control form-control-sm" name="costo" value="{{ $servicio->costo }}" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- end modal body -->
                                        </div>
                                        <!-- end modal-content -->
                                    </div>
                                    <!-- end modal-dialog -->
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @include('servicio.add')
@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- toastr plugin -->
    <script src="{{ URL::asset('build/libs/toastr/build/toastr.min.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- toastr init -->
    <script src="{{ URL::asset('build/js/pages/toastr.init.js') }}"></script>
    <!-- Datatable init js -->
    <script>
        $(document).ready(function() {

            // Se declara el token global para las peticiones que se vayan a realizar
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
        
            //Buttons examples
            var table = $('#datatable-servicio').DataTable({
                language: {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "Sin resultados",
                    "info": "Mostrando _MAX_ registros en total | Página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sin registros disponibles",
                    "infoFiltered": "(filtrando de _MAX_ registros en total)",
                    "search": 'Buscar:',
                    "paginate": {
                        previous: 'Anterior',
                        next: 'Siguiente'
                    }
                },
                lengthChange: true
            });
        
            table.buttons().container().appendTo('#datatable-servicio_wrapper .col-md-6:eq(0)');
        
            $(".dataTables_length select").addClass('form-select form-select-sm');

            //Ajax
            $('.eliminarSerie').click(function () {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: '¿Seguro de eliminar esta serie?',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    showLoaderOnConfirm: true,
                    confirmButtonColor: "#556ee6",
                    cancelButtonColor: "#f46a6a",
                    preConfirm: function (email) {
                        return new Promise(function (resolve, reject) {
                            setTimeout(function () {
                            
                                    resolve()
                                
                            }, 2000)
                        })
                    },
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'delete',
                            url: 'serie/'+id,
                            success: function (data) {
                                if (data.code == 200) {
                                    toastr.options = {
                                        "closeButton" : false,
                                        "progressBar" : false
                                    }
                                    toastr.success("Serie eliminada");
                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 2000);
                                }

                            },
                            error: function (data) {
                                // console.log(data);
                            }
                        });
                    }
                })
            });
        });
    </script>
    @if(Session::has('success'))
        <script>
            toastr.options = {
                "closeButton" : false,
                "progressBar" : true
            }
            toastr.success("{{ session('success') }}");
        </script>
    @endif
    @if(Session::has('error'))
        <script>
            toastr.options = {
                "closeButton" : false,
                "progressBar" : true
            }
            toastr.warning("{{ session('error') }}");
        </script>
    @endif
@endsection
