<div class="modal fade" id="add_vehiculo_gestoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Cliente </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('gestoria.cliente') }}" method="post" id="formRegistro" enctype="multipart/form-data">
                    <div class="row col-md-12">
                        <div class="col-md-4">
                            <label for="seguro_social" class="col-form-label"> Seguro Social </label>
                            <input type="text" class="form-control form-control-md" name="seguro_social" minlength="1" maxlength="4" id="seguro_social" @if (isset($cliente)) value="{{ $cliente->seguro_social }}" @endif>
                        </div>
                        <div class="col-md-4">
                            <label for="nombre" class="col-form-label"> Nombre completo</label>
                            <input type="text" class="form-control form-control-md" name="nombre" id="nombre" @if (isset($cliente)) value="{{ $cliente->nombre }}" @endif>
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="col-form-label"> Email </label>
                            <input type="email" class="form-control form-control-md" name="email" id="email" @if (isset($cliente)) value="{{ $cliente->email }}" @endif>
                        </div>
                        <div class="col-md-4">
                            <label for="telefono" class="col-form-label"> Teléfono </label>
                            <input type="text" class="form-control form-control-md" name="telefono" id="telefono" @if (isset($cliente)) value="{{ $cliente->telefono }}" @endif>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="identificacion" class="col-form-label"> Licencia/Identificación </label>
                            <input type="text" class="form-control form-control-md" name="identificacion" id="identificacion" @if (isset($cliente)) value="{{ $cliente->identificacion }}" @endif>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="formFile" class="form-label"> Cargar licencia </label>
                            <input class="form-control" type="file" name="fileLicencia" id="formFile" accept="image/*" required>
                        </div>
                        {{--  <div class="col-md-12 mb-4" style="height: 50% important;">
                            <div class="dropzone">
                                <div class="fallback">
                                    <label for="fileIdentificacion" class="col-form-label"> Cargar Licencia </label>
                                    <input type="file" name="fileIdentificacion" id="fileIdentificacion" accept="image/*"/>
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                    </div>
                                    <h4> Click para cargar licencia.</h4>
                                </div>
                            </div>
                            <ul class="list-unstyled mb-0" id="dropzone-preview">
                                <li class="mt-2" id="dropzone-preview-list">
                                    <div class="border rounded">
                                        <div class="d-flex p-2">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm bg-light rounded">
                                                    <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                        src="https://img.themesbrand.com/judia/new-document.png"
                                                        alt="Dropzone-Image">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="pt-1">
                                                    <h5 class="fs-md mb-1" data-dz-name>&nbsp;</h5>
                                                    <p class="fs-sm text-muted mb-0" data-dz-size></p>
                                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-3">
                                                <button data-dz-remove class="btn btn-sm btn-danger"> Eliminar </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>  --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnSaveClienteGestoria">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>