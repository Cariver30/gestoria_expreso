<div class="modal fade" id="add_sub_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off">
                    <div class="row col-md-12">
                        <input type="hidden" name="sub_id" id="sub_id">
                        <div class="col-md-8 mb-3">
                            <label for="nombre" class="col-form-label"> Nombre del servicio </label>
                            <input type="text" class="form-control form-control-sm" name="sub_nombre" id="sub_nombre" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="costo" class="col-form-label"> Costo del servicio </label>
                            <input type="number" class="form-control form-control-sm" name="sub_costo" id="sub_costo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="saveSubServicios">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>