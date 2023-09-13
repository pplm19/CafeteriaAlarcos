<div id="alerts" class="position-fixed w-100 row d-flex flex-column align-items-center mt-3">
    {{-- email.blade.php --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-xxl-4"
            role="alert">
            {{ __(session('status')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-xxl-4"
            role="alert">
            {{ __(session('success')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-xxl-4"
            role="alert">
            {{ __(session('error')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- create.blade.php --}}
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-xxl-4"
            role="alert">
            {{ __($error) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show col-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-xxl-4"
            role="alert">
            {{ __(session('warning')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
