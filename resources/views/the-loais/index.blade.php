@extends('layout.master')

@section('title','Thể loại')

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
          <h1>Thể loại</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('trang-chu')}}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thể loại</li>
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
        <h3 class="card-title">Danh sách thể loại</h3>&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add-the-loai">
          Thêm thể loại
        </button>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body p-0 ds-the-loai">
        <div id="load-data-the-loai">

        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modal-add-the-loai">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Thêm thể loại</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form method="post" action="" class="was-validated" id="form-add-the-loai">
                  <div class="form-group">
                    <label for="tenTheLoai">Tên thể loại:</label>
                    <input type="text" class="form-control" id="tenTheLoai" placeholder="Nhập tên thể loại" name="tenTheLoai" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <button type="submit" id="submitAddTheLoai" name="submitAddTheLoai" class="btn btn-primary">Thêm</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modal-edit-the-loai">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Chỉnh sửa thể loại</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form method="post" id="form-edit_the_loai" action="" class="was-validated">
                  <div class="form-group">
                    <label for="tenTheLoai">Tên thể loại:</label>
                    <input type="text" class="form-control" id="ten_the_loai_edit" placeholder="Enter email" name="tenTheLoai" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <button type="submit" id="submitEdit" name="submitEdit" class="btn btn-primary">Chỉnh sửa</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modal-detail-the-loai">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Chi tiết thể loại</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <h3>Tên thể loại:</h3>
                <h4 id="ten_the_loai_detail"></h4>
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
      $.ajax({
        url: '{{route('the-loai.listTheLoai')}}',
        method: 'get',
        success: function(data) {
          $('#load-data-the-loai').html(data);
        },
        error: function(data) {
          console.log('Error: ', data);
        }
      });
    }

    load_data();

    $('.ds-the-loai').on('click', '#submitAddTheLoai', function(e) {
      e.preventDefault();
      var tenTheLoai = $("input[name=tenTheLoai]").val();
      $.ajax({
        url: '{{route('the-loai.insertTheLoai')}}',
        method: 'post',
        data: {
          'ten_tl': tenTheLoai
        },
        dataType: 'json',
        success: function(data) {
          $('#modal-add-the-loai').modal('hide');
          $('#form-add-the-loai')[0].reset();
          load_data();
          $('.modal-backdrop').removeClass();
        },
        error: function(data) {
          console.log('Error:', data);
        }
      });
    });

    $('.ds-the-loai').on('click','.btn-delete', function(e){
      e.preventDefault();
      var id=$(this).data('id');
      var url='{{asset('the-loai/delete')}}/'+id;
      if(confirm('Bạn có chắc muốn xóa chứ?')){
        $.ajax({
          url: url,
          method: 'put',
          success: function(data){
            load_data();
          },
          error: function(data){
            console.log(data);
          }
        });
      }
    });

    $('.ds-the-loai').on('click','.btn-detail',function(e){
      e.preventDefault();
      var id=$(this).data('id');
      var url='{{asset('the-loai/show')}}/'+id;
      $.ajax({
          url:url,
          method: 'get',
          dataType: 'json',
          success: function(data){
            $('h4#ten_the_loai_detail').text(data.ten_tl);
          },
          error: function(data){
            console.log('Error: ',data);
          }
      });
    });

    $('.ds-the-loai').on('click','.btn-edit',function(e){
      e.preventDefault();
      var id = $(this).data('id');
      var url = '{{asset('the-loai/show')}}/'+id;
      $.ajax({
        url:url,
        method: 'get',
        dataType: 'json',
        success: function(data){
          $('#ten_the_loai_edit').val(data.ten_tl);
          $('#form-edit_the_loai').attr('data-url','{{asset('the-loai/update')}}/'+data.id);
        },
        error: function(e){
          console.log('Error: ',data);
        }
      });
    });

    $('.ds-the-loai').on('submit','#form-edit_the_loai',function(e){
      e.preventDefault();
      var tenTheLoai=$('#ten_the_loai_edit').val();
      var url = $(this).attr('data-url');
      $.ajax({
        url: url,
        method: 'put',
        dataType: 'json',
        data: {
          'ten_tl': tenTheLoai
        },
        success: function(data){
          $('#modal-edit-the-loai').modal('hide');
          load_data();
          $('.modal-backdrop').removeClass();
        },
        error: function(data){
          console.log('Error: ',data);
        }
      });
    });
  });
</script>
@endsection