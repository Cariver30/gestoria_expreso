<div class="mb-3 position-relative">
    <label for="task-assign-input" class="form-label">Entidades</label>

    <div class="avatar-group justify-content-center" id="assignee-member"></div>

    <div class="select-element" id="select-element">
        <button class="btn btn-light w-100 d-flex justify-content-between" type="button"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <span>Asignar a<b id="total-assignee" class="mx-1">0</b> entidad(es)</span> <i
                class="mdi mdi-chevron-down"></i>
        </button>
        <div class="dropdown-menu w-100">
            <div data-simplebar style="max-height: 172px">
                <ul class="list-unstyled mb-0 assignto-list">
                    @if (count($entidades) == 0)
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                Sin entidades disponibles
                            </a>
                        </li>
                    @else
                        @foreach ($entidades as $entidad)
                            @if ($entidad->id > 1)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="avatar-xs flex-shrink-0 me-2">
                                            <img src="{{ asset('images/sede.jpg')}}"  alt="" id="{{$entidad->id}}" class="img-fluid rounded-circle" />
                                        </div>
                                        <div class="flex-grow-1">{{ $entidad->nombre}}</div>
                                    </a>
                                </li>  
                            @endif
                        @endforeach
                    @endif  
                </ul>
            </div>
        </div>
    </div>
</div>