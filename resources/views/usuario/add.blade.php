<div class="modal fade" id="add_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" id="formStoreUsuario">
                    <div class="row col-md-12">
                        <div class="col-md-4 mb-3">
                            <label for="name" class="col-form-label"> Nombre(s) </label>
                            <input type="text" class="form-control form-control-sm" id="nombre" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="primer_apellido" class="col-form-label"> Primer apellido </label>
                            <input type="text" class="form-control form-control-sm" id="primer_apellido" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="segundo_apellido" class="col-form-label"> Segundo apellido </label>
                            <input type="text" class="form-control form-control-sm" id="segundo_apellido">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email" class="col-form-label"> Email </label>
                            <input type="email" class="form-control form-control-sm" id="email" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="rol_id" class="col-form-label"> Rol </label>
                            <select class="form-select form-select-sm" style="cursor: pointer;" id="rol_id" required>
                                <option value="" selected>Selecciona una opción</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>    
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pin" class="col-form-label"> PIN </label>
                            <input type="text" class="form-control form-control-sm" id="pin" maxlength="4">
                        </div>
                       @include('layouts.entidad')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-id="{{ $rol->id }}" id="saveUsuario" @if (count($entidades) == 1) disabled @endif>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>