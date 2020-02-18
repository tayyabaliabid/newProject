<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ \Request::route()->getname() == 'admin.home' ? 'active' : ''}}">
                <a href="{{ route('admin.home') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
            <li class="pcoded-hasmenu {{ in_array(\Request::route()->getname(), ['admin.users', 'admin.user.create', 'admin.user.edit']) ? 'pcoded-trigger' : ''}} ">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Users</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ in_array(\Request::route()->getname(), ['admin.user.create']) ? 'active' : ''}}">
                        <a href="{{ route('admin.user.create') }}">
                            <span class="pcoded-mtext">Create</span>
                        </a>
                    </li>
                    <li class="{{ in_array(\Request::route()->getname(), ['admin.users', 'admin.user.edit']) ? 'active' : ''}}">
                        <a href="{{ route('admin.users') }}">
                            <span class="pcoded-mtext">Manage</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu {{ in_array(\Request::route()->getname(), ['admin.numbers', 'admin.number.create', 'admin.number.edit', 'admin.number.search']) ? 'pcoded-trigger' : ''}} ">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Numbers</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ in_array(\Request::route()->getname(), ['admin.number.create']) ? 'active' : ''}}">
                        <a href="{{ route('admin.number.create') }}">
                            <span class="pcoded-mtext">Search</span>
                        </a>
                    </li>
                    <li class="{{ in_array(\Request::route()->getname(), ['admin.numbers', 'admin.number.edit', 'admin.number.search']) ? 'active' : ''}}">
                        <a href="{{ route('admin.numbers') }}">
                            <span class="pcoded-mtext">Manage</span>
                        </a>
                    </li>
                </ul>
            </li> 
            <li class="{{ in_array(\Request::route()->getname(), ['admin.profile']) ? 'active' : ''}}">
                <a href="{{ route('admin.profile') }}">
                    <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                    <span class="pcoded-mtext">Profile</span>
                </a>
            </li>
            <li class="{{ in_array(\Request::route()->getname(), ['admin.settings']) ? 'active' : ''}}">
                <a href="{{ route('admin.settings') }}">
                    <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                    <span class="pcoded-mtext">Settings</span>
                </a>
            </li>
            <li class="">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> 
                    <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                    <span class="pcoded-mtext">logout</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>