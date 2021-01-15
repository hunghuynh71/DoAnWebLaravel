@extends('layout.master')

@section('title','Lịch chiếu')

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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lịch chiếu</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}} 
            ">Trang chủ</a></li>
            <li class="breadcrumb-item active">Lịch chiếu</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row them-lich-chieu">
      <div class="col-md-12">
        <form method="post" action="" id="form-them-lich-chieu">
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
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="phim">Phim</label>
                  <select name="phim" class="form-control custom-select" id="phim">
                    <option selected disabled>Chọn phim</option>
                    @foreach($phims as $p)
                    <option value="{{$p->id}}">{{$p->ten_phim}}</option>
                    @endforeach
                  </select>
                  <span class="error-message">{{$errors->first('phim')}}</span>
                </div>

                <div class="form-group col-md-6">
                  <label for="dinhDang">Định dạng</label>
                  <select name="dinhDang" class="form-control custom-select" id="dinhDang">
                    <option selected disabled>Chọn định dạng</option>
                    @foreach($dinh_dangs as $dd)
                    <option value="{{$dd->id}}">{{$dd->ten_dd}}</option>
                    @endforeach
                  </select>
                  <span class="error-message">{{$errors->first('dinhDang')}}</span>
                </div>


              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="khungTGChieu">Giờ chiếu</label>
                  <select name="khungTGChieu" class="form-control custom-select" id="khungTGChieu">
                    <option selected disabled>Chọn khung thời gian chiếu</option>
                    @foreach($khung_tg_chieus as $ktgc)
                    <option value="{{$ktgc->id}}">{{$ktgc->tg_chieu}}</option>
                    @endforeach
                  </select>
                  <span class="error-message">{{$errors->first('khungTGChieu')}}</span>
                </div>

                <div class="form-group col-md-4">
                  <label for="ngayChieu">Ngày chiếu</label>
                  <input type="date" name="ngayChieu" class="form-control" id="ngayChieu">
                  <span class="error-message">{{$errors->first('ngayChieu')}}</span>
                </div>

                <div class="form-group col-md-4">
                  <label for="rap">Rạp</label>
                  <select name="rap" class="form-control custom-select" id="rap">
                    <option selected disabled>Chọn rạp</option>
                    @foreach($rap_phims as $r)
                    <option value="{{$r->id}}">{{$r->ten_rap}}</option>
                    @endforeach
                  </select>
                  <span class="error-message">{{$errors->first('rap')}}</span>
                </div>

              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">

              <button type="submit" class="btn btn-success" id="submitAddLichChieu">Thêm lịch chiếu</button>
            </div>
            <!-- /.card-footer -->

          </div>
          <!-- /.card -->
        </form>
      </div>
    </div>

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Danh sách lịch chiếu</h3>&nbsp;&nbsp;&nbsp;&nbsp;

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body p-0 ds-lich-chieu">

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

@section('ajax')
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{csrf_token()}}'
    }
  });
  $(document).ready(function() {
    function load_data() {
      var url = '{{route('lich-chieu.listLichChieu')}}';
      $.ajax({
        url: url,
        method: 'get',
        success: function(data) {
          $('.ds-lich-chieu').html(data);
        },
        error: function(data) {
          console.log(data);
        }
      });
    }

    load_data();

    $('.content').on('click', '#submitAddLichChieu', function(e) {
      e.preventDefault();
      var phim = $('#phim').val();
      var gio_chieu = $('#khungTGChieu').val();
      var ngay_chieu = $('#ngayChieu').val();
      var rap = $('#rap').val();
      var dinh_dang = $('#dinhDang').val();
      var url = '{{route('lich-chieu.insertLichChieu')}}';
      $.ajax({
        url: url,
        method: 'post',
        data: {
          'phim_id': phim,
          'khung_tg_chieu_id': gio_chieu,
          'ngay_chieu': ngay_chieu,
          'rap_id': rap,
          'dinh_dang_id': dinh_dang
        },
        dataType: 'json',
        success: function(data) {
          $('#form-them-lich-chieu')[0].reset();
          load_data();
        },
        error: function(data) {
          alert("Lịch chiếu đã tồn tại!");
          console.log(data);
        }
      });
    });

    $('.content').on('click', '.btn-delete', function(e) {
      e.preventDefault();
      var id = $(this).attr('data-id');
      var url = '{{asset('lich-chieu/delete')}}/' + id;
      $.ajax({
        url: url,
        method: 'put',
        success: function(data) {
          load_data();
          alert(data);
        },
        error: function(data) {
          console.log(data);
        }
      });
    });

  });
</script>
@endsection