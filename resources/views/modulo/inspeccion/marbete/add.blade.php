<div class="modal fade" id="select_marbete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marbetes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="marbete_id" id="marbete_id">
                <input type="hidden" name="marbete_five_id" id="marbete_five_id" value="0">
                <a href="http://"></a>
                <div class="row col-md-12 mb-3">
                    @foreach ($marbetes as $marbete)
                        <button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light btnInspeccionMarbete" style="margin: 1px;" data-id="{{ $marbete->id}}">{{ $marbete->nombre}} - ${{ $marbete->costo}} </button>
                    @endforeach
                    <div class="col-md-3 costoServicioObligatorio" style="cursor: pointer;">
                        <div class="card border border-success cardMain">
                            <div class="card-header bg-transparent border-success">
                                <h5 class="my-0 text-success">$5 Costo de Servicio</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                    <div class="col-md-2">
                        <label for="costo_marbete_admin" class="col-form-label"> Customizado </label>
                        <input type="number" class="form-control form-control-sm" name="costo_marbete_admin" id="costo_marbete_admin">
                    </div>
                @endif

                {{--  <button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light btnFiveMarbete" style="margin: 1px;"> $5 </button>  --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveInspeccionMarbete">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>