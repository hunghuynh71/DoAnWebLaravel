@extends('layout.master')

@section('title','Thêm phim')

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
          <h1>Thêm vé</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thêm phim</li>
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
            <div class="alert alert-{{Session::get('flag')}}">{{Session::get('message')}}</div>
              <div class="form-group">
                <label for="lichChieu">Lịch chiếu</label>
                <select name="lichChieu" class="form-control custom-select">
                  <option selected disabled>Chọn lịch chiếu</option>
                  @foreach($lich_chieus as $lc)
                  <option value="{{$lc->id}}">{{$lc->id}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="ghe">Ghế</label>
                <select name="ghe" class="form-control custom-select">
                  <option selected disabled>Chọn ghế</option>
                  @foreach($ghes as $g)
                  <option value="{{$g->id}}">{{$g->id}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="giaVe">Gía vé</label>
                <select name="giaVe" class="form-control custom-select">
                  <option selected disabled>Chọn giá vé</option>
                  @foreach($gia_ves as $gv)
                  <option value="{{$gv->id}}">{{$gv->gia}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="dsVe">Danh sách vé</label>
                <select name="dsVe" class="form-control custom-select">
                  <option selected disabled>Chọn danh sách vé</option>
                  @foreach($ds_ves as $dsv)
                  <option value="{{$dsv->id}}">{{$dsv->id}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{url('ve/ve')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Thêm vé" class="btn btn-success float-right">
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