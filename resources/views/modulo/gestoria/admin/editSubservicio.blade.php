<div class="modal fade" id="edit_subServicio_gestoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Sub Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off">
                    <div class="row col-md-12">
                        <input type="hidden" name="sub_servicio_id" id="sub_servicio_gestoria_id">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="col-form-label"> Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="up_sub_nombre_gestoria" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnUpdateSubservicioGestoria">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>