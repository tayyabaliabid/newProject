<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ \Request::route()->getname() == 'user.home' ? 'active' : ''}}">
                <a href="{{ route('user.home') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li> 
            <li class="pcoded-hasmenu {{ in_array(\Request::route()->getname(), ['user.groups', 'user.group.create', 'user.group.edit', 'user.group.view']) ? 'pcoded-trigger' : ''}} ">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Groups</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ in_array(\Request::route()->getname(), ['user.group.create']) ? 'active' : ''}}">
                        <a href="{{ route('user.group.create') }}">
                            <span class="pcoded-mtext">Create</span>
                        </a>
                    </li>
                    <li class="{{ in_array(\Request::route()->getname(), ['user.groups', 'user.group.edit', 'user.group.view']) ? 'active' : ''}}">
                        <a href="{{ route('user.groups') }}">
                            <span class="pcoded-mtext">Manage</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu {{ in_array(\Request::route()->getname(), ['user.templates', 'user.template.create', 'user.template.edit', 'user.template.view']) ? 'pcoded-trigger' : ''}} ">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-mail"></i></span>
                    <span class="pcoded-mtext">Templates</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ in_array(\Request::route()->getname(), ['user.template.create']) ? 'active' : ''}}">
                        <a href="{{ route('user.template.create') }}">
                            <span class="pcoded-mtext">Create</span>
                        </a>
                    </li>
                    <li class="{{ in_array(\Request::route()->getname(), ['user.templates', 'user.template.edit', 'user.template.view']) ? 'active' : ''}}">
                        <a href="{{ route('user.templates') }}">
                            <span class="pcoded-mtext">Manage</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu {{ in_array(\Request::route()->getname(), ['user.messages', 'user.message.create', 'user.message.edit', 'user.message.view']) ? 'pcoded-trigger' : ''}} ">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-mail"></i></span>
                    <span class="pcoded-mtext">SMS</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ in_array(\Request::route()->getname(), ['user.message.create']) ? 'active' : ''}}">
                        <a href="{{ route('user.message.create') }}">
                            <span class="pcoded-mtext">Create</span>
                        </a>
                    </li>
                    <li class="{{ in_array(\Request::route()->getname(), ['user.messages', 'user.message.edit', 'user.message.view']) ? 'active' : ''}}">
                        <a href="{{ route('user.messages') }}">
                            <span class="pcoded-mtext">Manage</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ in_array(\Request::route()->getname(), ['user.profile']) ? 'active' : ''}}">
                <a href="{{ route('user.profile') }}">
                    <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                    <span class="pcoded-mtext">Profile</span>
                </a>
            </li>
            <li class="{{ in_array(\Request::route()->getname(), ['user.settings']) ? 'active' : ''}}">
                <a href="{{ route('user.settings') }}">
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