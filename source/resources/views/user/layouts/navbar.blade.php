<nav class="navbar navbar-expand-lg navbar-light bg-light " >
  <div class="navbar-brand navbar-logo">

    <a href="index-1.htm">
      <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="Theme-Logo">
    </a>
    <a class="mobile-menu" id="mobile-collapse" href="#!" style="color: #fff;">
      <i class="feather icon-menu"></i>
    </a>
    <button style="float: right;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="nav navbar-nav">
      <li class="nav-item {{ \Request::route()->getname() == 'user.home' ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('user.home') }}">
          <span class="pcoded-micon"><i class="feather icon-home"></i></span>
          <span class="">Dashboard</span>
        </a>
      </li>
      <li class="nav-item {{ \Request::route()->getname() == 'user.groups' ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('user.groups') }}">
          <span class="pcoded-micon"><i class="feather icon-home"></i></span>
          <span class="">Groups</span>
        </a>
      </li>
      <li class="nav-item {{ \Request::route()->getname() == 'user.templates' ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('user.templates') }}">
          <span class="pcoded-micon"><i class="feather icon-home"></i></span>
          <span class="">Templates</span>
        </a>
      </li>
      <li class="nav-item {{ \Request::route()->getname() == 'user.messages' ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('user.messages') }}">
          <span class="pcoded-micon"><i class="feather icon-envelope-open"></i></span>
          <span class="">SMS</span>
        </a>
      </li>
      <li class="nav-item {{ \Request::route()->getname() == 'user.profile' ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('user.profile') }}">
          <span class="pcoded-micon"><i class="feather icon-user"></i></span>
          <span class="">Profile</span>
        </a>
      </li>
      <li class="nav-item {{ \Request::route()->getname() == 'user.settings' ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('user.settings') }}">
          <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
          <span class="">Settings</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
          <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
          <span class="pcoded-mtext">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</nav>