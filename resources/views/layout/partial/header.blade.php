<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav" id="clock">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="mt-2">
        <span class="wrap-time">
          <span class="time-unit">
              <span class="large day">Mon</span>
              <span class="small">DAY</span>
          </span>
          <span class="time-unit">
              <span class="large hours">00</span>
              <span class="small">HRS</span>
          </span>
          <span class="separator">:</span>
          <span class="time-unit">
              <span class="large minutes">00</span>
              <span class="small">MIN</span>
          </span>
          <span class="separator">:</span>
          <span class="time-unit">
              <span class="large seconds">00</span>
              <span class="small">SEC</span>
          </span>
          <span class="time-unit">
              <span class="large period">AM</span>
              {{-- <span class="small">PERIOD</span> --}}
          </span>
      </span>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <div class="async-content async-ghost" id="table_badge_icon_notifications" data-url="{{route('admin.reload-badge-icon-notifiactions')}}"></div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          
          <div class="async-content async-ghost" id="table_notifications" data-url="{{route('admin.reload-notifiactions')}}"></div>
          
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->