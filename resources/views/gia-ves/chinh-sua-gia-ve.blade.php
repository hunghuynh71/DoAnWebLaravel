@extends('layout.master')

@section('title','Chỉnh sửa giá vé')

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
          <h1>Chỉnh sửa giá vé</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa giá vé</li>
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
                <label for="loaiGhe">Loại ghế</label>
                <select name="loaiGhe" class="form-control custom-select">
                  <option selected disabled>Chọn loại ghế</option>
                  @foreach($loai_ghes as $lg)
                  @if($lg->id==$gia_ve->loai_ghe_id)
                  <option value="{{$lg->id}}" selected="selected">{{$lg->ten_lg}}</option>
                  @else
                  <option value="{{$lg->id}}">{{$lg->ten_lg}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="dinhDang">Định dạng</label>
                <select name="dinhDang" class="form-control custom-select">
                  <option selected disabled>Chọn định dạng</option>
                  @foreach($dinh_dangs as $dd)
                  @if($dd->id==$gia_ve->dinh_dang_id)
                  <option value="{{$dd->id}}" selected="selected">{{$dd->ten_dd}}</option>
                  @else
                  <option value="{{$dd->id}}">{{$dd->ten_dd}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="khungTGChieu">Khung thời gian chiếu</label>
                <select name="khungTGChieu" class="form-control custom-select">
                  <option selected disabled>Chọn khung thời gian chiếu</option>
                  @foreach($khung_tg_chieus as $ktgc)
                  @if($ktgc->id==$gia_ve->khung_tg_chieu_id)
                  <option value="{{$ktgc->id}}" selected="selected">{{$ktgc->tg_chieu}}</option>
                  @else
                  <option value="{{$ktgc->id}}">{{$ktgc->tg_chieu}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="giaVe">Giá vé</label>
                <input type="text" name="giaVe" class="form-control" value="{{$gia_ve->gia}}">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{route('gia-ve.getGiaVes')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Chỉnh sửa giá vé" class="btn btn-success float-right">
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