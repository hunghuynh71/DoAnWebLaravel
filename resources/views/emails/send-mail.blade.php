<!DOCTYPE html>
<html>
<head>
    <title>ItsolutionStuff.com</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>Click <a href="{{route('khoi-phuc-mat-khau',['code'=>$code,'email'=>$email])}}">vào đây</a> để lấy lại mật khẩu!</p>

    <p>Thank you</p>
</body>
</html>