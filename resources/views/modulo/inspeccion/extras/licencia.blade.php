<div class="modal fade" id="extra_licencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Licencias </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row col-md-12">
                <div class="row col-md-12 mb-3">
                    @if (count($notificaciones) != 0)
                        @foreach ($licencias as $licencia)
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="card-radio-label mb-2">
                                        <input type="radio" name="valorExtraLicencia" value="{{ $licencia->id}}" class="card-radio-input valorExtraLicencia" @if (isset($venta) && $venta->extra_licencia_id == $licencia->id) checked @endif>
                                        <div class="card-radio">
                                            <div class="text-center">
                                                <span>{{ $licencia->nombre}}</span><br>
                                                <span> ${{ $licencia->costo}} </span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <span> ¡Sin Licencias disponibles, debe registrar al menos una el Administrador!</span>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    @if (count($notificaciones) != 0)
                        <button type="button" class="btn btn-primary" id="saveExtraLicencia"> Guardar </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>