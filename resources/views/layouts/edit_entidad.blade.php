<div class="mb-3 position-relative">
    <label for="task-assign-input" class="form-label">Entidades</label>

    <div class="avatar-group justify-content-center" id="usuario-entidad"></div>

    <div class="select-entidad" id="select-entidad">
        <button class="btn btn-light w-100 d-flex justify-content-between" type="button"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <span>Asignar a<b id="total-entidades" class="mx-1">0</b> entidad(es)</span> <i
                class="mdi mdi-chevron-down"></i>
        </button>
        <div class="dropdown-menu w-100">
            <div data-simplebar style="max-height: 172px">
                <ul class="list-unstyled mb-0 entidad-list">
                    @foreach ($entidades as $entidad)
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="avatar-xs avatar-xs-up flex-shrink-0 me-2">
                                    <img src="{{ asset('images/sede.jpg')}}"  alt="" id="{{$entidad->id}}" class="img-fluid rounded-circle" />
                                </div>
                                <div class="flex-grow-2">{{ $entidad->nombre}}</div>
                            </a>
                        </li>
                    @endforeach  
                </ul>
            </div>
        </div>
    </div>
</div>