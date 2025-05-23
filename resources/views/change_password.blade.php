<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>School Management | Change Password (v2)</title>
  <base href="{{asset('admins')}}/">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>School</b>LTE</a>
    </div>
    <div class="card-body">
       @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ Session::get('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
      <p class="login-box-msg">Change password now.</p>
      <form action="{{ route('changepassword.post') }}" method="post">
        @csrf
        <div class="input-group mb-3">
           <input type="password" name="old_password" class="form-control" id="academicYear" placeholder="Enter Old Password">
                        @error('old_password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
         
        </div>
        <div class="input-group mb-3">
           <input type="password" name="new_password" class="form-control" id="academicYear" placeholder="Enter New Password">
                        @error('new_password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
        </div>

          <div class="input-group mb-3">
          <input type="password" name="password_confirmation" class="form-control" id="academicYear" placeholder="Enter Confirm Password">
                        @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{route('login')}}">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
