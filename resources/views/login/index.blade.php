<!doctype html>
<html lang="vi" style="height: 100%">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css" media="all"/>
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">

</head>
<body style="height: 100%">
<!-- login -->
<div class="login-contect d-flex justify-content-center align-items-center py-5" style="height: 100%">
    <div class="container py-xl-5 py-3">
        <div class="login-body">
            <div class="login p-4 mx-auto">
                <h5 class="text-center mb-4">Đăng nhập</h5>
                <form action="{{url('/login')}}" method="post">
                    @if($errors->has('error'))
                        <label style="color: red">Thông tin tài khoản hoặc mật khẩu không chính xác!</label>
                    @endif
                    @csrf
                    <div class="form-group">
                        <label>Tên tài khoản</label>
                        <input type="text" class="form-control" name="username" {{$username == null ?: "value = ${username}"}} required>
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Mật khẩu</label>
                        <input type="password" class="form-control" name="password" {{$password == null ?: "value = ${password}"}} required>
                        @if($errors -> has('password'))
                            <label style="color:red">{{$errors->first('password')}}</label>
                        @endif
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember-me" name="remember-me">
                        <label class="form-check-label" for="remember-me">Lưu tài khoản</label>
                    </div>
                    <button type="submit" class="btn submit mb-4">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- //login -->
</body>
</html>
