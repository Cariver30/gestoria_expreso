<div class="modal fade" id="subTransaccion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Precios de Transacciones </h5>
            </div>
            <div class="modal-body row col-md-12">
                <div class="row col-md-12 mb-3">
                    @foreach ($subtransacciones as $subtransaccion)
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="valorTransaccion" value="{{ $subtransaccion->id}}" class="card-radio-input btnValorTransaccion" data-id="{{ $subtransaccion->id}}">
                                    <div class="card-radio">
                                        <div class="text-center">
                                            <span>{{ $subtransaccion->nombre }}</span><br>
                                            <span>${{ $subtransaccion->costo }}</span><br>
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
                <button type="button" class="btn btn-primary" id="saveGestoriaTransaccion">Guardar</button>
            </div>
        </div>
    </div>
</div>