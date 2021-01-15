@extends('layout.master')

@section('title','Vé')

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
          <h1>Vé</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Vé</li>
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
        <h3 class="card-title">Danh sách vé</h3>&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body p-0 ds-ve">
        <div id="load-data-ve">
        
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modal-detail-ve">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Chi tiết vé</h4>
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
                <h3>Ghế:</h3>
                <h4 id="ghe_detail"></h4>
                <h3>Giá:</h3>
                <h4 id="gia_detail"></h4>
                <h3>Thời gian đặt:</h3>
                <h4 id="thoi_gian_dat_detail"></h4>
                <h3>Khách đặt vé:</h3>
                <h4 id="khach_dat_ve_detail"></h4>
                <h3>Chi nhánh:</h3>
                <h4 id="chi_nhanh_detail"></h4>
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
$(document).ready(function(){
  function load_data(){
    var url='{{route('ve.listVe')}}';
    $.ajax({
      url:url,
      method: 'get',
      success: function(data){
        $('#load-data-ve').html(data);
      },
      error: function(data){
        console.log('Error: ',data);
      }
    });
  }

  load_data();

  $('.ds-ve').on('click','.btn-detail',function(e){
    e.preventDefault();
    var id=$(this).attr('data-id');
    var url='{{asset('ve/show')}}/'+id;
    $.ajax({
      url:url,
      method: 'get',
      success: function(data){
        $('#phim_detail').text(data.lich_chieu.phim.ten_phim);
        $('#ngay_chieu_detail').text(data.lich_chieu.ngay_chieu);
        $('#gio_chieu_detail').text(data.lich_chieu.khung_tg_chieu.tg_chieu);
        $('#rap_detail').text(data.lich_chieu.rap_phim.ten_rap);
        $('#dinh_dang_detail').text(data.lich_chieu.dinh_dang.ten_dd);
        $('#ghe_detail').text(data.ghe.ten_ghe);
        $('#gia_detail').text(data.gia_ve.gia);
        $('#thoi_gian_dat_detail').text(data.ds_ve.tg_dat);
        $('#khach_dat_ve_detail').text(data.ds_ve.khach_dat_ve.ten_kdv);
        $('#chi_nhanh_detail').text(data.ds_ve.chi_nhanh.ten_cn);
      },
      error: function(data){
        console.log(data);
      }
    });
  });

});
</script>
@endsection