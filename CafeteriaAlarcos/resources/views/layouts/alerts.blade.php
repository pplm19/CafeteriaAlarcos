<div id="alerts" class="position-fixed w-100 d-flex flex-column align-items-center mt-3">
    {{-- email.blade.php --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show w-35" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show w-35" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show w-35" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- create.blade.php --}}
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show w-35" role="alert">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show w-35" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
