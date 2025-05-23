@extends('admin.layout')
@section('title')
  Subject List
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
            <h1>Subject List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Subject List</li>
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

               <form action="{{ route('subject.read') }}" method="GET" class="form-row align-items-end">
    <div class="form-group col-md-4">
        <label for="subject-name">Subject</label>
        <select class="form-control" name="name" id="subject-name">
            <option value="" selected>— All Subjects —</option>
            @foreach ($subjects->keys() as $subjectName)
                <option value="{{ $subjectName }}"
                    {{ request('name') === $subjectName ? 'selected' : '' }}>
                    {{ $subjectName }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-4">
        <button type="submit" class="btn btn-success">Filter</button>
        <a href="{{ route('subject.read') }}" class="btn btn-secondary ml-2">Reset</a>
    </div>
</form>
<hr>

                    <a href="{{route('subject.create')}}" class="btn btn-primary"> Add Subject</a>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
               <table class="table">
  <thead>
    <tr>
      <th>S/N</th>
      <th>Subject</th>
      <th>Type</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($subjects as $name => $group)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $name }}</td>
        <td>
          {{-- take the “type” column from each model, unique them, then join with “|” --}}
          {{ $group->pluck('type')->unique()->implode(' | ') }}
        </td>
        <td>
          {{-- if you need per‐type actions, loop again inside --}}
          @foreach($group as $subject)
            <a href="{{ route('subject.edit', $subject->id) }}"
               class="btn btn-sm btn-warning">Edit {{ $subject->type }}</a>
          @endforeach
          {{-- or a single delete that wipes both types: --}}
          <form action="{{ route('subject.delete', $group->first()->id) }}"
                method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger"
                    onclick="return confirm('Delete all types for {{ $name }}?')">
              Delete
            </button>
          </form>
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
            columns: ':not(:last-child)' // Exclude "Actions"
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


