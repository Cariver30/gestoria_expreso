<div class="modal fade" id="edit_ss_gestoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off">
                    <div class="row col-md-12">
                        <input type="hidden" id="up_ss_gestoria_id" value="">
                        <div class="col-md-8 mb-3">
                            <label for="name" class="col-form-label"> Nombre del servicio </label>
                            <input type="text" class="form-control form-control-sm" id="up_ss_nombre_gestoria" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name" class="col-form-label"> Costo del servicio </label>
                            <input type="text" class="form-control form-control-sm" id="up_ss_costo_gestoria" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnEditSSGestoria">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>