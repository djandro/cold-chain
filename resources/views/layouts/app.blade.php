<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cold-chain web application">
    <meta name="author" content="Andraz Hostnik">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">

</head>
<body class="animsition">
    <div class="page-wrapper" id="app">

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="/images/icon/logo-white.png" alt="{{ config('app.name', 'Laravel') }}" />
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                @else
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="/images/icon/avatar-big-01.jpg" alt="{{ Auth::user()->name }}" />
                    </div>
                    <h4 class="name">{{ Auth::user()->name }}</h4>
                    <a class="text-center" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @endguest
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li class="{{ setActive('/', 'active') }}">
                            <a href="{{ url('/') }}">
                                <i class="fas fa-copy"></i>Dashboard
                            </a>
                        </li>
                        <li class="{{ setActive('import', 'active') }}">
                            <a href="{{ url('import') }}">
                                <i class="fas fa-tachometer-alt"></i>Import data
                            </a>
                        </li>
                        <li class="{{ setActive('records', 'active') }} has-sub">
                            <a class="js-arrow" href="{{ url('records') }}">
                                <i class="fas fa-chart-bar"></i>Display and analysis
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/records">
                                        <i class="zmdi zmdi-format-list-bulleted"></i>Records
                                    </a>
                                </li>
                                <!--<li>
                                    <a href="#">
                                        <i class="zmdi zmdi-notifications"></i>Notifications
                                    </a>
                                </li>-->
                            </ul>
                        </li>
                        <li class="{{ setActive('settings', 'active') }} has-sub">
                            <a class="js-arrow" href="{{ url('settings') }}">
                                <i class="zmdi zmdi-settings"></i>Settings
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="#">
                                        <i class="fab fa-flickr"></i>Products</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fas fa-map-marker-alt"></i>Locations</a>
                                </li>
                                <li><a href="#">
                                        <i class="zmdi zmdi-account"></i>Account</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <div class="page-container2">

            <!-- HEADER DESKTOP-->
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">

                                {{ Breadcrumbs::render() }}

                                <!-- END BREADCRUMB-->
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="progress header-progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <main class="py-4 m-t-80">
                @yield('content')
            </main>

            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright &#9400; 2019 FRI & Andraz Hostnik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/vendor.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    @yield('scripts')

</body>
</html>
