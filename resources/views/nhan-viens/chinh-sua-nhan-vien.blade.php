@extends('layout.master')

@section('title','Chỉnh sửa nhân viên')

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
          <h1>Chỉnh sửa nhân viên</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa nhân viên</li>
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
                <input type="text" name="tenNhanVien" class="form-control" value="{{$nhan_vien->ten_nv}}">
              </div>
              <div class="form-group">
                <label for="cmnd">CMND</label>
                <input type="text" name="cmnd" class="form-control" value="{{$nhan_vien->cmnd}}">
              </div>
              <div class="form-group">
                <label for="sdt">SĐT</label>
                <input type="text" name="sdt" class="form-control" value="{{$nhan_vien->sdt}}">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{$nhan_vien->email}}">
              </div>
              <div class="form-group">
                <label for="matKhau">Mật khẩu</label>
                <input type="password" name="matKhau" class="form-control" value="{{$nhan_vien->password}}">
              </div>
              <div class="form-group">
                <label for="ngayVaoLam">Ngày vào làm</label>
                <input type="date" name="ngayVaoLam" class="form-control" value="{{$nhan_vien->ngay_vao_lam}}">
              </div>
              <div class="form-group">
                <label for="gioiTinh">Giới tính</label>
                @if($nhan_vien->gioi_tinh==1)
                <div>
                  <label for="">Nam</label>
                  <input type="radio" checked="checked" name="gioiTinh" class="form-control" value="1">                  
                </div>
                <div>
                  <label for="">Nữ</label>
                  <input type="radio" name="gioiTinh" class="form-control" value="0">                  
                </div>
                @else
                <div>
                  <label for="">Nam</label>
                  <input type="radio" name="gioiTinh" class="form-control" value="1">                  
                </div>
                <div>
                  <label for="">Nữ</label>
                  <input type="radio" checked="checked" name="gioiTinh" class="form-control" value="0">                  
                </div>
                @endif
              </div>
              <div class="form-group">
                <label for="diaChi">Địa chỉ</label>
                <input type="text" name="diaChi" class="form-control" value="{{$nhan_vien->dia_chi}}">
              </div>
              <div class="form-group">
                <label for="gioiTinh">Tình trạng</label>
                @if($nhan_vien->dang_lam==1)
                <div>
                  <label for="">Đang làm</label>
                  <input type="radio" checked="checked" name="dangLam" class="form-control" value="1">                  
                </div>
                <div>
                  <label for="">Đã nghỉ</label>
                  <input type="radio" name="dangLam" class="form-control" value="0">                  
                </div>
                @else
                <div>
                  <label for="">Đang làm</label>
                  <input type="radio" name="dangLam" class="form-control" value="1">                  
                </div>
                <div>
                  <label for="">Đã nghỉ</label>
                  <input type="radio" checked="checked" name="dangLam" class="form-control" value="0">                  
                </div>
                @endif
              </div>
              <div class="form-group">
                <label for="quyen">Quyền</label>
                <select name="quyen" class="form-control custom-select">
                  <option selected disabled>Chọn quyền</option>
                  @foreach($quyens as $q)
                  @if($q->id==$nhan_vien->quyen)
                  <option selected="selected" value="{{$q->id}}">{{$q->ten_quyen}}</option>
                  @else
                  <option value="{{$q->id}}">{{$q->ten_quyen}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{route('nhan-vien.getNhanViens')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Chỉnh sửa nhân viên" class="btn btn-success float-right">
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