<div class="modal fade" id="select_marbete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marbetes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="marbete_id" id="marbete_id" value="">
                <div class="row col-md-12 mb-3">
                    @foreach ($marbetes as $marbete)
                        <button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light btnInspeccionMarbete" style="margin: 1px;" data-id="{{ $marbete->id}}">{{ $marbete->nombre}} - ${{ $marbete->costo}} </button>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveInspeccionMarbete">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>