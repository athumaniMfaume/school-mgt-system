@extends('admin.layout')
@section('title')
  Fee Structure List
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
            <h1>Fee Structure</h1>
            <a href="{{route('fee_structure.create')}}" class="btn btn-primary mt-2"> Add Fee Structure</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fee Structure</li>
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
                <h3 class="card-title">Fee Structure  Data</h3><br>

                <form action="{{ route('fee_structure.read') }}" method="GET">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Academic year</label>
                        <select class="form-control" name="academic_year_id" id="">
                          <option value="">Select academic year</option>
                          @foreach ($academic as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>

                          @endforeach
                        </select>
                      </div>
                      @error('academic_year_id')
                          <p class="text-danger">
                            {{$message}}
                          </p>
                      @enderror

                      <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Class</label>
                        <select class="form-control" name="class_id" id="">
                          <option value="">Select class</option>
                          @foreach ($class as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>

                          @endforeach
                        </select>
                      </div>
                      @error('class_id')
                          <p class="text-danger">
                            {{$message}}
                          </p>
                      @enderror
                      <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-success">Filter Data</button>
                      </div>

                    </form>


              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SN</th>
                    <th>Academic Year</th>
                    <th>Class</th>
                    <th>Fee Head</th>
                    <th>April</th>
                    <th>May</th>
                    <th>June</th>
                    <th>July</th>
                    <th>August</th>
                    <th>September</th>
                    <th>October</th>
                    <th>November</th>
                    <th>December</th>
                    <th>January</th>
                    <th>February</th>
                    <th>March</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->academic_year->name}}</td>
                            <td>{{$item->classes->name}}</td>
                            <td>{{$item->fee_head->name}}</td>
                            <td>{{$item->april}}</td>
                            <td>{{$item->may}}</td>
                            <td>{{$item->june}}</td>
                            <td>{{$item->july}}</td>
                            <td>{{$item->august}}</td>
                            <td>{{$item->september}}</td>
                            <td>{{$item->october}}</td>
                            <td>{{$item->november}}</td>
                            <td>{{$item->december}}</td>
                            <td>{{$item->january}}</td>
                            <td>{{$item->february}}</td>
                            <td>{{$item->march}}</td>

                            <td>
                                                               <a href="{{route('fee_structure.edit',$item->id)}}" class="badge badge-warning">edit</a>
                                <a href="{{route('fee_structure.delete',$item->id)}}" onclick="return confirm('are you sure want to delete?')"
                                     class="badge badge-danger">delete</a>
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


