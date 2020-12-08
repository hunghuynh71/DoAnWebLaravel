<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Đăng nhập</title>
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
      .error-message {color: red;}
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <h1>Đăng nhập</h1>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <!--@if(count($errors)>0)
        <div class="error-message">
          <ul>
            @foreach($errors->all() as $error)
            <li>
              {{$error}}
            </li>
            @endforeach
          </ul>
        </div>
        @endif-->
        <form action="{{route('dang-nhap')}}" method="post">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="alert alert-{{Session::get('flag')}}">{{Session::get('message')}}</div>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Nhập Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <span class="error-message">{{$errors->first('email')}}</span>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <span class="error-message">{{$errors->first('password')}}</span>
          <div class="row">
            <div class="col-6">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Nhớ tài khoản
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-6">
              <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1">
          <a href="{{route('quen-mat-khau')}}">Quên mật khẩu</a>
        </p>
        <p class="mb-0">
          <a href="{{route('dang-ki')}}" class="text-center">Đăng kí</a>
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