<div class="modal fade" id="vehiculos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Certificación de Venta o Multa </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    @foreach ($vehiculos as $vehiculo)
                        <button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light" style="margin: 1px;" data-id="{{ $vehiculo->id}}">{{ $vehiculo->nombre}} </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>