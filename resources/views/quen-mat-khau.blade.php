<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quên mật khẩu</title>
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

  <style type="text/css">
    .error-message {
      color: red;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <h1>Quên mật khẩu</h1>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">

        <form action="" method="post">
          <!--them token-->
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="alert alert-{{Session::get('flag')}}">{{Session::get('message')}}</div>
          <div class="input-group mb-3">
            <input name="email" type="email" class="form-control" placeholder="Nhập email khôi phục">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <span class="error-message">{{$errors->first('email')}}</span>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Yêu cầu khôi phục mật khẩu</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="{{route('dang-nhap')}}">Thoát</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="sources/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="sources/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="sources/dist/js/adminlte.min.js"></script>

</body>

</html>