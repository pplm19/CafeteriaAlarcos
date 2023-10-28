<div id="alerts" class="position-fixed w-100 row d-flex flex-column align-items-center mt-3">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-xxl-4"
            role="alert">
            {{ __(session('success')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-xxl-4"
            role="alert">
            {{ __(session('warning')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

{{-- email.blade.php --}}
<div class="modal fade" id="statusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-3 mb-0" id="statusModalLabel">
                    <i class="bi bi-info-circle me-1" style="position: relative; top: 2px;"></i> Info
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">{{ __(session('status')) }}</div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-3 mb-0 text-danger" id="errorModalLabel">
                    <i class="bi bi-exclamation-circle me-1" style="position: relative; top: 2px;"></i> Ha ocurrido un
                    error
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{ __(session('error')) }}
                @if ((request()->is('register') || request()->is('admin/users/create')) && $errors->has('email'))
                    {{ __($errors->first('email')) }}
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
