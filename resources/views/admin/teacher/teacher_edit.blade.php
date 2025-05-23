@extends('admin.layout')
@section('title')
  Teacher | Edit
@endsection
@section('content')



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Teacher</h1>
            <a href="{{route('teacher.read')}}" class="btn btn-primary mt-2"> View Teacher</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Teacher</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                @if (Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>

                @endif

                @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{Session::has('error')}}
                </div>

                @endif
              <div class="card-header">
                <h3 class="card-title">Teacher Edit</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
          <form action="{{ route('teacher.update', $data->id) }}" method="post" enctype="multipart/form-data">
    @csrf
   
    <input type="hidden" name="id" value="{{ $data->id }}">
    <div class="card-body">
        <div class="row">

            <div class="form-group col-md-4">
                <label for="class">Class</label>
                <select class="form-control" name="class_id" id="class">
                    <option value="">Select class</option>
                    @foreach ($class as $item)
                        <option value="{{ $item->id }}" {{ $data->class_id == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="name">Teacher's Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name', $data->name) }}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="email">Teacher's Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old('email', $data->email) }}">
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="dob">Birthday</label>
                <input type="date" name="dob" class="form-control" id="dob" value="{{ old('dob', $data->dob) }}">
                @error('dob')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="phone">Teacher's Phone</label>
                <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter Phone" value="{{ old('phone', $data->phone) }}">
                @error('phone')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="password">Password (Leave blank if not changing)</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image upload -->
            <div class="form-group col-md-4">
                <label for="image">Teacher's Image</label>
                <input type="file" name="image" class="form-control" id="image" accept="image/*">
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                @if ($data->image && Storage::disk('public')->exists($data->image))
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $data->image) }}" alt="Teacher Image" width="100" height="100" style="object-fit: cover; border-radius: 5px;">
                    </div>
                @else
                    <p class="mt-2 text-muted">No image available</p>
                @endif
            </div>

        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

            </div>
            <!-- /.card -->

        

            <!-- Input addon -->
      
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
@section('customJs')

<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
@endsection
<!-- ./wrapper -->



