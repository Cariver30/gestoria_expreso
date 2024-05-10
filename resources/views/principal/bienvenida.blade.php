<div class="modal fade bs-example-modal-center" id="bienvenida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient text-center">
                <h5 class="modal-title"> Bienvenido a Expreso Control Vehicular</h5>
            </div>
            <div class="modal-body text-center">
                <p>¡Hola {{ Auth::user()->nombre }}!</p>
                <button type="button" class="btn btn-soft-success waves-effect waves-light" id="btnContinuar">Continuar</button>
                {{--  <p>Elige en que entidad laborará el día de hoy</p>
                <button type="button" class="btn btn-soft-success waves-effect waves-light">Entidad 1</button>
                <button type="button" class="btn btn-soft-success waves-effect waves-light">Entidad 2</button>  --}}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->