@extends('layouts.admin')

@pushOnce('scripts')
    @vite(['resources/js/bootstrapValidation.js', 'resources/js/selectModal.js'])
@endPushOnce

<script>
    const elementsList = {{ Js::from($ingredientTypes) }};
    const selected = {{ Js::from($dish['ingredients']) }};

    const htmlTemplate = ({
        id,
        name,
        i_category_id
    }) => {
        return `
            <tr class="selectable">
                <td class="text-center w-10">
                    <input type="checkbox" name="ingredients[]"
                        value="${id}"
                        data-category="${i_category_id}"
                        class="form-check-input remove-checkbox" checked>
                </td>
                <td>${name}</td>
            </tr>
        `;
    };

    const getElementCategoryId = (element) => element.i_category_id
</script>

@section('pagetitle')
    <a href="{{ route('dishes.index') }}" class="btn btn-secondary">
        <i class="bi bi-backspace me-1"></i> Volver
    </a>
@endsection

@section('content')
    <div class="justify-content-center row">
        <div class="col-11 col-md-10 col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">
                        Editar plato
                    </h3>

                    <form action="{{ route('dishes.update', $dish['id']) }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="form-floating mt-3">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ $dish['name'] }}"
                                placeholder="Nombre" required maxlength="255" autofocus />
                            <label for="name">Nombre</label>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-control mt-3">
                            <label for="imageFile" accept="image/*" class="form-label">Imagen</label>
                            <input type="file" name="imageFile" id="imageFile"
                                class="form-control @error('imageFile') is-invalid @enderror" />

                            @error('imageFile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-control mt-3">
                            <label for="recipe">Receta</label>
                            <input type="file" accept=".pdf" name="recipe" id="recipe"
                                class="form-control @error('recipe') is-invalid @enderror" value="{{ $dish['recipe'] }}" />

                            @error('recipe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-floating mt-3">
                            <input type="text" name="description" id="description"
                                class="form-control @error('description') is-invalid @enderror"
                                value="{{ $dish['description'] }}" placeholder="Descripción" maxlength="255" />
                            <label for="description">Descripción</label>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <select name="type_id" id="type_id" class="form-select @error('type_id') is-invalid @enderror"
                                required>
                                @foreach ($types as $type)
                                    <option value="{{ $type['id'] }}" @selected($dish['type_id'] == $type['id'])>
                                        {{ $type['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="type_id">Tipo de plato</label>

                            @error('type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-control mt-3">
                            <p class="mb-2">Categorías</p>

                            @error('dcategories')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                            @foreach ($dcategories as $dcategory)
                                <div class="form-check">
                                    <input type="checkbox" name="dcategories[]" id="dcategories"
                                        value="{{ $dcategory['id'] }}" class="form-check-input"
                                        @checked($dish['dcategories']->contains('id', $dcategory['id']))>
                                    <label for="dcategories" class="form-check-label">
                                        {{ $dcategory['name'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-control mt-3">
                            <p class="mb-3">Ingredientes</p>

                            <div class="mb-3 table-responsive">
                                <table class="table table-bordered table-striped table-hover align-middle mb-0">
                                    <tbody id="select_list">
                                        <tr class="show-empty">
                                            <td colspan="2" class="text-center">
                                                No hay ningún ingredient seleccionado
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#selectModal">
                                Seleccionar los ingredientes
                            </button>

                            @error('ingredients')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-control mt-3">
                            <p class="mb-2">Alérgenos</p>

                            @error('allergens')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                            @foreach ($allergens as $allergen)
                                <div class="form-check">
                                    <input type="checkbox" name="allergens[]" id="allergens" value="{{ $allergen['id'] }}"
                                        class="form-check-input" @checked($dish['allergens']->contains('id', $allergen['id']))>
                                    <label for="allergens" class="form-check-label">
                                        {{ $allergen['name'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-theme">
                                <i class='bx bxs-edit-alt'></i> Editar plato
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
                    <h1 class="modal-title fs-5" id="selectModalLabel">Selecciona los ingredients</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- <div>
                            Search
                        </div> --}}
                    <div class="accordion" id="accordionSelect">
                        @foreach ($ingredientTypes as $ingredientType)
                            <div class="accordion-item">
                                <h2 class="accordion-header font-poppins"
                                    id="heading{{ $ingredientType[0]['icategory']['id'] }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $ingredientType[0]['icategory']['id'] }}"
                                        aria-expanded="true"
                                        aria-controls="collapse{{ $ingredientType[0]['icategory']['id'] }}">
                                        {{ $ingredientType[0]['icategory']['name'] }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $ingredientType[0]['icategory']['id'] }}"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $ingredientType[0]['icategory']['id'] }}">
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-striped table-hover align-middle mb-0">
                                                <tbody id="category_{{ $ingredientType[0]['icategory']['id'] }}">
                                                    @foreach ($ingredientType as $ingredient)
                                                        <tr class="selectable">
                                                            <td class="text-center w-10">
                                                                <input type="checkbox" name="ingredients[]"
                                                                    id="select_{{ $ingredient['id'] }}"
                                                                    value="{{ $ingredient['id'] }}"
                                                                    data-category="{{ $ingredient['icategory']['id'] }}"
                                                                    class="form-check-input add-checkbox" checked>
                                                            </td>
                                                            <td>{{ $ingredient['name'] }}</td>
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
                            <tbody id="modal_select_list"></tbody>
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
