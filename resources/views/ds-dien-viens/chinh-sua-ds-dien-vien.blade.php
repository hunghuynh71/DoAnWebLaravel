@extends('layout.master')

@section('title','Chỉnh sửa phim')

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
          <h1>Chỉnh sửa danh sách diễn viên</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa danh sách diễn viên</li>
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
                  @if($p->id==$dsdv->phim)
                  <option value="{{$p->id}}" selected="selected">{{$p->ten_phim}}</option>
                  @else
                  <option value="{{$p->id}}">{{$p->ten_phim}}</option>
                  @endif
                  
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="dienVien">Diễn viên</label>
                <select name="dienVien" class="form-control custom-select">
                  <option selected disabled>Chọn diễn viên</option>
                  @foreach($dien_viens as $dv)
                  @if($dv->id==$dsdv->dien_vien)
                  <option value="{{$dv->id}}" selected="selected">{{$dv->ten_dv}}</option>
                  @else
                  <option value="{{$dv->id}}">{{$dv->ten_dv}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{route('ds-dien-vien.getDsDienViens')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Chỉnh sửa phim" class="btn btn-success float-right">
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