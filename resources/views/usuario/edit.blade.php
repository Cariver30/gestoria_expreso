<div class="modal fade" id="update_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off">
                    <div class="row col-md-12">
                        <input type="hidden" name="up_id" id="up_id">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="col-form-label"> Nombre(s) </label>
                            <input type="text" class="form-control form-control-sm" id="up_nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="primer_apellido" class="col-form-label"> Primer apellido </label>
                            <input type="text" class="form-control form-control-sm" id="up_primer_apellido" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="segundo_apellido" class="col-form-label"> Segundo apellido </label>
                            <input type="text" class="form-control form-control-sm" id="up_segundo_apellido">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="col-form-label"> Email </label>
                            <input type="email" class="form-control form-control-sm" id="up_email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rol_id" class="col-form-label"> Rol </label>
                            <select class="form-select form-select-sm" style="cursor: pointer;" id="up_rol_id" required>
                                <option value="" selected>Selecciona una opción</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>    
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="entidad_id" class="col-form-label"> Entidad </label>
                            <select class="form-select form-select-sm" style="cursor: pointer;" id="up_entidad_id" required>
                                <option value="" selected>Selecciona una opción</option>
                                @foreach ($entidades as $entidad)
                                    <option value="{{ $entidad->id }}">{{ $entidad->nombre }}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-id="{{ $rol->id }}" id="updateUsuario">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>