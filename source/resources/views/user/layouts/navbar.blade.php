<nav class="navbar header-navbar pcoded-header">
  <div class="navbar-wrapper">

    <div class="navbar-logo">
      <a class="mobile-menu" id="mobile-collapse" href="#!">
        <i class="feather icon-menu"></i>
      </a>
      <a href="index-1.htm">
        <img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="Theme-Logo">
      </a>
      <a class="mobile-options">
        <i class="feather icon-more-horizontal"></i>
      </a>
    </div>

    <div class="navbar-container container-fluid">
      <ul class="nav-right">
        <li class="user-profile header-notification">
          <div class="dropdown-primary dropdown">
            <div class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('assets/images/avatar-4.jpg') }}" class="img-radius" alt="User-Profile-Image">
              <span>John Doe</span>
              <i class="feather icon-chevron-down"></i>
            </div>
            <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
              <li>
                <a href="{{ route('user.settings') }}">
                  <i class="feather icon-settings"></i> Settings
                </a>
              </li>
              <li>
                <a href="{{ route('user.profile') }}">
                  <i class="feather icon-user"></i> Profile
                </a>
              </li>
              <li>
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
        </li>
      </ul>
    </div>
  </div>
</nav>