<nav class="navbar-sidebar2">
    <ul class="list-unstyled navbar__list">
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
</nav>