<div class="modal fade" id="select_seguro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seguros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row col-md-12">
                <div class="col-md-8 mb-3">
                    <label for="marbete_id" class="col-form-label"> Seguros disponibles </label>
                    <select class="form-select form-select-sm" style="cursor: pointer;" id="marbete_id">
                        <option value="" selected>Selecciona una opción</option>
                        @foreach ($seguros as $seguro)
                            <option value="{{ $seguro->id}}">{{ $seguro->nombre}} - ${{ $seguro->costo}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="name" class="col-form-label"> Número de voucher </label>
                    <input type="text" class="form-control form-control-sm" id="nombre" required>
                    <small> Sí es seguro privado</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveRol">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>