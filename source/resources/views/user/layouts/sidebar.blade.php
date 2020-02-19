@if(in_array(\Request::route()->getName(), ['user.groups', 'user.group.create', 'user.group.edit', 'user.group.view',
'user.templates', 'user.template.create', 'user.template.edit',
'user.messages', 'user.message.create', 'user.message.edit']))
<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">

            @if(in_array(\Request::route()->getName(), ['user.groups', 'user.group.create', 'user.group.edit', 'user.group.view']))
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
            @endif

            @if(in_array(\Request::route()->getName(), ['user.templates', 'user.template.create', 'user.template.edit']))
            <li class="{{ in_array(\Request::route()->getname(), ['user.template.create']) ? 'active' : ''}}">
                <a href="{{ route('user.template.create') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Create</span>
                </a>
            </li>
            <li class="{{ in_array(\Request::route()->getname(), ['user.templates', 'user.template.edit']) ? 'active' : ''}}">
                <a href="{{ route('user.templates') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Manage</span>
                </a>
            </li>
            @endif

            @if(in_array(\Request::route()->getName(), ['user.messages', 'user.message.create', 'user.message.edit']))
            <li class="{{ in_array(\Request::route()->getname(), ['user.message.create']) ? 'active' : ''}}">
                <a href="{{ route('user.message.create') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Create</span>
                </a>
            </li>
            <li class="{{ in_array(\Request::route()->getname(), ['user.messages', 'user.message.edit']) ? 'active' : ''}}">
                <a href="{{ route('user.messages') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Manage</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</nav>

@endif