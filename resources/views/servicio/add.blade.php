<div class="modal fade" id="add_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('servicio.store') }}" autocomplete="off">
                    @csrf
                    <div class="row col-md-12">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="col-form-label"> Nombre del servicio </label>
                            <input type="text" class="form-control form-control-sm" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="costo" class="col-form-label"> Costo </label>
                            <input type="number" class="form-control form-control-sm" name="costo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>