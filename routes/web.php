<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignSubjectToClassController;
use App\Http\Controllers\AssignTeacherToClassController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\FeeHeadController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimeTableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamResultController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/login',  [AuthenticateController::class,'login'])->name('login');
Route::post('/login/post',  [AuthenticateController::class,'login_post'])->name('login.post');
Route::get('logout', [AuthenticateController::class,'logout'])->name('logout');

Route::get('/change-password',  [AuthenticateController::class,'changePassword'])->name('change.password');
Route::post('/change-password/post',  [AuthenticateController::class,'updatePassword'])->name('changepassword.post');

Route::get('/forgot-password', [AuthenticateController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/forgot-password/post', [AuthenticateController::class, 'forgotPasswordPost'])->name('forgot.post');

Route::get('/reset-password', [AuthenticateController::class, 'recoverPassword'])->name('recover.password');


Route::post('/reset-password', [AuthenticateController::class, 'recoverPasswordPost'])->name('password.reset');



 Route::get('profile', [AuthenticateController::class,'profile'])->name('profile');
  Route::post('profile/edit', [AuthenticateController::class,'editProfile'])->name('profile.edit');




Route::group(['prefix'=>'student'], function(){


    Route::group(['middleware'=>'student.auth'], function(){
        Route::get('dashboard', [UserController::class,'dashboard'])->name('student.dashboard');
        Route::get('my-subject', [UserController::class,'mySubject'])->name('student.mySubject');
        Route::get('my-TimeTable', [UserController::class,'myTimeTable'])->name('student.myTimeTable');
        Route::get('exam_result', [UserController::class,'examResult'])->name('student.exam_result');

    });

});

Route::group(['prefix'=>'teacher'], function(){


    Route::group(['middleware'=>'teacher.auth'], function(){
        // Dashboard
        Route::get('dashboard', [TeacherController::class,'dashboard'])->name('teacher.dashboard');
        Route::get('my-subject', [TeacherController::class,'mySubject'])->name('teacher.mySubject');
        Route::get('my-TimeTable', [TeacherController::class,'myTimeTable'])->name('teacher.myTimeTable');

        // Change Password

        // Subject

    });

});

Route::group(['prefix'=>'admin'], function(){
 

    Route::group(['middleware'=>'admin.auth'], function(){

        Route::get('dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
        
        Route::get('form', [AdminController::class,'form'])->name('admin.form');
        Route::get('table', [AdminController::class,'table'])->name('admin.table');
        // Academic Year management
        Route::get('academic-year/create', [AcademicYearController::class,'index'])->name('academic-year.create');
        Route::post('academic-year/store', [AcademicYearController::class,'store'])->name('academic-year.store');
        Route::get('academic-year/read', [AcademicYearController::class,'read'])->name('academic-year.read');
        Route::get('academic-year/delete/{id}', [AcademicYearController::class,'delete'])->name('academic-year.delete');
        Route::get('academic-year/edit/{id}', [AcademicYearController::class,'edit'])->name('academic-year.edit');
        Route::post('academic-year/update', [AcademicYearController::class,'update'])->name('academic-year.update');


         // Class management
         Route::get('classes/create', [ClassesController::class,'index'])->name('class.create');
         Route::post('classes/store', [ClassesController::class,'store'])->name('class.store');
         Route::get('classes/read', [ClassesController::class,'read'])->name('class.read');
         Route::get('classes/delete/{id}', [ClassesController::class,'delete'])->name('class.delete');
         Route::get('classes/edit/{id}', [ClassesController::class,'edit'])->name('class.edit');
         Route::post('classes/update', [ClassesController::class,'update'])->name('class.update');

         // Fee management
         Route::get('fee-head/create', [FeeHeadController::class,'index'])->name('fee.create');
         Route::post('fee-head/store', [FeeHeadController::class,'store'])->name('fee.store');
         Route::get('fee-head/read', [FeeHeadController::class,'read'])->name('fee.read');
         Route::get('fee-head/delete/{id}', [FeeHeadController::class,'delete'])->name('fee.delete');
         Route::get('fee-head/edit/{id}', [FeeHeadController::class,'edit'])->name('fee.edit');
         Route::post('fee-head/update', [FeeHeadController::class,'update'])->name('fee.update');

         // Fee Structure management
         Route::get('fee-structure/create', [FeeStructureController::class,'index'])->name('fee_structure.create');
         Route::post('fee-structure/store', [FeeStructureController::class,'store'])->name('fee_structure.store');
         Route::get('fee-structure/read', [FeeStructureController::class,'read'])->name('fee_structure.read');
         Route::get('fee-structure/delete/{id}', [FeeStructureController::class,'delete'])->name('fee_structure.delete');
         Route::get('fee-structure/edit/{id}', [FeeStructureController::class,'edit'])->name('fee_structure.edit');
         Route::post('fee-structure/update', [FeeStructureController::class,'update'])->name('fee_structure.update');

         // Student management
         Route::get('student/create', [StudentController::class,'index'])->name('student.create');
         Route::post('student/store', [StudentController::class,'store'])->name('student.store');
         Route::get('student/read', [StudentController::class,'read'])->name('student.read');
         Route::get('student/delete/{id}', [StudentController::class,'delete'])->name('student.delete');
         Route::get('student/edit/{id}', [StudentController::class,'edit'])->name('student.edit');
         Route::post('student/update', [StudentController::class,'update'])->name('student.update');

         // Announcement management
         Route::get('announcement/create', [AnnouncementController::class,'index'])->name('announcement.create');
         Route::post('announcement/store', [AnnouncementController::class,'store'])->name('announcement.store');
         Route::get('announcement/read', [AnnouncementController::class,'read'])->name('announcement.read');
         Route::get('announcement/delete/{id}', [AnnouncementController::class,'delete'])->name('announcement.delete');
         Route::get('announcement/edit/{id}', [AnnouncementController::class,'edit'])->name('announcement.edit');
         Route::post('announcement/update', [AnnouncementController::class,'update'])->name('announcement.update');

         // Subject management
         Route::get('subject/create', [SubjectController::class,'index'])->name('subject.create');
         Route::post('subject/store', [SubjectController::class,'store'])->name('subject.store');
         Route::get('subject/read', [SubjectController::class,'read'])->name('subject.read');
         Route::get('subject/delete/{id}', [SubjectController::class,'delete'])->name('subject.delete');
         Route::get('subject/edit/{id}', [SubjectController::class,'edit'])->name('subject.edit');
         Route::post('subject/update', [SubjectController::class,'update'])->name('subject.update');

          // Exam management
          Route::get('exam/create', [ExamController::class,'index'])->name('exam.create');
          Route::post('exam/store', [ExamController::class,'store'])->name('exam.store');
          Route::get('exam/read', [ExamController::class,'read'])->name('exam.read');
          Route::get('exam/delete/{id}', [ExamController::class,'delete'])->name('exam.delete');
          Route::get('exam/edit/{id}', [ExamController::class,'edit'])->name('exam.edit');
          Route::post('exam/update', [ExamController::class,'update'])->name('exam.update');

          // Exam Result management
          Route::get('exam_result/create', [ExamResultController::class,'index'])->name('exam_result.create');
          Route::post('exam_result/store', [ExamResultController::class,'store'])->name('exam_result.store');
          Route::get('exam_result/read', [ExamResultController::class,'read'])->name('exam_result.read');
          Route::get('exam_result/delete/{id}', [ExamResultController::class,'delete'])->name('exam_result.delete');
          Route::get('exam_result/edit/{id}', [ExamResultController::class,'edit'])->name('exam_result.edit');
          Route::post('exam_result/update', [ExamResultController::class,'update'])->name('exam_result.update');

         // Assign Subject To Class management
         Route::get('subject_class/create', [AssignSubjectToClassController::class,'index'])->name('subject_class.create');
         Route::post('subject_class/store', [AssignSubjectToClassController::class,'store'])->name('subject_class.store');
         Route::get('subject_class/read', [AssignSubjectToClassController::class,'read'])->name('subject_class.read');
         Route::get('subject_class/delete/{id}', [AssignSubjectToClassController::class,'delete'])->name('subject_class.delete');
         Route::get('subject_class/edit/{id}', [AssignSubjectToClassController::class,'edit'])->name('subject_class.edit');
         Route::post('subject_class/update', [AssignSubjectToClassController::class,'update'])->name('subject_class.update');

          // Teacher management
          Route::get('teacher/create', [TeacherController::class,'index'])->name('teacher.create');
          Route::post('teacher/store', [TeacherController::class,'store'])->name('teacher.store');
          Route::get('teacher/read', [TeacherController::class,'read'])->name('teacher.read');
          Route::get('teacher/delete/{id}', [TeacherController::class,'delete'])->name('teacher.delete');
          Route::get('teacher/edit/{id}', [TeacherController::class,'edit'])->name('teacher.edit');
          Route::post('teacher/update', [TeacherController::class,'update'])->name('teacher.update');

          // Assign Teacher To Class management
         Route::get('teacher_class/create', [AssignTeacherToClassController::class,'index'])->name('teacher_class.create');
         Route::post('teacher_class/store', [AssignTeacherToClassController::class,'store'])->name('teacher_class.store');
         Route::get('teacher_class/read', [AssignTeacherToClassController::class,'read'])->name('teacher_class.read');
         Route::get('teacher_class/delete/{id}', [AssignTeacherToClassController::class,'delete'])->name('teacher_class.delete');
         Route::get('teacher_class/edit/{id}', [AssignTeacherToClassController::class,'edit'])->name('teacher_class.edit');
         Route::post('teacher_class/update', [AssignTeacherToClassController::class,'update'])->name('teacher_class.update');

         // TimeTable management
         Route::get('time_table/create', [TimeTableController::class,'index'])->name('time_table.create');
         Route::post('time_table/store', [TimeTableController::class,'store'])->name('time_table.store');
         Route::get('time_table/read', [TimeTableController::class,'read'])->name('time_table.read');
         Route::get('time_table/delete/{id}', [TimeTableController::class,'delete'])->name('time_table.delete');
         // Change edit route to accept class_id instead of id
Route::get('time_table/edit/{id}', [TimeTableController::class,'edit'])->name('time_table.edit');
;
         Route::post('time_table/update', [TimeTableController::class,'update'])->name('time_table.update');


        });
});



