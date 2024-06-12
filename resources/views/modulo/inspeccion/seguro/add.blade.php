<div class="modal fade" id="modal_inspeccion_seguro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seguros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row col-md-12">
                <input type="hidden" name="seguro_id" id="seguro_id" value="0">
                <div class="row col-md-12 mb-3">
                    @foreach ($seguros as $seguro)
                        <button type="button" class="btn btn-soft-success col-md-4 waves-effect waves-light btnInspeccionSeguro" style="margin: 1px;" data-id="{{ $seguro->id}}">{{ $seguro->nombre}} $-{{ $seguro->costo}}</button>
                    @endforeach
                </div>
                {{--  <div class="col-md-4 mb-3" id="opcion_vaucher" style="display: none">
                    <label for="num_vaucher" class="col-form-label"> Número de voucher </label>
                    <input type="text" class="form-control form-control-sm" id="num_vaucher">
                    <small> Sí es seguro privado</small>
                </div>  --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveInspeccionSeguro">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>