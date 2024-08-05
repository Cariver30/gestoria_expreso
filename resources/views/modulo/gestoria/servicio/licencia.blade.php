<div class="modal fade" id="licencias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Licencias </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    @foreach ($licencias as $licencia)
                        {{--  <button type="button" class="btn btn-soft-success col-md-3 waves-effect waves-light btnLicenciaGestoria" style="margin: 1px;" data-id="{{ $licencia->id}}">{{ $licencia->nombre}} </button>  --}}
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="card-radio-label mb-2">
                                    <input type="radio" name="" value="{{ $licencia->id}}" class="card-radio-input btnLicenciaGestoria" data-id="{{ $licencia->id}}">
                                    <div class="card-radio">
                                        <div class="text-center">
                                            <span>{{ $licencia->nombre}}</span><br>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>