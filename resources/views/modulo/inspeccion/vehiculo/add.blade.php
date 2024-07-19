<div class="modal fade" id="add_vehiculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Agregar Vehículo </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <fieldset class="border p-2 row col-md-12">
                    <div class="col-md-3 mb-3">
                        <h5> Registro<small>(*)</small></h5>
                        <select class="form-select form-select-sm" style="cursor: pointer;" id="tipo_registro" name="tipo_registro">
                            <option value=""> Selecciona una opción </option>
                            <option value="0"> Nuevo registro </option>
                            <option value="1"> Agregar servicio </option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3" style="display: none;" id="cliente_select_id">
                        <h5>Cliente</h5>
                        <select class="form-select form-select-sm buscarTablillaCliente" style="cursor: pointer;" id="getClientes" name="cliente_select_id">
                            <option value="" selected>Selecciona un cliente</option>
                            @foreach ($listClientes as $listCliente)
                                <option value="{{$listCliente->id}}">{{ $listCliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3" style="display: none;" id="cliente_select_tablilla">
                        <h5> Tablilla </h5>
                        <select class="form-select form-select-sm select_tablilla_vehiculo" style="cursor: pointer;" name="cliente_select_tablilla">
                            <option value="" selected>Selecciona un vehículo</option>
                        </select>
                    </div>
                    <h5 class="mb-4 pt-4"> Datos del Propietario </h5>
                    <div class="col-md-3 mb-4">
                        <label for="seguro_social" class="col-form-label"> Últimos 4 dígitos de Seguro Social </label>
                        <input type="text" class="form-control form-control-sm" name="seguro_social" id="seguro_social" maxlength="4" @if (isset($cliente)) value="{{ $cliente->seguro_social }}" @endif required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="nombre" class="col-form-label"> Nombre completo</label>
                        <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" @if (isset($cliente)) value="{{ $cliente->nombre }}" @endif required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="email" class="col-form-label"> Correo Electrónico </label>
                        <input type="email" class="form-control form-control-sm" name="email" id="email" @if (isset($cliente)) value="{{ $cliente->email }}" @endif required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="telefono" class="col-form-label"> Teléfono </label>
                        <input type="tel" class="form-control form-control-sm" name="telefono" id="telefono" maxlength="10" pattern="[0-9]{10}" @if (isset($cliente)) value="{{ $cliente->telefono }}" @endif>
                    </div>
                </fieldset>
            <fieldset class="border p-2 row col-md-12">
                <h5> Datos del Vehículo </h5>
                <div class="row col-md-12 formVehiculo">
                <div class="col-md-3 mb-3">
                    <label for="compania" class="col-form-label"> Compañía </label>
                    <input type="text" class="form-control form-control-sm" name="compania" id="compania" @if (isset($vehiculo)) value="{{ $vehiculo->compania }}" @endif required>
                </div>
                    <div class="col-md-3 mb-3">
                        <label for="identificacion" class="col-form-label"> Licencia/Identificación </label>
                        <input type="text" class="form-control form-control-sm" name="identificacion" id="identificacion" @if (isset($cliente)) value="{{ $cliente->identificacion }}" @endif>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="vehiculo" class="col-form-label"> Vehículo </label>
                        <input type="text" class="form-control form-control-sm" name="vehiculo" id="vehiculo" @if (isset($vehiculo)) value="{{ $vehiculo->vehiculo }}" @endif required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="tablilla" class="col-form-label"> Tablilla </label>
                        <input type="text" class="form-control form-control-sm" name="tablilla" id="tablilla" @if (isset($vehiculo)) value="{{ $vehiculo->tablilla }}" @endif required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="marca" class="col-form-label"> Marca </label>
                        <input type="text" class="form-control form-control-sm" name="marca" id="marca" @if (isset($vehiculo)) value="{{ $vehiculo->marca }}" @endif required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="anio" class="col-form-label"> Año </label>
                        <input type="text" class="form-control form-control-sm" name="anio" id="anio" maxlength="4" minlength="4" @if (isset($vehiculo)) value="{{ $vehiculo->anio }}" @endif>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="mes_vencimiento" class="col-form-label"> Mes de Vencimiento </label>
                        <select class="form-select form-select-sm" style="cursor: pointer;" id="mes_vencimiento" name="mes_vencimiento">
                            <option value="" selected>Selecciona un mes</option>
                            @foreach ($meses as $mes)
                                <option value="{{$mes->id}}" @if (isset($vehiculo) && $mes->id == $vehiculo->mes_vencimiento_id) selected @endif>{{ $mes->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="costo_inspeccion_id" id="costo_inspeccion_id" value="0">
                    @if (count($costosInspeccion) != 0)
                        <div class="row col-md-12 mb-3">
                            <label for="costo_inspeccion" class="col-form-label"> Costo de Inspección </label>
                            {{--  @if (count($costosInspeccion) == 0) <small class="text-danger">Debe registrar por lo menos un costo de inspección</small> @endif  --}}
                            @foreach ($costosInspeccion as $costo)
                                <button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light btnCostoInspeccion" style="margin: 1px;" data-id="{{ $costo->id}}">{{ $costo->nombre}} - ${{ $costo->costo}} </button>
                            @endforeach
                        </div>
                    @endif
                    <div class="col-md-12 mb-4" style="height: 50% important;">
                        <div class="dropzone">
                            <div class="fallback">
                                <label for="file_licencia" class="col-form-label"> Cargar Licencia </label>
                                <input type="file" name="file_licencia" id="file_licencia" accept="image/*" onchange="validateFileType()"/>
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                </div>
                                <h4> Click para cargar licencia.</h4>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                            <li class="mt-2" id="dropzone-preview-list">
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
                                            <button data-dz-remove class="btn btn-sm btn-danger"> Eliminar </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                        <div class="col-md-2">
                            <label for="costo_admin" class="col-form-label"> Customizado </label>
                            <input type="string" class="form-control form-control-sm" name="costo_admin" id="costo_admin" @if (isset($venta)) value="{{ $venta->costo_inspeccion_admin }}" @endif>
                        </div>
                    @endif
                </div>
            </fieldset>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveVehiculo">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>