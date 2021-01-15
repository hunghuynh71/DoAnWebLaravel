<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="sources/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="sources/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <!--<a href="#" class="d-block">{{Auth::user()->name}}</a>-->

        <a href="#" class="d-block">
          @if(Session::has('user'))
          {{Session::get('user')->ten_nv}}
          @endif
        </a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Danh mục quản lý
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('phim/index')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>Phim</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('lich-chieu/index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Lịch chiếu</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('ve/index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vé</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('the-loai/index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thể loại phim</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('khach-dat-ve/khach-dat-ve')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Khách đặt vé</p>
              </a>
            </li>
            @if(Session::has('user'))
            @if(Session::get('user')->quyen_id==1)
            <li class="nav-item">
              <a href="{{url('nhan-vien/nhan-vien')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tài khoản quản trị</p>
              </a>
            </li>
            @endif
            @endif
            <li class="nav-item">
              <a href="{{url('binh-luan/binh-luan')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bình luận</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('chi-nhanh/chi-nhanh')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Chi nhánh</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('ghe/ghe')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ghế</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('loai-ghe/loai-ghe')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Loại ghế</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('dinh-dang/dinh-dang')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Định dạng</p>
              </a>
            </li>
            @if(Session::has('user'))
            @if(Session::get('user')->quyen_id==1)
            <li class="nav-item">
              <a href="{{url('quyen/quyen')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Quyền</p>
              </a>
            </li>
            @endif
            @endif
            <li class="nav-item">
              <a href="{{url('rap-phim/rap-phim')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Rạp phim</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('gia-ve/index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Giá vé</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('khung-tg-chieu/khung-tg-chieu')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Khung thời gian chiếu</p>
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="{{route('dang-xuat')}}" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Đăng xuất
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
© 2021 GitHub, Inc.