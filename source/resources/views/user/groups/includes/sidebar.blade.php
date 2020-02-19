<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="{{ in_array(\Request::route()->getname(), ['user.group.create']) ? 'active' : ''}}">
                <a href="{{ route('user.group.create') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Create</span>
                </a>
            </li>
            <li class="{{ in_array(\Request::route()->getname(), ['user.groups', 'user.group.edit', 'user.group.view']) ? 'active' : ''}}">
                <a href="{{ route('user.groups') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Manage</span>
                </a>
            </li> 
        </ul>
    </div>
</nav>