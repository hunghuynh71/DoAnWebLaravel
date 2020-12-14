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
          <h1>Thêm phim</h1>
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
              <div class="form-group">
                <label for="tenPhim">Tên phim</label>
                <input type="text" name="tenPhim" class="form-control">
              </div>
              <div class="form-group">
                <label for="daoDien">Đạo diễn</label>
                <select name="daoDien" class="form-control custom-select">
                  <option selected disabled>Chọn đạo diễn</option>
                  @foreach($dao_diens as $dd)
                  <option value="{{$dd->id}}">{{$dd->ten_dd}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="dienVien">Diễn viên</label>
                <a href="{{route('ds-dien-vien.getDsDienViens')}}" class="btn btn-secondary">Danh sách diễn viên</a>
              </div>
              <div class="form-group">
                <label for="theLoai">Thể loại</label>
                <select name="theLoai" class="form-control custom-select">
                  <option selected disabled>Chọn thể loại</option>
                  @foreach($the_loais as $tl)
                  <option value="{{$tl->id}}">{{$tl->ten_tl}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="hinhAnh">Hình ảnh</label>
                <input type="file" name="hinhAnh" class="form-control">
              </div>
              <div class="form-group">
                <label for="nhanPhim">Nhãn phim</label>
                <input type="text" name="nhanPhim" class="form-control">
              </div>
              <div class="form-group">
                <label for="quocGia">Quốc gia</label>
                <input type="text" name="quocGia" class="form-control">
              </div>
              <div class="form-group">
                <label for="nhaSanXuat">Nhà sản xuất</label>
                <input type="text" name="nhaSanXuat" class="form-control">
              </div>
              <div class="form-group">
                <label for="ngayXuatBan">Ngày xuất bản</label>
                <input type="date" name="ngayXuatBan" class="form-control">
              </div>
              <div class="form-group">
                <label for="thoiLuong">Thời lượng (Phút)</label>
                <input type="text" name="thoiLuong" class="form-control">
              </div>
              <div class="form-group">
                <label for="trailer">Trailer</label>
                <input type="text" name="trailer" class="form-control">
              </div>
              <div class="form-group">
                <label for="diem">Điểm</label>
                <input type="text" name="diem" class="form-control">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{route('phim.getPhims')}}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Thêm phim" class="btn btn-success float-right">
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