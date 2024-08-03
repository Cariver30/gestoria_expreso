<div class="modal fade" id="modal_tipo_de_pago" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tipos de Pago </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row col-md-12 mb-4 pt-4">
                    <input type="hidden" name="venta_id" id="venta_id">
                    <div class="form-check col-md-3 font-size-16">
                        {{--  <input class="form-check-input" type="radio" name="paymentoptionsRadio" id="paymentoptionsRadio1" disabled>
                        <label class="form-check-label font-size-13" for="paymentoptionsRadio1">
                            <i class="fab fa-cc-mastercard me-1 font-size-20 align-top"></i>Tarjeta de débito/crédito
                        </label>  --}}
                    </div>
                    <div class="form-check col-md-6 font-size-16">
                        <div class="mb-1">
                            <label class="card-radio-label">
                                <input type="radio" name="pagoEfectivo" id="pagoEfectivo" class="card-radio-input" checked>
                                <div class="card-radio">
                                    <div>
                                        <i class="bx bx-dollar-circle font-size-20 text-warning me-2"></i>
                                        <span> Efectivo </span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        {{--  <input class="form-check-input" type="radio" name="paymentoptionsRadio" id="paymentoptionsRadio2" checked>
                        <label class="form-check-label font-size-20" for="paymentoptionsRadio2">
                            <i class="bx bx-dollar-circle me-1 font-size-24 align-top"></i> Efectivo
                        </label>  --}}
                    </div>
                    <div class="form-check col-md-6 font-size-16">
                        {{--  <input class="form-check-input" type="radio" name="paymentoptionsRadio" id="paymentoptionsRadio3" disabled>
                        <label class="form-check-label font-size-13" for="paymentoptionsRadio3">
                            <i class="far fa-money-bill-alt me-1 font-size-20 align-top"></i> Otro
                        </label>  --}}
                    </div><br>
                </div>
            </div>
            <div class="row col-sm-12 mb-4 pt-4">
                <div class="col-sm-6 col-sm-2 text-end">
                    <button type="button" class="btn btn-secondary col-md-4" data-bs-dismiss="modal">Cerrar</button>
                </div>
                <div class="col-sm-6 col-sm-2 text-start">
                    <button type="button" class="btn btn-primary col-md-4" id="payService"> Pagar </button>
                </div>
            </div>
        </div>
    </div>
</div>
