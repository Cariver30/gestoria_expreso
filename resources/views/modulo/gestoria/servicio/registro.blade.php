<div class="modal fade" id="add_vehiculo_gestoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Cliente </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    <div class="col-md-4">
                        <label for="nombre" class="col-form-label"> Nombre completo</label>
                        <input type="text" class="form-control form-control-md" name="nombre" id="nombre" @if (isset($cliente)) value="{{ $cliente->nombre }}" @endif>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="col-form-label"> Email </label>
                        <input type="email" class="form-control form-control-md" name="email" id="email" @if (isset($cliente)) value="{{ $cliente->email }}" @endif>
                    </div>
                    <div class="col-md-4">
                        <label for="telefono" class="col-form-label"> Teléfono </label>
                        <input type="text" class="form-control form-control-md" name="telefono" id="telefono" @if (isset($cliente)) value="{{ $cliente->telefono }}" @endif>
                    </div>
                    <div class="col-md-4">
                        <label for="seguro_social" class="col-form-label"> Seguro Social </label>
                        <input type="text" class="form-control form-control-md" name="seguro_social" id="seguro_social" @if (isset($cliente)) value="{{ $cliente->seguro_social }}" @endif>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="identificacion" class="col-form-label"> Licencia/Identificación </label>
                        <input type="text" class="form-control form-control-md" name="identificacion" id="identificacion" @if (isset($cliente)) value="{{ $cliente->identificacion }}" @endif>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnSaveClienteGestoria">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>