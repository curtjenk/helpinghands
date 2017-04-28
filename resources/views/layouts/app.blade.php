<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Legacy Builders') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/gsdk.css') }}" rel="stylesheet"> --}}

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li style="height: 1px; margin-left:100px;">
                        </li>
                        {{-- @if (Auth::user())
                        <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        @endif --}}
                    @if (Auth::user())
                        <li>
                            <a href="{{ url('/member') }}">Members</a>
                        </li>
                    @endif
                    @can ('list-events')
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Service/Events <span class="caret"></span>
                            </a>
                        {{-- <li><a href="{{ url('/event') }}">Service/Events</a> --}}
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/event') }}"><i class="fa fa-cog fa-list"></i>  List Events</a></li>
                                <li><a href="{{ url('/event/calendar') }}"><i class="fa fa-cog fa-calendar"></i> Calendar</a></li>
                            @can ('create-event')
                                <li><a href="{{ url('/event/create') }}"><i class="fa fa-cog fa-plus"></i>  Create Event</a></li>
                            @endcan
                            </ul>
                        </li>
                    @endcan
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/member/'.Auth::user()->id.'/edit') }}"><i class="fa fa-cog fa-fw"></i> Profile</a></li>
                                    @can ('administer')
                                    <li><a href="{{ url('/administrator') }}"><i class="fa fa-th-large fa-fw"></i> Administrator</a></li>
                                    @endcan
                                    <li>
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

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
