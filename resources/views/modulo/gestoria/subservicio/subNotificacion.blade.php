<div class="modal fade" id="subNotificaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Vehículos - Notificaciones </h5>
            </div>
            <div class="modal-body row col-md-12">
                <div class="row col-md-12 mb-3">
                    @foreach ($subNotificaciones as $subNotificacion)
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="valorNotificacion" value="{{ $subNotificacion->id}}" class="card-radio-input btnValorNotificacion" data-id="{{ $subNotificacion->id}}">
                                    <div class="card-radio">
                                        <div class="text-center">
                                            <span>{{ $subNotificacion->nombre }}</span><br>
                                            <span>${{ $subNotificacion->costo }}</span><br>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveGestoriaNotificacion">Guardar</button>
            </div>
        </div>
    </div>
</div>