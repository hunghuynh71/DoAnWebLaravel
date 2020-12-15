@extends('layout.master')

@section('title','Chỉnh sửa ghế')

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
          <h1>Chỉnh sửa ghế</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa ghế</li>
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
                <label for="loaiGhe">Loại ghế</label>
                <select name="loaiGhe" class="form-control custom-select">
                  <option selected disabled>Chọn loại ghế</option>
                  @foreach($loai_ghes as $lg)
                  @if($lg->id==$ghe->loai_ghe_id)
                  <option value="{{$lg->id}}" selected="selected">{{$lg->ten_lg}}</option>
                  @else
                  <option value="{{$lg->id}}">{{$lg->ten_lg}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="rapPhim">Rạp phim</label>
                <select name="rapPhim" class="form-control custom-select">
                  <option selected disabled>Chọn rạp phim</option>
                  @foreach($rap_phims as $rp)
                  @if($rp->id==$ghe->rap_id)
                  <option value="{{$rp->id}}" selected="selected">{{$rp->ten_rap}}</option>
                  @else
                  <option value="{{$rp->id}}">{{$rp->ten_rap}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="trangThai">Trạng thái</label>
                <select name="tinhTrang" class="form-control custom-select">
                  <option selected disabled>Chọn tình trạng</option>
                  <option value="0">Trống</option>
                  <option value="1">Đã được đặt</option>
                  <option value="2">Bị hỏng hoặc đang bảo trì</option>
                </select>
                <!--@if($ghe->trang_thai==0)
                  <select name="trangThai" class="form-control custom-select">
                    <option selected disabled>Chọn trạng thái</option>
                    <option value="0" selected="selected">Trống</option>
                    <option value="1">Đã được đặt</option>
                    <option value="2">Bị hỏng hoặc đang bảo trì</option>
                  </select>
                @elseif($ghe->trang_thai==1)
                  <select name="trangThai" class="form-control custom-select">
                    <option selected disabled>Chọn trạng thái</option>
                    <option value="0">Trống</option>
                    <option value="1" selected="selected">Đã được đặt</option>
                    <option value="2">Bị hỏng hoặc đang bảo trì</option>
                  </select>
                @else
                  <select name="trangThai" class="form-control custom-select">
                    <option selected disabled>Chọn trạng thái</option>
                    <option value="0">Trống</option>
                    <option value="1">Đã được đặt</option>
                    <option value="2" selected="selected">Bị hỏng hoặc đang bảo trì</option>
                  </select>
                @endif-->
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{route('ghe.getGhes')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Chỉnh sửa ghế" class="btn btn-success float-right">
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