@extends('layout.master')

@section('title','Thêm nhân viên')

@section('css')
<!-- Font Awesome -->
<link rel="stylesheet" href="sources/plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="sources/dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Thêm nhân viên</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thêm nhân viên</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <form method="post" action="">
          <!--them token-->
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Thông tin</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="tenNhanVien">Tên nhân viên</label>
                <input type="text" name="tenNhanVien" class="form-control">
              </div>
              <span class="error-message">{{$errors->first('tenNhanVien')}}</span>
              <div class="form-group">
                <label for="cmnd">CMND</label>
                <input type="text" name="cmnd" class="form-control">
              </div>
              <span class="error-message">{{$errors->first('cmnd')}}</span>
              <div class="form-group">
                <label for="sdt">SĐT</label>
                <input type="text" name="sdt" class="form-control">
              </div>
              <span class="error-message">{{$errors->first('sdt')}}</span>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control">
              </div>
              <span class="error-message">{{$errors->first('email')}}</span>
              <div class="form-group">
                <label for="matKhau">Mật khẩu</label>
                <input type="password" name="matKhau" class="form-control">
              </div>
              <span class="error-message">{{$errors->first('matKhau')}}</span>
              <div class="form-group">
                <label for="ngayVaoLam">Ngày vào làm</label>
                <input type="date" name="ngayVaoLam" class="form-control">
              </div>
              <span class="error-message">{{$errors->first('ngayVaoLam')}}</span>
              <div class="form-group">
                <label for="gioiTinh">Giới tính</label>
                <div>
                  <label for="">Nam</label>
                  <input type="radio" name="gioiTinh" class="form-control" value="1">                  
                </div>
                <div>
                  <label for="">Nữ</label>
                  <input type="radio" name="gioiTinh" class="form-control" value="0">                  
                </div>
              </div>
              <span class="error-message">{{$errors->first('gioiTinh')}}</span>
              <div class="form-group">
                <label for="diaChi">Địa chỉ</label>
                <input type="text" name="diaChi" class="form-control">
              </div>
              <span class="error-message">{{$errors->first('diaChi')}}</span>
              <div class="form-group">
                <label for="quyen">Quyền</label>
                <select name="quyen" class="form-control custom-select">
                  <option selected disabled>Chọn quyền</option>
                  @foreach($quyens as $q)
                  <option value="{{$q->id}}">{{$q->ten_quyen}}</option>
                  @endforeach
                </select>
              </div>
              <span class="error-message">{{$errors->first('quyen')}}</span>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{route('nhan-vien.getNhanViens')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Thêm nhân viên" class="btn btn-success float-right">
            </div>
            <!-- /.card-footer -->

          </div>
          <!-- /.card -->
        </form>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
@endsection

@section('js')
<!-- jQuery -->
<script src="sources/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="sources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="sources/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="sources/dist/js/demo.js"></script>
@endsection