@extends('admin.layout')
@section('title')
  Teacher List
@endsection
<base href="{{asset('admins')}}/">
@section('customCss')
   <!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
            <a href="{{route('teacher.create')}}" class="btn btn-primary mt-2"> Add Teacher</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
          <div class="col-12">


            <div class="card">
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
              <div class="card-header">
                <h3 class="card-title">Teacher  Data</h3><br>




              </div>
              <!-- /.card-header -->
              <div class="card-body">
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>SN</th>
      <th>Image</th> <!-- New column for image -->
      <th>Name</th>
      <th>Class</th>
      <th>Email</th>
      <th>Phone</th>
      <th>DOB</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $item->id }}</td>

        <td>
          @if ($item->image && Storage::disk('public')->exists($item->image))
            <img src="{{ asset('storage/' . $item->image) }}" alt="Teacher Image" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
          @else
            N/A
          @endif
        </td>

        <td>{{ $item->name }}</td>
        <td>{{ $item->classes ? $item->classes->name : 'N/A' }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->phone }}</td>
        <td>{{ $item->dob }}</td>

        <td>
          <a href="{{ route('teacher.edit', $item->id) }}" class="badge badge-warning">edit</a>
          <a href="{{ route('teacher.delete', $item->id) }}" onclick="return confirm('Are you sure want to delete?')" class="badge badge-danger">delete</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection

  @section('customJs')
      <!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      buttons: [
        {
          extend: 'copy',
          exportOptions: {
            columns: ':not(:last-child)'
          }
        },
        {
          extend: 'csv',
          exportOptions: {
            columns: ':not(:last-child)'
          }
        },
        {
          extend: 'excel',
          exportOptions: {
            columns: ':not(:last-child)'
          }
        },
        {
          extend: 'pdf',
          exportOptions: {
            columns: ':not(:last-child)'
          }
        },
        {
          extend: 'print',
          exportOptions: {
            columns: ':not(:last-child)'
          }
        },
        'colvis'
      ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
      paging: true,
      lengthChange: false,
      searching: false,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
    });
  });
</script>
  @endsection


