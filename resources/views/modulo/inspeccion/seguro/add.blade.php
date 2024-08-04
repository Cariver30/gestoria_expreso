<div class="modal fade" id="modal_inspeccion_seguro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seguros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row col-md-12">
                <div class="row col-md-12 mb-3">
                    @foreach ($seguros as $seguro)
                        {{--  <button type="button" class="btn btn-soft-success col-md-4 waves-effect waves-light" style="margin: 1px;" data-id="{{ $seguro->id}}">{{ $seguro->nombre}} -${{ $seguro->costo}}</button>  --}}
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="valorSeguro" value="{{ $seguro->id}}" class="card-radio-input valorSeguro" @if (isset($venta) && $venta->costo_seguro_id == $seguro->id) checked @endif>
                                    <div class="card-radio">
                                        <div class="text-center">
                                            <span>{{ $seguro->nombre}}</span><br>
                                            <span> @if ($seguro->id == 1 || $seguro->id == 2) - ${{ $seguro->costo}} @else ${{ $seguro->costo}} @endif</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveInspeccionSeguro">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>