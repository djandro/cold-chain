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
            <a href="{{ url('records') }}">
                <i class="fas fa-chart-bar"></i>Records
            </a>
        </li>
        <li class="{{ setActive('settings', 'active') }}">
            <a href="{{ url('settings') }}">
                <i class="zmdi zmdi-settings"></i>Settings
            </a>
        </li>
    </ul>
</nav>