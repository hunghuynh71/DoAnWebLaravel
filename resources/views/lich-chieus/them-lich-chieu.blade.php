@extends('layout.master')

@section('title','Thêm lịch chiếu')

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
          <h1>Thêm lịch chiếu</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thêm lịch chiếu</li>
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
                <label for="phim">Phim</label>
                <select name="phim" class="form-control custom-select">
                  <option selected disabled>Chọn phim</option>
                  @foreach($phims as $p)
                  <option value="{{$p->id}}">{{$p->ten_phim}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="khungTGChieu">Khung thời gian chiếu</label>
                <select name="khungTGChieu" class="form-control custom-select">
                  <option selected disabled>Chọn khung thời gian chiếu</option>
                  @foreach($khung_tg_chieus as $ktgc)
                  <option value="{{$ktgc->id}}">{{$ktgc->tg_chieu}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="ngayChieu">Ngày chiếu</label>
                <input type="date" name="ngayChieu" class="form-control">
              </div>
              <div class="form-group">
                <label for="rap">Rạp</label>
                <select name="rap" class="form-control custom-select">
                  <option selected disabled>Chọn rạp</option>
                  @foreach($raps as $r)
                  <option value="{{$r->id}}">{{$r->ten_rap}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{route('lich-chieu.getLichChieus')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Thêm lịch chiếu" class="btn btn-success float-right">
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