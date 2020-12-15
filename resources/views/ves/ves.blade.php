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
        <a class="btn btn-success btn-sm" href="{{url('ve/them-ve')}}">
          <i class="fas fa-folder">
          </i>
          Thêm vé
        </a>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th>
                STT
              </th>
              <th>
                Phim
              </th>
              <th>
                Ngày chiếu 
              </th>
              <th>
                Giờ chiếu
              </th>
              <th>
                Rạp
              </th>
              <th>
                Ghế
              </th>
              <th>
                Giá
              </th>
            </tr>
          </thead>
          <tbody>
            @for($p = 0;$p<$sl;$p++)
            <tr>
              <td>
                {{$p+1}}
              </td>
              <td>
                {{$ves[$p]->lich_chieu->phim->ten_phim}}
              </td>
              <td>
                {{$ves[$p]->lich_chieu->ngay_chieu}}
              </td>
              <td>
                {{$ves[$p]->lich_chieu->khung_tg_chieu->tg_chieu}}
              </td>
              <td>
                {{$ves[$p]->lich_chieu->rap_phim->ten_rap}}
              </td>
              <td>
                {{$ves[$p]->ghe_id}}
              </td>
              <td>
                {{$ves[$p]->gia_ve->gia}}
              </td>
              <td class="project-actions text-right">
                <a class="btn btn-primary btn-sm" href="{{route('ve.veDetail',$ves[$p]->id)}}">
                  <i class="fas fa-folder">
                  </i>
                  Chi tiết
                </a>
                <a class="btn btn-danger btn-sm" href="{{route('ve.deleteVe',$ves[$p]->id)}}">
                  <i class="fas fa-trash">
                  </i>
                  Xóa
                </a>
              </td>
            </tr>
            @endfor
          </tbody>
        </table>
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