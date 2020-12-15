@extends('layout.master')

@section('title','Phim')

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
          <h1>Phim</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Phim</li>
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
        <h3 class="card-title">Danh sách phim</h3>&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="btn btn-success btn-sm" href="{{url('phim/them-phim')}}">
          <i class="fas fa-folder">
          </i>
          Thêm phim
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
                Tên phim
              </th>
              <th>
                Đạo diễn
              </th>
              <th>
                Diễn viên
              </th>
              <th>
                Thể loại
              </th>
              <th>
                Nhãn phim
              </th>
              <th>
                Quốc gia
              </th>
              <th>
                Ngày xuất bản 
              </th>
              <th>
                Thời lượng (Phút)
              </th>
              <th>
                Nhân viên duyệt
              </th>
            </tr>
          </thead>
          <tbody>
            @for($p = 0;$p<$sl_phim;$p++)
            <tr>
              <td>
                {{$p+1}}
              </td>
              <td>
                {{$phims[$p]->ten_phim}}
              </td>
              <td>
                {{$phims[$p]->dao_dien->ten_dd}}
              </td>
              <td>
                @foreach($ds_dien_viens as $ds)
                @if($ds->phim_id==$phims[$p]->id)
                {{$ds->dien_vien->ten_dv}}&nbsp;
                @endif
                @endforeach
              </td>
              <td>
                {{$phims[$p]->the_loai->ten_tl}}
              </td>
              <td>
                {{$phims[$p]->nhan_phim}}
              </td>
              <td>
                {{$phims[$p]->quoc_gia}}
              </td>
              <td>
                {{$phims[$p]->ngay_xuat_ban}}
              </td>
              <td>
                {{$phims[$p]->thoi_luong}}
              </td>
              <td>
                {{$phims[$p]->nhan_vien->ten_nv}}
              </td>
              <td class="project-actions text-right">
                <a class="btn btn-primary btn-sm" href="{{route('phim.phimDetail',$phims[$p]->id)}}">
                  <i class="fas fa-folder">
                  </i>
                  Chi tiết
                </a>
                <a class="btn btn-info btn-sm" href="{{route('phim.editPhim',$phims[$p]->id)}}">
                  <i class="fas fa-pencil-alt">
                  </i>
                  Sửa
                </a>
                <a class="btn btn-danger btn-sm" href="{{route('phim.deletePhim',$phims[$p]->id)}}">
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