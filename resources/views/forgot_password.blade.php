<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Forgot Password</title>
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

      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
      @endif

      <p class="login-box-msg">Forgot your password? Enter your email to reset it.</p>

      <form action="{{ route('forgot.post') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request Reset Link</button>
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
