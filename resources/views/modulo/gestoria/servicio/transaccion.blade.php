<div class="modal fade" id="transacciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Transacciones </h5>
                {{--  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  --}}
            </div>
            <div class="modal-body row col-md-12">
                <div class="row col-md-12 mb-3">
                    @foreach ($transacciones as $transaccion)
                        {{--  <button type="button" class="btn btn-soft-success col-md-4 waves-effect waves-light" style="margin: 1px;" data-id="{{ $seguro->id}}">{{ $seguro->nombre}} -${{ $seguro->costo}}</button>  --}}
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="valorSeguro" value="{{ $transaccion->id}}" class="card-radio-input btnGestoriaTransaccion" data-id="{{ $transaccion->id}}">
                                    <div class="card-radio">
                                        <div class="text-center">
                                            <span>{{ $transaccion->nombre}}</span><br>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  <div class="modal fade" id="transacciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Transacción </h5>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    @foreach ($transacciones as $transaccion)
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="" value="{{ $transaccion->id}}" class="card-radio-input btnTransaccionGestoria" data-id="{{ $transaccion->id}}">
                                    <div class="card-radio">
                                        <div class="text-center">
                                            <span>{{ $transaccion->nombre}}</span><br>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>  --}}