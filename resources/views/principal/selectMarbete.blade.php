<div class="modal fade" id="select_marbete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marbetes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mb-3">
                    <label for="marbete_id" class="col-form-label"> Marbetes </label>
                    <select class="form-select form-select-sm" style="cursor: pointer;" id="marbete_id">
                        <option value="" selected>Selecciona una opción</option>
                        @foreach ($marbetes as $marbete)
                            <option value="{{ $marbete->id}}">{{ $marbete->nombre}} - ${{ $marbete->costo}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveRol">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>