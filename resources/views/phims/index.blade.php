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
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add-phim">
          Thêm phim
        </button>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body p-0 ds-phim">

        <div id="load-data-phim">

        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modal-add-phim">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Thêm phim</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form method="post" action="" class="was-validated" id="form-add-phim">
                  <div class="form-group">
                    <label for="tenPhim">Tên phim</label>
                    <input type="text" class="form-control" id="tenPhim" placeholder="Nhập tên phim" name="tenPhim" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="daoDien">Đạo diễn</label>
                    <input type="text" class="form-control" id="daoDien" placeholder="Nhập đạo diễn" name="daoDien" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="theLoai">Thể loại</label>
                    <select name="theLoai" id="theLoai" class="form-control custom-select" required>
                      <option selected disabled>Chọn thể loại</option>
                      @foreach($the_loais as $tl)
                      <option value="{{$tl->id}}">{{$tl->ten_tl}}</option>
                      @endforeach
                    </select>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="dsDienVien">Danh sách diễn diên</label>
                    <input type="text" class="form-control" id="dsDienVien" placeholder="Nhập sách diễn viên" name="dsDienVien" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="hinhAnh">Hình ảnh</label>
                    <input type="file" class="form-control" id="hinhAnh" placeholder="Chọn hình ảnh" name="hinhAnh" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="nhaSanXuat">Nhà sản xuất</label>
                    <input type="text" class="form-control" id="nhaSanXuat" placeholder="Chọn nhà sản xuất" name="nhaSanXuat" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="quocGia">Quốc gia</label>
                    <input type="text" class="form-control" id="quocGia" placeholder="Chọn quốc gia" name="quocGia" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="ngayXuatBan">Ngày xuất bản</label>
                    <input type="date" class="form-control" id="ngayXuatBan" placeholder="Chọn ngày xuất bản" name="ngayXuatBan" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="thoiLuong">Thời lượng (Phút)</label>
                    <input type="number" class="form-control" id="thoiLuong" placeholder="Chọn thời lượng" name="thoiLuong" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="trailer">Trailer</label>
                    <input type="file" class="form-control" id="trailer" placeholder="Chọn trailer" name="trailer" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="nhanPhim">Nhãn phim</label>
                    <input type="text" class="form-control" id="nhanPhim" placeholder="Chọn nhãn phim" name="nhanPhim" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="moTa">Mô tả</label>
                    <input type="text" class="form-control" id="moTa" placeholder="Chọn mô tả" name="moTa" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="diem">Điểm</label>
                    <input type="text" class="form-control" id="diem" placeholder="Chọn điểm" name="diem" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <button type="submit" id="submitAddPhim" name="submitAddPhim" class="btn btn-primary">Thêm</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="modal-edit-phim">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Chỉnh sửa phim</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form method="post" id="form-edit-phim" action="" class="was-validated">
                <div class="form-group">
                    <label for="tenPhimEdit">Tên phim</label>
                    <input type="text" class="form-control" id="tenPhimEdit" placeholder="Nhập tên phim" name="tenPhimEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="daoDienEdit">Đạo diễn</label>
                    <input type="text" class="form-control" id="daoDienEdit" placeholder="Nhập đạo diễn" name="daoDienEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="theLoaiEdit">Thể loại</label>
                    <select name="theLoaiEdit" id="theLoaiEdit" class="form-control custom-select" required>
                      <option selected disabled>Chọn thể loại</option>
                      @foreach($the_loais as $tl)
                      <option value="{{$tl->id}}">{{$tl->ten_tl}}</option>
                      @endforeach
                    </select>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="dsDienVienEdit">Danh sách diễn diên</label>
                    <input type="text" class="form-control" id="dsDienVienEdit" placeholder="Nhập sách diễn viên" name="dsDienVienEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="hinhAnhEdit">Hình ảnh</label>
                    <input type="file" class="form-control" id="hinhAnhEdit" placeholder="Chọn hình ảnh" name="hinhAnhEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="nhaSanXuatEdit">Nhà sản xuất</label>
                    <input type="text" class="form-control" id="nhaSanXuatEdit" placeholder="Chọn nhà sản xuất" name="nhaSanXuatEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="quocGiaEdit">Quốc gia</label>
                    <input type="text" class="form-control" id="quocGiaEdit" placeholder="Chọn quốc gia" name="quocGiaEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="ngayXuatBanEdit">Ngày xuất bản</label>
                    <input type="date" class="form-control" id="ngayXuatBanEdit" placeholder="Chọn ngày xuất bản" name="ngayXuatBanEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="thoiLuongEdit">Thời lượng (Phút)</label>
                    <input type="number" class="form-control" id="thoiLuongEdit" placeholder="Chọn thời lượng" name="thoiLuongEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="trailerEdit">Trailer</label>
                    <input type="file" class="form-control" id="trailerEdit" placeholder="Chọn trailer" name="trailerEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="nhanPhimEdit">Nhãn phim</label>
                    <input type="text" class="form-control" id="nhanPhimEdit" placeholder="Chọn nhãn phim" name="nhanPhimEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="moTaEdit">Mô tả</label>
                    <input type="text" class="form-control" id="moTaEdit" placeholder="Chọn mô tả" name="moTaEdit" required>
                    <div class="valid-feedback">Hợp lệ.</div>
                    <div class="invalid-feedback">Không hợp lệ.</div>
                  </div>
                  <div class="form-group">
                    <label for="diemEdit">Điểm</label>
                    <input type="text" class="form-control" id="diemEdit" placeholder="Chọn điểm" name="diemEdit" required>
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
        <div class="modal fade" id="modal-detail-phim">
          <div class="modal-dialog">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Chi tiết thể loại</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <h3>Tên phim:</h3>
                <h4 id="ten_phim_detail"></h4>
                <h3>Đạo diễn:</h3>
                <h4 id="dao_dien_detail"></h4>
                <h3>Thể loại:</h3>
                <h4 id="the_loai_detail"></h4>
                <h3>Danh sách diễn viên:</h3>
                <h4 id="ds_dien_vien_detail"></h4>
                <h3>Hình ảnh:</h3>
                <h4 id="hinh_anh_detail"></h4>
                <h3>Nhà sản xuất:</h3>
                <h4 id="nha_san_xuat_detail"></h4>
                <h3>Quốc gia:</h3>
                <h4 id="quoc_gia_detail"></h4>
                <h3>Ngày xuất bản:</h3>
                <h4 id="ngay_xuat_ban_detail"></h4>
                <h3>Thời lượng:</h3>
                <h4 id="thoi_luong_detail"></h4>
                <h3>Trailer:</h3>
                <h4 id="trailer_detail"></h4>
                <h3>Nhãn phim:</h3>
                <h4 id="nhan_phim_detail"></h4>
                <h3>Mô tả:</h3>
                <h4 id="mo_ta_detail"></h4>
                <h3>Điểm:</h3>
                <h4 id="diem_detail"></h4>
                
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
        url: '{{route('phim.listPhim')}}',
        method: 'get',
        success: function(data) {
          $('#load-data-phim').html(data);
        },
        error: function(data) {
          console.log('Error: ', data);
        }
      });
    }
    load_data();

    $('.ds-phim').on('click','#submitAddPhim',function(e){
      e.preventDefault();
      var tenPhim=$('#tenPhim').val();
      var daoDien=$('#daoDien').val();
      var theLoai=$('#theLoai').val();
      var dsDienVien=$('#dsDienVien').val();
      var hinhAnh=$('#hinhAnh').val();
      var nhaSanXuat=$('#nhaSanXuat').val();
      var quocGia=$('#quocGia').val();
      var ngayXuatBan=$('#ngayXuatBan').val();
      var thoiLuong=$('#thoiLuong').val();
      var trailer=$('#trailer').val();
      var nhanPhim=$('#nhanPhim').val();
      var moTa=$('#moTa').val();
      var diem=$('#diem').val();

      var url='{{route('phim.insertPhim')}}';
      $.ajax({
        url: url,
        method: 'post',
        data: {
          'ten_phim': tenPhim,
          'dao_dien':daoDien,
          'the_loai_id':theLoai,
          'ds_dien_vien':dsDienVien,
          'hinh_anh':hinhAnh,
          'nha_san_xuat':nhaSanXuat,
          'quoc_gia': quocGia,
          'ngay_xuat_ban': ngayXuatBan,
          'thoi_luong': thoiLuong,
          'trailer':trailer,
          'nhan_phim': nhanPhim,
          'mo_ta': moTa,
          'diem':diem
        }, 
        dataType: 'json',
        success: function(data){
          $('#modal-add-phim').modal('hide');
          $('#form-add-phim')[0].reset();
          load_data();
          $('.modal-backdrop').removeClass();
        },
        error: function(data){
          console.log(data);
        }
      });
    });

    $('.ds-phim').on('click','.btn-delete',function(e){
      var id=$(this).data('id');
      var url='{{asset('phim/delete')}}/'+id;
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

    $('.ds-phim').on('click','.btn-detail',function(e){
      var id=$(this).data('id');
      var url='{{asset('phim/show')}}/'+id;
      $.ajax({
        url: url,
        method: 'get',
        success: function(data){
          $('#ten_phim_detail').text(data.ten_phim);
          $('#dao_dien_detail').text(data.dao_dien);
          $('#the_loai_detail').text(data.the_loai_id);
          $('#ds_dien_vien_detail').text(data.ds_dien_vien);
          $('#hinh_anh_detail').text(data.hinh_anh);
          $('#nha_san_xuat_detail').text(data.nha_san_xuat);
          $('#quoc_gia_detail').text(data.quoc_gia);
          $('#ngay_xuat_ban_detail').text(data.ngay_xuat_ban);
          $('#thoi_luong_detail').text(data.thoi_luong);
          $('#trailer_detail').text(data.trailer);
          $('#nhan_phim_detail').text(data.nhan_phim);
          $('#mota_detail').text(data.mo_ta);
          $('#diem_detail').text(data.diem);
        },
        error: function(e){
          console.log('Error: ',data);
        }
      });
    });

    $('.ds-phim').on('click','.btn-edit',function(e){
      e.preventDefault();      
      var id=$(this).data('id');
      var url='{{asset('phim/show')}}/'+id;
      $.ajax({
        url: url,
        method: 'get',
        success: function(data){
          $('#tenPhimEdit').val(data.ten_phim);
          $('#daoDienEdit').val(data.dao_dien);
          $('#theLoaiEdit').val(data.the_loai_id);
          $('#dsDienVienEdit').val(data.ds_dien_vien);
          //$('#hinhAnhEdit').val(data.hinh_anh);
          $('#nhaSanXuatEdit').val(data.nha_san_xuat);
          $('#quocGiaEdit').val(data.quoc_gia);
          $('#ngayXuatBanEdit').val(data.ngay_xuat_ban);
          $('#thoiLuongEdit').val(data.thoi_luong);
          //$('#trailerEdit').val(data.trailer);
          $('#nhanPhimEdit').val(data.nhan_phim);
          $('#moTaEdit').val(data.mo_ta);
          $('#diemEdit').val(data.diem);
          $('#form-edit-phim').attr('data-url','{{asset('phim/update')}}/'+data.id);
        },
        error: function(data){
          console.log('Error: ',data);
        }
      });
    });
    $('.ds-phim').on('submit','#form-edit-phim', function(e){
      e.preventDefault();
        var tenPhim=$('#tenPhimEdit').val();
        var daoDien=$('#daoDienEdit').val();
        var theLoai=$('#theLoaiEdit').val();
        var dsDienVien=$('#dsDienVienEdit').val();
        var hinhAnh=$('#hinhAnhEdit').val();
        var nhaSanXuat=$('#nhaSanXuatEdit').val();
        var quocGia=$('#quocGiaEdit').val();
        var ngayXuatBan=$('#ngayXuatBanEdit').val();
        var thoiLuong=$('#thoiLuongEdit').val();
        var trailer=$('#trailerEdit').val();
        var nhanPhim=$('#nhanPhimEdit').val();
        var moTa=$('#moTaEdit').val();
        var diem=$('#diemEdit').val();

        var time=new Date($.now());
        var updated_at=time.getFullYear()+"-"+(time.getMonth()+1)+"-"+time.getDate()+" "+time.getHours()+":"+time.getMinutes()+":"+time.getSeconds();
        var url=$(this).attr('data-url');
      $.ajax({
        url: url,
        method: 'put',
        dataType: 'json',
        data: {
          'ten_phim': tenPhim,
          'dao_dien':daoDien,
          'the_loai_id':theLoai,
          'ds_dien_vien':dsDienVien,
          'hinh_anh':hinhAnh,
          'nha_san_xuat':nhaSanXuat,
          'quoc_gia': quocGia,
          'ngay_xuat_ban': ngayXuatBan,
          'thoi_luong': thoiLuong,
          'trailer':trailer,
          'nhan_phim': nhanPhim,
          'mo_ta': moTa,
          'diem':diem,
          'updated_at': updated_at
        },
        success: function(data){
          $('#modal-edit-phim').modal('hide');
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