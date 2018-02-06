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
        <nav class="navbar navbar-expand-md fixed-top bg-dark">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggler collapsed float-left" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        {{-- <li style="height: 1px; margin-left:100px;">
                        </li> --}}
                    @if (Auth::user() && !Auth::user()->visitor())
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}"><i class="fa fa-cog fa-tachometer"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/member') }}"><i class="fa fa-cog fa-users"></i> Members</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/event') }}"><i class="fa fa-cog fa-list"></i>  Events</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/event/calendar') }}"><i class="fa fa-cog fa-calendar"></i> Calendar</a>
                        </li>
                    @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            {{-- <li><a href="{{ route('register') }}">Register</a></li> --}}
                        @else
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li class="dropdown-item">
                                        <a href="{{ url('/member/'.Auth::user()->id.'/edit') }}"><i class="fa fa-cog fa-fw"></i> Profile</a></li>
                                    @can ('administer')
                                    <li class="dropdown-item">
                                        <a href="{{ url('/administrator') }}"><i class="fa fa-th-large fa-fw"></i> Administrator</a></li>
                                    @endcan
                                    <li class="dropdown-item">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
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
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
