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
                    <div class="col-md-12 mb-3">
                        <label for="acceso_panel" class="col-form-label"> Accesos </label>
                        <select class="form-select form-select-sm" style="cursor: pointer;" id="acceso_panel" required>
                            <option value="" selected>Selecciona una opción</option>
                            <option value="0">Todos</option>
                            <option value="1">Inspección</option>
                            <option value="2">Gestoría</option>
                        </select>
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