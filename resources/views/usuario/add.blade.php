<div class="modal fade" id="add_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('usuario.store') }}" autocomplete="off">
                    @csrf
                    <div class="row col-md-12">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="col-form-label"> Nombre(s) </label>
                            <input type="text" class="form-control form-control-sm" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="primer_apellido" class="col-form-label"> Primer apellido </label>
                            <input type="text" class="form-control form-control-sm" name="primer_apellido" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="segundo_apellido" class="col-form-label"> Segundo apellido </label>
                            <input type="text" class="form-control form-control-sm" name="segundo_apellido">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="col-form-label"> Email </label>
                            <input type="email" class="form-control form-control-sm" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rol_id" class="col-form-label"> Rol </label>
                            <select name="rol_id" class="form-select form-select-sm" style="cursor: pointer;">
                                <option value="" selected>Selecciona una opción</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>