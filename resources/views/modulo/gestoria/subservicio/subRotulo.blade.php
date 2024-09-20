<div class="modal fade" id="subRotulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Precios de Rotulo Removible </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row col-md-12">
                <div class="row col-md-12 mb-3">
                    @foreach ($rotulosRemovibles as $rotulosRemovible)
                        <div class="col-md-6 text-center">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="valorTitulo" value="{{ $rotulosRemovible->id}}" class="card-radio-input btnValorTitulo" data-id="{{ $rotulosRemovible->id}}">
                                    <div class="card-radio">
                                        <div class="text-center">
                                            <span>{{ $rotulosRemovible->nombre }}</span><br>
                                            <span>${{ $rotulosRemovible->costo }}</span><br>
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
                <button type="button" class="btn btn-primary" id="saveGestoriaTitulo">Guardar</button>
            </div>
        </div>
    </div>
</div>