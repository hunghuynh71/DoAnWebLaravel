@extends('layout.master')

@section('title','Nhân viên')

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
          <h1>Nhân viên</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Nhân viên</li>
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
        <h3 class="card-title">Danh sách nhân viên</h3>&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="btn btn-success btn-sm" href="{{route('nhan-vien.addNhanVien')}}">
          <i class="fas fa-folder">
          </i>
          Thêm nhân viên
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
                Tên nhân viên 
              </th>
              <th>
                SĐT
              </th>
              <th>
                Email
              </th>
              <th>
                Ngày vào làm
              </th>
              <th>
                Giới tính 
              </th>
              <th>
                Địa chỉ 
              </th>
              <th>
                Quyền
              </th>
          </thead>
          <tbody>
            @for($p = 0;$p<$sl;$p++)
            <tr>
              <td>
                {{$p+1}}
              </td>
              <td>
                {{$nhan_viens[$p]->ten_nv}}
              </td>
              <td>
                {{$nhan_viens[$p]->sdt}}
              </td>
              <td>
                {{$nhan_viens[$p]->email}}
              </td>
              <td>
                {{$nhan_viens[$p]->ngay_vao_lam}}
              </td>
              <td>
                {{$nhan_viens[$p]->gioi_tinh}}
              </td>
              <td>
                {{$nhan_viens[$p]->dia_chi}}
              </td>
              <td>
                {{$nhan_viens[$p]->quyen->ten_quyen}}
              </td>
              <td class="project-actions text-right">
                <a class="btn btn-primary btn-sm" href="{{route('nhan-vien.nhanVienDetail',$nhan_viens[$p]->id)}}">
                  <i class="fas fa-folder">
                  </i>
                  Chi tiết
                </a>
                <a class="btn btn-info btn-sm" href="{{route('nhan-vien.editNhanVien',$nhan_viens[$p]->id)}}">
                  <i class="fas fa-pencil-alt">
                  </i>
                  Sửa
                </a>
                <a class="btn btn-danger btn-sm" href="{{route('nhan-vien.deleteNhanVien',$nhan_viens[$p]->id)}}">
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