<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="{{ url('/') }}">
                    <img src="/images/icon/logo-white.png" alt="{{ config('app.name', 'Laravel') }}" />
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                @if(Auth::user()->hasAnyRole(['admin', 'editor']))
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
                @endif
                <li class="{{ setActive('records', 'active') }} has-sub">
                    <a href="{{ url('records') }}">
                        <i class="fas fa-chart-bar"></i>Records
                    </a>
                </li>
                @if(Auth::user()->hasAnyRole(['admin', 'editor']))
                <li class="{{ setActive('settings', 'active') }}">
                    <a href="{{ url('settings') }}">
                        <i class="zmdi zmdi-settings"></i>Settings
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->