<div class="modal fade" id="update_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar cliente</h5>
            </div>
            <div class="modal-body">
                <form autocomplete="off">
                    <div class="row col-md-12">
                        <input type="hidden" name="up_id" id="up_id">
                        <div class="col-md-4 mb-3">
                            <label for="nombre" class="col-form-label"> Nombre(s) </label>
                            <input type="text" class="form-control form-control-sm" id="up_nombre" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email" class="col-form-label"> Email </label>
                            <input type="email" class="form-control form-control-sm" id="up_email">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="telefono" class="col-form-label"> Teléfono </label>
                            <input type="text" class="form-control form-control-sm" id="up_telefono" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="seguro_social" class="col-form-label"> Seguro Social </label>
                            <input type="text" class="form-control form-control-sm" id="up_seguro_social" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="identificacion" class="col-form-label"> Identificación </label>
                            <input type="text" class="form-control form-control-sm" id="up_identificacion" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelar_cliente">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="updateCliente">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>