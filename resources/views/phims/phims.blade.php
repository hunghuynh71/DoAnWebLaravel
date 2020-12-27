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

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
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
        <a class="btn btn-success btn-sm" href="javascript:void(0)" id="create-new-phim">
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
        <table class="table table-striped projects" id="laravel_crud">
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
                Mô tả
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
          <tbody id="phims-crud">
            <?php
            $sl = $phims->count();
            ?>
            @for($p = 0;$p<$sl;$p++) <tr>
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
                {{$phims[$p]->mo_ta}}
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
                <a class="btn btn-info btn-sm" href="javascript:void(0)" id="edit-phim" data-id="{{ $phims[$p]->id }}">
                  <i class="fas fa-pencil-alt">
                  </i>
                  Sửa
                </a>
                <a class="btn btn-danger btn-sm" href="javascript:void(0)" id="delete-phim" data-id="{{ $phims[$p]->id }}">
                  <i class="fas fa-trash">
                  </i>
                  Xóa
                </a>
              </td>
              </tr>
              @endfor
          </tbody>
        </table>
        {{ $phims->links() }}
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="userCrudModal"></h4>
          </div>
          <div class="modal-body">
            <form id="phimForm" name="phimForm" class="form-horizontal">
              <input type="hidden" name="phimID" id="phimID">
              <div class="form-group">
                <label for="tenPhim" class="col-sm-2 control-label">Tên phim</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="tenPhim" name="tenPhim" placeholder="Nhập tên phim" value="" maxlength="50" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Đạo diễn</label>
                <div class="col-sm-12">
                  <select name="daoDien" class="form-control custom-select">
                    <option selected disabled>Chọn đạo diễn</option>
                    @foreach($dao_diens as $dd)
                    <option value="{{$dd->id}}">{{$dd->ten_dd}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Thể loại</label>
                <div class="col-sm-12">
                  <select name="theLoai" class="form-control custom-select">
                    <option selected disabled>Chọn thể loại</option>
                    @foreach($the_loais as $tl)
                    <option value="{{$tl->id}}">{{$tl->ten_tl}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-save" value="create">Save changes
            </button>
          </div>
        </div>
      </div>
    </div>

  </section>


  <!-- /.content -->
</div>

<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    /*  When user click add phim button */
    $('#create-new-phim').click(function() {
      $('#btn-save').val("create-phim");
      $('#phimForm').trigger("reset");
      $('#phimCrudModal').html("Add New Phim");
      $('#ajax-crud-modal').modal('show');
    });
    /* When click edit user */
    $('body').on('click', '#edit-phim', function() {
      var user_id = $(this).data('id');
      $.get('ajax-crud/' + user_id + '/edit', function(data) {
        $('#phimCrudModal').html("Edit Phim");
        $('#btn-save').val("edit-phim");
        $('#ajax-crud-modal').modal('show');
        $('#phimID').val(data.id);
        $('#name').val(data.name);
        $('#email').val(data.email);
      })
    });
    //delete user login
    $('body').on('click', '.delete-user', function() {
      var user_id = $(this).data("id");
      confirm("Are You sure want to delete !");
      $.ajax({
        type: "DELETE",
        url: "{{ url('ajax-crud')}}" + '/' + user_id,
        success: function(data) {
          $("#user_id_" + user_id).remove();
        },
        error: function(data) {
          console.log('Error:', data);
        }
      });
    });
  });
  if ($("#userForm").length > 0) {
    $("#userForm").validate({
      submitHandler: function(form) {
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');
        $.ajax({
          data: $('#userForm').serialize(),
          url: "https://www.tutsmake.com/laravel-example/ajax-crud/store",
          type: "POST",
          dataType: 'json',
          success: function(data) {
            var user = '<tr id="user_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td><td>' + data.email + '</td>';
            user += '<td><a href="javascript:void(0)" id="edit-user" data-id="' + data.id + '" class="btn btn-info">Edit</a></td>';
            user += '<td><a href="javascript:void(0)" id="delete-user" data-id="' + data.id + '" class="btn btn-danger delete-user">Delete</a></td></tr>';
            if (actionType == "create-user") {
              $('#users-crud').prepend(user);
            } else {
              $("#user_id_" + data.id).replaceWith(user);
            }
            $('#userForm').trigger("reset");
            $('#ajax-crud-modal').modal('hide');
            $('#btn-save').html('Save Changes');
          },
          error: function(data) {
            console.log('Error:', data);
            $('#btn-save').html('Save Changes');
          }
        });
      }
    })
  }
</script>
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