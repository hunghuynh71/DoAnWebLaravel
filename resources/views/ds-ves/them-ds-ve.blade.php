@extends('layout.master')

@section('title','Thêm danh sách vé')

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
          <h1>Thêm danh sách vé</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thêm danh sách vé</li>
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
                <label for="khachDatVe">Khách đặt vé</label>
                <select name="khachDatVe" class="form-control custom-select">
                  <option selected disabled>Chọn khách đặt vé</option>
                  @foreach($khach_dat_ves as $kdv)
                  <option value="{{$kdv->id}}">{{$kdv->ten_kdv}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="chiNhanh">Chi nhánh</label>
                <select name="chiNhanh" class="form-control custom-select">
                  <option selected disabled>Chọn chi nhánh</option>
                  @foreach($chi_nhanhs as $cn)
                  <option value="{{$cn->id}}">{{$cn->ten_cn}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="slVe">Số vé</label>
                <input type="number" name="slVe" class="form-control">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{url('ds-ve/ds-ve')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Thêm danh sách vé" class="btn btn-success float-right">
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