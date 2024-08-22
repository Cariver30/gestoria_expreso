<div class="modal fade" id="select_marbete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marbetes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row modal-body">
                <div class="row col-md-12 mb-3">
                    @foreach ($marbetes as $marbete)
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="valorMarbete" value="{{ $marbete->id}}" class="card-radio-input btnValorMarbete" @if (isset($venta) && $venta->costo_marbete_id == $marbete->id) checked @endif>
                                    <div class="card-radio">
                                        <div><span>{{ $marbete->nombre}} - ${{ $marbete->costo}}</span></div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row col-md-12">
                    @if (Auth::user()->rol_id == 1)
                        <div class="col-md-2">
                            <div class="card bg-success text-white">
                                <div class="card-header bg-transparent border-success">
                                    <label for="costo_marbete_admin"> Customizado </label>
                                    <input type="string" class="form-control form-control-sm" name="costo_marbete_admin" id="costo_marbete_admin" @if (isset($venta)) value="{{ $venta->costo_marbete_admin }}" @endif>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-2">
                        <div class="card bg-success text-white">
                            <div class="card-header bg-transparent border-success">
                                <label for="">Derechos Anuales</label>
                                <input type="text" class="form-control form-control-sm" id="derecho_anual" @if (isset($venta) && $venta->derechos_anuales != null) value="{{ $venta->derechos_anuales}}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-info col-md-12 waves-effect waves-light" data-bs-target="#marbete_acaa" data-bs-toggle="modal" data-bs-dismiss="modal" @if (count($acaas) == 0) disabled @endif > ACCA </button>
                    </div>
                    <div class="col-md-3 mb-4" style="cursor: pointer;">
                        <div class="mb-3">
                            <label class="card-radio-label mb-2">
                                <input type="radio" name="costoServicio" id="costoServicio" value="1" class="card-radio-input" @if (isset($venta) && $venta->costo_servicio_fijo != null) checked @endif>
                                <div class="card-radio">
                                    <div><span>$5 Costo de Servicio</span></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveInspeccionMarbete">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>