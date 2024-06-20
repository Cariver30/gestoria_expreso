<div class="modal fade" id="select_marbete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marbetes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row modal-body">
                <input type="hidden" name="marbete_id" id="marbete_id">
                <input type="hidden" name="marbete_five_id" id="marbete_five_id" @if (isset($vehiculo)) value="{{ $venta->costo_servicio_fijo}}" @else value="0" @endif>
                <div class="row col-md-12 mb-3">
                    @foreach ($marbetes as $marbete)
                        <button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light btnInspeccionMarbete" style="margin: 1px;" data-id="{{ $marbete->id}}">{{ $marbete->nombre}} - ${{ $marbete->costo}} </button>
                    @endforeach
                </div>
                <div class="row col-md-12">
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                    <div class="col-md-2">
                        <div class="card bg-success text-white">
                            <div class="card-header bg-transparent border-success">
                                <label for="costo_marbete_admin"> Customizado </label>
                                <input type="number" class="form-control form-control-sm" name="costo_marbete_admin" id="costo_marbete_admin">
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-2">
                        <div class="card bg-success text-white">
                            <div class="card-header bg-transparent border-success">
                                <label for="">Derechos Anuales</label>
                                <input type="text" class="form-control form-control-sm" id="derecho_anual">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-info col-md-12 waves-effect waves-light btnInspeccionMarbeteACCA" @if (count($accas) == 0) disabled @endif > ACCA </button>
                    </div>
                    <div class="col-md-3 mb-4 costoServicioObligatorio" style="cursor: pointer;">
                        <div class="card border border-success cardMain">
                            <div class="card-header bg-transparent border-success">
                                <h5 class="my-0 text-success">$5 Costo de Servicio</h5>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  <button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light btnFiveMarbete" style="margin: 1px;"> $5 </button>  --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveInspeccionMarbete">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>