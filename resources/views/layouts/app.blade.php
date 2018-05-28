<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'M.E.') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
    <div id="app">
        @php
            $user = Auth::user();
        @endphp

        <nav-top
            :can-list-events="!!{{ isset($user) && $user->can('list-events') ? 1 : 0 }}"
            :can-list-members="!!{{ isset($user) && $user->can('list-users') ? 1 : 0 }}"
            :can-administer="!!{{ isset($user) && $user->can('administer') ? 1 : 0 }}"
            :is-visitor="!!{{ isset($user) && $user->can('visitor') ? 1 : 0 }}"
            :is-super-user="!!{{ isset($user) && $user->can('superuser') ? 1 : 0 }}"
        ></nav-top>

        <div class="container-fluid">
            @yield('content' )
        </div>

        {{-- <nav-footer></nav-footer> --}}
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="errorModal">
       <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Error</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button id="error_modal_button_ok" type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
