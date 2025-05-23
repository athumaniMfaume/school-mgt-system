@extends('student.layout')
@section('title')
Student Exam Results | Table
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
            <h1>Exam Result</h1>
            {{-- <a href="{{route('exam_result.create')}}" class="btn btn-primary mt-2"> Add Exam Results</a> --}}
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('student.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Exam Results</li>
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

              <div class="card-header">


              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
<h3>Individual Subject Results</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Exam</th>
            <th>Subject</th>
            <th>Score</th>
            <th>Grade</th> <!-- Optional if you want per subject grade -->
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $result)
            <tr>
                <td>{{ $result->exam->name }}</td>
                <td>{{ $result->subject->name }}</td>
                <td>{{ $result->score }}</td>
                <td>{{ \App\Http\Controllers\ExamResultController::calculateGrade($result->score) }}</td> <!-- if calculateGrade is static or move it to helper -->
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Average Scores & Grades per Exam</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Exam</th>
            <th>Average Score</th>
            <th>Final Grade</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($averages as $avg)
            <tr>
                <td>{{ $avg->exam->name }}</td>
                <td>{{ number_format($avg->average_score, 2) }}</td>
                <td>{{ $avg->grade }}</td>
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
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
  @endsection


