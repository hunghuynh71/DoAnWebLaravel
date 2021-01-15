@extends('layout.master')

@section('title','Giá vé')

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
          <h1>Giá vé</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Giá vé</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row them-gia-ve">
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

              <form method="post" action="" id="form-tim-kiem-lich-chieu">
                <!--them token-->
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <!--Tìm kiếm lịch chiếu-->
                <div class="card card-secondary lich-chieu">
                  <div class="card-header">
                    <h3 class="card-title">Lịch chiếu</h3>

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
                      </div>

                      <div class="form-group col-md-6">
                        <label for="dinhDang">Định dạng</label>
                        <select name="dinhDang" class="form-control custom-select" id="dinhDang">
                          <option selected disabled>Chọn định dạng</option>
                          @foreach($dinh_dangs as $dd)
                          <option value="{{$dd->id}}">{{$dd->ten_dd}}</option>
                          @endforeach
                        </select>
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
                      </div>

                      <div class="form-group col-md-4">
                        <label for="ngayChieu">Ngày chiếu</label>
                        <input type="date" name="ngayChieu" class="form-control" id="ngayChieu">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="rap">Rạp</label>
                        <select name="rap" class="form-control custom-select" id="rap">
                          <option selected disabled>Chọn rạp</option>
                          @foreach($rap_phims as $r)
                          <option value="{{$r->id}}">{{$r->ten_rap}}</option>
                          @endforeach
                        </select>
                      </div>

                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-secondary" id="submitSearchLichChieu">Tìm kiếm lịch chiếu</button>
                  </div>
                  <!-- /.card-footer -->

                </div>
              </form>

              <div class="row">                 

                <input type="hidden" id="lichChieu">

                <div class="form-group col-md-6">
                  <label for="loaiGhe">Loại ghế</label>
                  <select name="loaiGhe" class="form-control custom-select" id="loaiGhe">
                    <option selected disabled>Chọn loại ghế</option>
                    @foreach($loai_ghes as $lg)
                    <option value="{{$lg->id}}">{{$lg->ten_lg}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="gia">Giá</label>
                  <input type="text" name="gia" class="form-control" id="gia">
                </div>

              </div>

              

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-success" id="submitAddGiaVe">Thêm giá vé</button>
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
        <h3 class="card-title">Danh giá vé</h3>&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body p-0 ds-gia-ve">
        <div id="load-data-gia-ve">

        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modal-detail-gia-ve">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Chi tiết giá vé</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <h3>Phim:</h3>
                <h4 id="phim_detail"></h4>
                <h3>Ngày chiếu:</h3>
                <h4 id="ngay_chieu_detail"></h4>
                <h3>Giờ chiếu:</h3>
                <h4 id="gio_chieu_detail"></h4>
                <h3>Rạp:</h3>
                <h4 id="rap_detail"></h4>
                <h3>Định dạng:</h3>
                <h4 id="dinh_dang_detail"></h4>
                <h3>Loại ghế:</h3>
                <h4 id="loai_ghe_detail"></h4>
                <h3>Giá:</h3>
                <h4 id="gia_detail"></h4>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
              </div>
              
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

@section('ajax')
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{csrf_token()}}'
    }
  });
  $(document).ready(function() {
    function load_data() {
      var url = '{{route('gia-ve.listGiaVe')}}';
      $.ajax({
        url: url,
        method: 'get',
        success: function(data) {
          $('#load-data-gia-ve').html(data);
        },
        error: function(data) {
          console.log(data);
        }
      });
    }

    load_data();

    $('.lich-chieu').on('click','#submitSearchLichChieu',function(e){
        e.preventDefault();
        var phim_id=$('#phim').val();
        var dinh_dang_id=$('#dinhDang').val();
        var khung_tg_chieu_id=$('#khungTGChieu').val();
        var rap_id=$('#rap').val();
        var ngay_chieu=$('#ngayChieu').val();
        var url='{{route('gia-ve.searchLichChieu')}}';
        $.ajax({
          url:url,
          method: 'post',
          dataType: 'json',
          data: {
            'phim_id': phim_id,
            'dinh_dang_id':dinh_dang_id,
            'khung_tg_chieu_id':khung_tg_chieu_id,
            'rap_id':rap_id,
            'ngay_chieu':ngay_chieu
          },
          success: function(data){
            if(data==''){
              alert('Không tìm thấy lịch chiếu!');
            }else{
              $.each(data,function(key,item){
                alert('Tìm thấy lịch chiếu!');
                $('#lichChieu').val(item['id']);
              });
            }            
          },
          error: function(data){
            console.log(data);
          }
        });
    });

    $('.them-gia-ve').on('click','#submitAddGiaVe',function(e){
      e.preventDefault();
      var lich_chieu_id=$('#lichChieu').val();
      var loai_ghe_id=$('#loaiGhe').val();
      var gia=$('#gia').val();
      if(lich_chieu_id==''){
        alert('Bạn chưa thêm lịch chiếu!');
      }else{
        var url='{{route('gia-ve.insertGiaVe')}}';
        $.ajax({
          url: url,
          method: 'post',
          dataType: 'json',
          data: {
            'lich_chieu_id':lich_chieu_id,
            'loai_ghe_id': loai_ghe_id,
            'gia': gia
          },
          success: function(data){
            alert('Thêm thành công!');
            load_data();
          },
          error: function(data){
            alert('Thêm thất bại!');
            console.log(data);
          }
        });
      }
    });

    $('#load-data-gia-ve').on('click','.btn-detail',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      var url='{{asset('gia-ve/show')}}/'+id;
      $.ajax({
        url: url,
        method: 'get',
        dataType: 'json',
        success: function(data){
          $('#phim_detail').text(data.lich_chieu.phim.ten_phim);
          $('#ngay_chieu_detail').text(data.lich_chieu.ngay_chieu);
          $('#gio_chieu_detail').text(data.lich_chieu.khung_tg_chieu.tg_chieu);
          $('#rap_detail').text(data.lich_chieu.rap_phim.ten_rap);
          $('#dinh_dang_detail').text(data.lich_chieu.dinh_dang.ten_dd);
          $('#loai_ghe_detail').text(data.loai_ghe.ten_lg);
          $('#gia_detail').text(data.gia);
        },
        error: function(data){
          console.log(data);
        }
      });
    });

    $('#load-data-gia-ve').on('click','.btn-delete',function(e){
      e.preventDefault();
      var id=$(this).attr('data-id');
      var url='{{asset('gia-ve/delete')}}/'+id;
      $.ajax({
        url: url,
        method: 'get',
        success: function(data){
          alert(data);
          load_data();
        },
        error: function(data){
          console.log(data);
        }
      });
    });
  });
</script>
@endsection