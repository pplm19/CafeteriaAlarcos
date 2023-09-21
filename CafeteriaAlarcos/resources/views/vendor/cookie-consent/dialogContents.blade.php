<div class="js-cookie-consent cookie-consent fixed-bottom rounded-top rounded-0 shadow-lg alert text-center mb-0"
    role="alert">
    <h2 class="alert-heading text-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="1.75rem" height="1.75rem" fill="currentColor" class="bi bi-cookie"
            viewBox="0 0 16 16">
            <path
                d="M6 7.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm4.5.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm-.5 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
            <path
                d="M8 0a7.963 7.963 0 0 0-4.075 1.114c-.162.067-.31.162-.437.28A8 8 0 1 0 8 0Zm3.25 14.201a1.5 1.5 0 0 0-2.13.71A7.014 7.014 0 0 1 8 15a6.967 6.967 0 0 1-3.845-1.15 1.5 1.5 0 1 0-2.005-2.005A6.967 6.967 0 0 1 1 8c0-1.953.8-3.719 2.09-4.989a1.5 1.5 0 1 0 2.469-1.574A6.985 6.985 0 0 1 8 1c1.42 0 2.742.423 3.845 1.15a1.5 1.5 0 1 0 2.005 2.005A6.967 6.967 0 0 1 15 8c0 .596-.074 1.174-.214 1.727a1.5 1.5 0 1 0-1.025 2.25 7.033 7.033 0 0 1-2.51 2.224Z" />
        </svg> Cookies
    </h2>

    <p class="cookie-consent__message text-white">
        {{ __('cookie-consent::texts.message') }}
    </p>

    <a class="js-cookie-consent-agree cookie-consent__agree btn btn-theme col-12 col-md-auto mx-auto text-white text-decoration-none mb-3"
        title="{{ __('cookie-consent::texts.agree') }}">
        <strong>{{ __('cookie-consent::texts.agree') }}</strong>
    </a>
</div>
