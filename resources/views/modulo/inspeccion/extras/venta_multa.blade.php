<div class="modal fade" id="extra_venta_multas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Multas de Ley </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row col-md-12">
                <div class="row col-md-12 mb-3">
                    @if (count($multas) != 0)
                        @foreach ($multas as $multa)
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="card-radio-label mb-2">
                                        <input type="radio" name="valorExtraMulta" value="{{ $multa->id}}" class="card-radio-input valorExtraMulta" @if (isset($venta) && $venta->extra_multa_id == $multa->id) checked @endif>
                                        <div class="card-radio">
                                            <div class="text-center">
                                                <span>{{ $multa->nombre}}</span><br>
                                                <span> ${{ $multa->costo}} </span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <span>¡Sin multas de ley disponibles, debe registrar al menos una el Administrador! </span>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveExtraMulta">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>