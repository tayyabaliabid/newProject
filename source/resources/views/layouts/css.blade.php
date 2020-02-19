
  <!-- Favicon icon -->
  <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
  <!-- Required Fremwork -->
  <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap/css/bootstrap.min.css') }}">
  <!-- feather Awesome -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/feather/css/feather.css') }}">
  <!-- Style.css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">

  <style>
    .navbar{
      background-color:#404E67 !important; 
      position: fixed; 
      z-index: 1030;
      width:100%;
    }
    .navbar-light .navbar-nav .active>.nav-link {
      color: #FE8A7D !important;
    }

    .pcoded-main-container {
      padding-top: 58px !important;
    }

    .navbar-light .navbar-nav .nav-link {
      color: rgb(255, 255, 255) !important;
    } 

    @media (min-width: 992px) {
      .navbar-expand-lg .navbar-collapse {
        position: absolute !important;
        right: 40px !important;
      }
    }

    .pcoded .pcoded-navbar[navbar-theme="theme1"] .pcoded-item>li.active>a,
    .pcoded .pcoded-navbar[navbar-theme="theme1"] .pcoded-item>li.active>a>.pcoded-micon i {
      background: #404E67;
      color: #FE8A7D;
      border-bottom-color: #404E67;
    }

    .pcoded[theme-layout="vertical"] .pcoded-navbar .pcoded-item>li>a .pcoded-mtext {
      top: 14px;
    }
  </style>
