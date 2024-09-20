<div class="modal fade" id="subRegistros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Vehículos - Registros </h5>
            </div>
            <div class="modal-body row col-md-12">
                <div class="row col-md-12 mb-3">
                    @foreach ($subRegistros as $subRegistro)
                        <div class="col-md-3 text-center">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="valorRegistro" value="{{ $subRegistro->id}}" class="card-radio-input btnValorRegistro" data-id="{{ $subRegistro->id}}">
                                    <div class="card-radio">
                                        <div class="text-center">
                                            <span>{{ $subRegistro->nombre }}</span><br>
                                            <span>${{ $subRegistro->costo }}</span><br>
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
                <button type="button" class="btn btn-primary" id="saveGestoriaRegistro">Guardar</button>
            </div>
        </div>
    </div>
</div>