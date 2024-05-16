<div class="modal fade" id="add_costo_inspeccion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Costo de Inspección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off">
                    <div class="row col-md-12">
                        <input type="hidden" name="ci_servicio_id" id="ci_servicio_id">
                        <div class="col-md-8 mb-3">
                            <label for="nombre" class="col-form-label"> Nombre </label>
                            <input type="text" class="form-control form-control-sm" name="ci_nombre" id="ci_nombre" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="costo" class="col-form-label"> Costo </label>
                            <input type="number" class="form-control form-control-sm" name="ci_costo" id="ci_costo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="saveCostoInspeccion">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>