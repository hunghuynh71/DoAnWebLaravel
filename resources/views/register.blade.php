<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Đăng kí</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="sources/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="sources/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="sources/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      Đăng kí
    </div>

    <div class="card">
      <div class="card-body register-card-body">

        <form action="{{route('dang-ki')}}" method="post">
          <!--them token-->
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="alert alert-{{Session::get('flag')}}">{{Session::get('message')}}</div>
          <div class="input-group mb-3">
            <input type="text" name="hoTen" class="form-control" placeholder="Tên">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="matKhau" class="form-control" placeholder="Mật khẩu">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="nhapLaiMatKhau" class="form-control" placeholder="Nhập lại mật khẩu">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="cmnd" class="form-control" placeholder="CMND">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="sdt" class="form-control" placeholder="Số điện thoại">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="date" name="ngayVaoLam" class="form-control" placeholder="Ngày vào làm">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select name="gioiTinh" class="form-control custom-select">
              <option selected disabled>Giới tính</option>
              <option value="1">Nam</option>
              <option value="0">Nữ</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="diaChi" class="form-control" placeholder="Địa chỉ">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <select name="quyen" class="form-control custom-select">
              <option selected disabled>Quyền</option>
              @foreach($quyens as $q)
              <option value="{{$q->id}}">{{$q->ten_quyen}}</option>
              @endforeach
            </select>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                  Tôi đã đồng ý với <a href="#">các điều khoản</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Đăng kí</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="{{route('dang-nhap')}}" class="text-center">Đăng nhập</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="sources/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="sources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="sources/dist/js/adminlte.min.js"></script>
</body>

</html>