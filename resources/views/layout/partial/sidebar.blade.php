<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="font-weight-light text-center">SME Service</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 mb-3 d-flex">
        <div class="image">
          @if(Auth::user()->avatar == 'default.png' )
            <img src="{{ asset('assets/img/default.svg') }}" class="img-circle elevation-2" alt="User Image">
          @else
            <img src="{{ asset("storage/user/") . '/'.Auth::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
          @endif
        </div>
        <div class="info">
          <p class="d-block text-white">{{ Auth::user()->name }}</p>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="{{ Request::is('/') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>หน้าแรก</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.duration.index') }}" class="{{ Request::is('duration*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-clock"></i>
              <p>ระยะเวลา</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.customer.index') }}" class="{{ Request::is('customer*', 'deposit*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>ลูกค้า</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.withdraw.index') }}" class="{{ Request::is('withdraw*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-sort-amount-up-alt"></i>
              <p>ลูกค้าถอนเงิน</p>
            </a>
          </li><li class="nav-item">
            <a href="{{ route('admin.loan.index') }}" class="{{ Request::is('loan*') ? 'nav-link active' : 'nav-link' }}">
              <div class="async-content async-ghost" id="table_badge_icon_sidebar_notifications" data-url="{{route('admin.reload-badge-icon-sidebar-notifiactions')}}"></div>
              <i class="nav-icon fas fa-sort-amount-down-alt"></i>
              <p>ลูกค้ากู้เงิน</p>
            </a>
          </li><li class="nav-item">
            <a href="{{ route('admin.agreement.index') }}" class="{{ Request::is('agreement*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>ข้อตกลงกู้เงิน</p>
            </a>
          </li>
        </li><li class="nav-item">
          <a href="{{ route('admin.message.index') }}" class="{{ Request::is('message*') ? 'nav-link active' : 'nav-link' }}">
            <i class="nav-icon fas fa-envelope"></i>
            <p>ข้อความหน้าบ้าน</p>
          </a>
        </li>
          <li class="nav-item">
            <a href="{{ route('admin.user.index') }}" class="{{ Request::is('user*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>ผู้ดูแล่</p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                  รายงาน
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>รายงานสินเชื่อ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.report.withdraw') }}" class="{{ Request::is('/withdraw_report') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>รายงานการถอนเงิน</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#logoutModal">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>ออกจากระบบ</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>