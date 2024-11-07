<div class="modal fade" id="marbete_acaa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Marbetes ACAA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row modal-body">
                <div class="row col-md-12 mb-3">
                    @foreach ($acaas as $acaa)
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="marbeteacaa" value="{{ $acaa->id}}" class="card-radio-input marbeteacaa" @if (isset($venta) && $venta->serv_marbete_acca == $acaa->id) checked @endif>
                                    <div class="card-radio">
                                        <div class="text-center">
                                            <span>{{ $acaa->nombre}}</span><br>
                                            <span> ${{ $acaa->costo}} </span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-target="#select_marbete" data-bs-toggle="modal" data-bs-dismiss="modal">regresar</button>
                    {{--  <button type="button" class="btn btn-primary" id="saveMarbeteAcaa">Guardar</button>  --}}
                </div>
            </div>
        </div>
    </div>
</div>