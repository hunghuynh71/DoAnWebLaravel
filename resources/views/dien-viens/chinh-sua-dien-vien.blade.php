@extends('layout.master')

@section('title','Chỉnh sửa diễn viên')

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
          <h1>Chỉnh sửa diễn viên</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa diễn viên</li>
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
                <label for="tenDienVien">Tên diễn viên</label>
                <input type="text" name="tenDienVien" class="form-control" value="{{$dien_vien->ten_dv}}">
              </div>
              <div class="form-group">
                <label for="ngaySinh">Địa chỉ</label>
                <input type="date" name="ngaySinh" class="form-control" value="{{$dien_vien->ngay_sinh}}">
              </div>
              <div class="form-group">
                <label for="chieuCao">Chiều cao</label>
                <input type="text" name="chieuCao" class="form-control" value="{{$dien_vien->chieu_cao}}">
              </div>
              <div class="form-group">
                <label for="quocGia">Quốc gia</label>
                <input type="text" name="quocGia" class="form-control" value="{{$dien_vien->quoc_gia}}">
              </div>
              <div class="form-group">
                <label for="tieuSu">Tiểu sử</label>
                <input type="text" name="tieuSu" class="form-control" value="{{$dien_vien->tieu_su}}">
              </div>
              <div class="form-group">
                <label for="hinhAnh">Hình ảnh</label>
                <input type="file" name="hinhAnh" class="form-control" value="{{$dien_vien->hinh_anh}}">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{route('dien-vien.getDienViens')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Chỉnh sửa diễn viên" class="btn btn-success float-right">
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