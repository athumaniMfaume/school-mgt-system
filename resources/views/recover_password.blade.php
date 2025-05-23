<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Reset Password</title>
  <base href="{{ asset('admins') }}/">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>School</b>LTE</a>
    </div>
    <div class="card-body">

      @if ($errors->any())
        <div class="alert alert-danger">
          {{ $errors->first() }}
        </div>
      @endif

      <p class="login-box-msg">Enter your new password</p>

      <form action="{{ route('password.reset') }}" method="POST">
        @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

            <div class="input-group mb-3">
          <input type="email"  value="{{ $email }}" class="form-control" readonly>
        </div>


        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="New Password" required>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
          </div>
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{ route('login') }}">Back to Login</a>
      </p>
    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
