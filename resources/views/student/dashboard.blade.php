@extends('student.layout')
@section('title')
  Student | Dashboard
@endsection
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @foreach ($data as $item)
                   <div class="alert alert-warning">
                    <marquee behavior="" direction="">{{$item->message}}</marquee>

                   </div>

                @endforeach
            </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
@php
    use Carbon\Carbon;
    $student = auth('student')->user();
@endphp

@if(
    $student 
    && Carbon::parse($student->dob)
         ->setTimezone(config('app.timezone'))
         ->isBirthday()
)
    <div class="alert alert-success">
        🎉 Happy Birthday, {{ $student->name }}! 🎂
    </div>
@endif
          </div><!-- /.col -->
      
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$subject}}</h3>

                <p>Total Subject</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{route('student.mySubject')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        
        </div>
        <!-- /.row -->
        <!-- Main row -->
        {{-- <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sales
                </h3>
              
            </div>
            <!-- /.card -->

          
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

         

            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
               
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div> --}}
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  @endsection
