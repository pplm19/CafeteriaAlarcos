@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js', 'resources/js/selectModal.js', 'resources/js/orderTable.js'])
@endPushOnce

<script>
    const elementsList = {{ Js::from($dishTypes) }};
    const selected = {{ Js::from($menu['dishes']) }}

    const htmlTemplate = ({
        id,
        name,
        type_id
    }) => {
        return `
            <tr class="selectable">
                <td class="text-center w-10">
                    <input type="checkbox" name="dishes[]"
                        value="${id}"
                        data-category="${type_id}"
                        class="form-check-input remove-checkbox" checked>
                </td>
                <td>${name}</td>
                <td class="text-center w-10 orderable-buttons">
                    <i class="bi bi-chevron-up d-block orderable-up"></i>
                    <i
                        class="bi bi-chevron-down d-block orderable-down"></i>
                </td>
            </tr>
        `;
    };

    const getElementCategoryId = (element) => element.type_id
</script>

@section('pagetitle')
    <a href="{{ route('menus.index') }}" class="btn btn-secondary">
        <i class="bi bi-backspace me-1"></i> Volver
    </a>
@endsection

@section('content')
    <div class="justify-content-center row">
        <div class="col-11 col-md-10 col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                        Editar menú
                    </h3>

                    <form action="{{ route('menus.update', $menu['id']) }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <div class="form-floating mt-3">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ $menu['name'] }}"
                                placeholder="Nombre" required maxlength="255" autofocus />
                            <label for="name">Nombre</label>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="text" name="description" id="description"
                                class="form-control @error('description') is-invalid @enderror"
                                value="{{ $menu['description'] }}" placeholder="Descripción" maxlength="255" />
                            <label for="description">Descripción</label>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="number" name="price" id="price"
                                class="form-control @error('price') is-invalid @enderror" value="{{ $menu['price'] }}"
                                placeholder="Precio" min="0.0" max="9999.99" step="0.01" />
                            <label for="price">Precio</label>

                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-control mt-3">
                            <p class="mb-3">Platos</p>

                            <div class="mb-3 table-responsive">
                                <table class="table table-bordered table-striped table-hover align-middle mb-0">
                                    <tbody class="orderable" id="select_list">
                                        <tr class="show-empty">
                                            <td colspan="2" class="text-center">
                                                No hay ningún plato seleccionado
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#selectModal">
                                Seleccionar platos
                            </button>

                            @error('dishes')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-theme">
                                <i class='bx bxs-edit-alt'></i> Editar menú
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="selectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="selectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="selectModalLabel">Selecciona los platos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- <div>
                            Search
                        </div> --}}
                    <div class="accordion" id="accordionSelect">
                        @foreach ($dishTypes as $dishType)
                            <div class="accordion-item">
                                <h2 class="accordion-header font-poppins" id="heading{{ $dishType[0]['type']['id'] }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $dishType[0]['type']['id'] }}" aria-expanded="true"
                                        aria-controls="collapse{{ $dishType[0]['type']['id'] }}">
                                        {{ $dishType[0]['type']['name'] }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $dishType[0]['type']['id'] }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $dishType[0]['type']['id'] }}">
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover align-middle mb-0">
                                                <tbody id="category_{{ $dishType[0]['type']['id'] }}">
                                                    @foreach ($dishType as $dish)
                                                        <tr class="selectable">
                                                            <td class="text-center w-10">
                                                                <input type="checkbox" name="dishes[]"
                                                                    id="select_{{ $dish['id'] }}"
                                                                    value="{{ $dish['id'] }}"
                                                                    data-category="{{ $dish['type']['id'] }}"
                                                                    class="form-check-input add-checkbox" checked>
                                                            </td>
                                                            <td>{{ $dish['name'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <div class="mt-3 table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0">
                            <tbody id="modal_select_list" class="orderable"></tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirm">Confirmar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
