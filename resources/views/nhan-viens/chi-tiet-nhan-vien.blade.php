@extends('layout.master')

@section('title','Chi tiết nhân viên')

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
          <h1>Chi tiết nhân viên</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Chi tiết nhân viên</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Thông tin khách đặt vé</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12 order-12 order-md-12">
          <h1 class="text-primary text-center">{{$nhan_vien->ten_nv}}</h1>
            <p>CMND: {{$nhan_vien->cmnd}}</p>
            <p>SĐT: {{$nhan_vien->sdt}}</p>
            <p>Email: {{$nhan_vien->email}}</p>
            <p>Mật khẩu: {{$nhan_vien->password}}</p>
            <p>Ngày vào làm: {{$nhan_vien->ngay_vao_lam}}</p>
            @if($nhan_vien->gioi_tinh==1)
            <p>Giới tính: Nam</p>
            @else
            <p>Giới tính: Nữ</p>
            @endif
            <p>Địa chỉ: {{$nhan_vien->dia_chi}}</p>
            @if($nhan_vien->dang_lam==1)
            <p>Tình trạng: Đang làm</p>
            @else
            <p>Tình trạng: Đã nghỉ việc</p>
            @endif
            <p>Quyền: {{$nhan_vien->quyen}}</p>
            <div class="text-center mt-5 mb-3">
              <a href="{{route('nhan-vien.editNhanVien',$nhan_vien->id)}}" class="btn btn-sm btn-primary">Chỉnh sửa</a>
              <a href="{{route('nhan-vien.getNhanViens') }}" class="btn btn-sm btn-warning">Thoát</a>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

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