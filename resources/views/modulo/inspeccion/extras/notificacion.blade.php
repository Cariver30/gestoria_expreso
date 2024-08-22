<div class="modal fade" id="extra_notificacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Notificaciones </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row col-md-12">
                <div class="row col-md-12 mb-3">
                    @if (count($notificaciones) != 0)
                        @foreach ($notificaciones as $notificacion)
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="card-radio-label mb-2">
                                        <input type="radio" name="valorExtraNotificacion" value="{{ $notificacion->id}}" class="card-radio-input valorExtraNotificacion" @if (isset($venta) && $venta->extra_notificacion_id == $notificacion->id) checked @endif>
                                        <div class="card-radio">
                                            <div class="text-center">
                                                <span>{{ $notificacion->nombre}}</span><br>
                                                <span> ${{ $notificacion->costo}} </span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <span> ¡Sin Notificaciones disponibles, debe registrar al menos una el Administrador!</span>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    @if (count($notificaciones) != 0)
                        <button type="button" class="btn btn-primary" id="saveExtraNotificacion">Guardar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>