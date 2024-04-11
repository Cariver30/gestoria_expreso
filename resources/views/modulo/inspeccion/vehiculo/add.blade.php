<div class="modal fade" id="add_vehiculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Agregar Vehículo </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{--  <form method="POST" action="#" autocomplete="off">
                    @csrf  --}}
                    <div class="row col-md-12">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="col-form-label"> Nombre completo</label>
                            <input type="text" class="form-control form-control-sm" name="nombre" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="email" class="col-form-label"> Email </label>
                            <input type="email" class="form-control form-control-sm" name="email" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="telefono" class="col-form-label"> Teléfono </label>
                            <input type="number" class="form-control form-control-sm" name="telefono">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="compania" class="col-form-label"> Compañia </label>
                            <input type="text" class="form-control form-control-sm" name="compania" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vehiculo" class="col-form-label"> Vehículo </label>
                            <input type="text" class="form-control form-control-sm" name="vehiculo" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="marca" class="col-form-label"> Tablilla </label>
                            <input type="text" class="form-control form-control-sm" name="marca" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="marca" class="col-form-label"> Marca </label>
                            <input type="text" class="form-control form-control-sm" name="marca" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="anio" class="col-form-label"> Año </label>
                            <input type="text" class="form-control form-control-sm" name="anio" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cuatroDigitos" class="col-form-label"> Últimos 4 dígitos de SS </label>
                            <input type="text" class="form-control form-control-sm" name="cuatroDigitos" required>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="vencimiento" class="col-form-label"> Mes de Vencimiento </label>
                            <select class="form-select form-select-sm" style="cursor: pointer;" id="rol_id">
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
                        <div class="col-md-3 mb-3">
                            <label for="rol_id" class="col-form-label"> Costo de Inspección </label>
                            <select class="form-select form-select-sm" style="cursor: pointer;" id="rol_id" @if(count($costosInspeccion) == 0)) disabled @endif>
                                <option value="" selected>Selecciona una opción</option>
                                @foreach ($costosInspeccion as $costo)
                                    <option value="{{ $costo->id}}">{{ $costo->nombre}} - ${{ $costo->costo}}</option>
                                @endforeach
                            </select>
                        </div>
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