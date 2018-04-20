<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="apple-touch-icon" sizes="152x152" href="{{@full_asset('/images/icon/Icon-76@2x.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{@full_asset('/images/icon/Icon-76@2x.png')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ @full_asset('/css/app.css') }}" rel="stylesheet" type="text/css">
    @yield('styles')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'HTTP_URL' => (Request::secure()) ? secure_url('') : url(''),
        ]); ?>
    </script>
    <script src="{{ @full_asset('/js/bootstrap-native-v4.min.js') }}"></script>
    <script src="{{ @full_asset('/js/font-awesome.js') }}"></script>
</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ @full_url('/') }}">
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    @if (Auth::guest())
                        <li class="nav-item"><a class="nav-link {{ Request::path() === 'login' ? 'active' : '' }}" href="{{ url('/login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::path() === 'register' ? 'active' : '' }}" href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="nav-item {{ Request::path() === 'schedule/today' ? 'active' : '' }}"><a class="nav-link" href="{{ @full_url('/schedule/today') }}">Today's Schedule</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::path() === 'chores/list' ? 'active' : '' }}" href="{{ @full_url('/chores/list') }}">Chores</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::path() === 'workers/list' ? 'active' : '' }}" href="{{ @full_url('/workers/list') }}">Workers</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::path() === 'workers/add' ? 'active' : '' }}" href="{{ @full_url('/workers/add') }}">Add Worker</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::path() === 'chores/add' ? 'active' : '' }}" href="{{ @full_url('/chores/add') }}">Add Chore</a></li>
                    @endif
                </ul>

                <form id="logout-form" action="{{ @full_url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

                @if (!Auth::guest())
                    <span class="d-lg-none d-xl-inline navbar-text">
                        <a class="btn-sm btn-link" href="{{ @full_url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <span class="btn btn-sm btn-info">{{ Auth::user()->name }}</span>
                    </span>
                @endif
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
