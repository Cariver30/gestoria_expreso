<div class="modal fade" id="add_entidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva entidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" id="formStoreUsuario">
                    <div class="col-md-12">
                        <label for="name" class="col-form-label"> Nombre </label>
                        <input type="text" class="form-control form-control-sm" id="nombre" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="saveEntidad">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>