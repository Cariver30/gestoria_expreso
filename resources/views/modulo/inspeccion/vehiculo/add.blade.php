<div class="modal fade" id="add_vehiculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Agregar Vehículo </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row col-md-12 formVehiculo">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="col-form-label"> Nombre completo</label>
                        <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="email" class="col-form-label"> Email </label>
                        <input type="email" class="form-control form-control-sm" name="email" id="email" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="telefono" class="col-form-label"> Teléfono </label>
                        <input type="number" class="form-control form-control-sm" name="telefono" id="telefono">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="compania" class="col-form-label"> Compañia </label>
                        <input type="text" class="form-control form-control-sm" name="compania" id="compania" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="vehiculo" class="col-form-label"> Vehículo </label>
                        <input type="text" class="form-control form-control-sm" name="vehiculo" id="vehiculo" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="tablilla" class="col-form-label"> Tablilla </label>
                        <input type="text" class="form-control form-control-sm" name="tablilla" id="tablilla" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="marca" class="col-form-label"> Marca </label>
                        <input type="text" class="form-control form-control-sm" name="marca" id="marca" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="anio" class="col-form-label"> Año </label>
                        <input type="text" class="form-control form-control-sm" name="anio" id="anio" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cuatroDigitos" class="col-form-label"> Últimos 4 dígitos de SS </label>
                        <input type="text" class="form-control form-control-sm" name="cuatroDigitos" id="cuatroDigitos" required>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="mes_vencimiento" class="col-form-label"> Mes de Vencimiento </label>
                        <select class="form-select form-select-sm" style="cursor: pointer;" id="mes_vencimiento" name="mes_vencimiento">
                            <option value="" selected>Selecciona un mes</option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                    <input type="hidden" name="costo_inspeccion_id" id="costo_inspeccion_id">
                    {{--  <div class="col-md-3 mb-3">
                        <label for="costo_inspeccion" class="col-form-label"> Costo de Inspección </label>
                        <select class="form-select form-select-sm" style="cursor: pointer;" id="costo_inspeccion" @if(count($costosInspeccion) == 0)) disabled @endif>
                            <option value="" selected>Selecciona una opción</option>
                            @foreach ($costosInspeccion as $costo)
                                <option value="{{ $costo->id}}">{{ $costo->nombre}} - ${{ $costo->costo}}</option>
                            @endforeach
                        </select>
                    </div>  --}}
                    <div class="row col-md-12 mb-3">
                        <label for="costo_inspeccion" class="col-form-label"> Costo de Inspección </label>
                        @foreach ($costosInspeccion as $costo)
                            <button type="button" class="btn btn-soft-success col-md-2 waves-effect waves-light btnCostoInspeccion" style="margin: 1px;" data-id="{{ $costo->id}}">{{ $costo->nombre}} - ${{ $costo->costo}} </button>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveVehiculo">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>