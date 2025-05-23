<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AssignTeacherToClass;
use App\Models\ExamResult;
use App\Models\TimeTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentExamGrade;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function dashboard()
{
    // latest student-specific announcement
    $data = Announcement::where('type', 'student')
                        ->latest()
                        ->limit(1)
                        ->get();

    // grab the currently-logged-in student via the 'student' guard
    $student = auth('student')->user();

    // use optional() so we don't call ->id on null
    $classId = optional($student->classes)->id;

    // if they really have no class, bail out
    if (! $classId) {
        return redirect()->back()
                         ->with('error', 'You are not assigned to any class yet.');
    }

    // count subjects assigned to this class
    $subjectCount = AssignTeacherToClass::where('class_id', $classId)
                        ->with(['classes', 'user', 'subject'])
                        ->count();

    return view('student.dashboard', [
        'data'    => $data,
        'subject' => $subjectCount,
    ]);
}



    public function mySubject()
{
    $student = auth('student')->user();

    if (!$student->classes) {
        return redirect()->back()->with('error', 'You are not assigned to any class.');
    }

    $class_id = $student->classes->id;

    $data = AssignTeacherToClass::with('classes', 'user', 'subject')
        ->where('class_id', $class_id)
        ->get();

    return view('student.my_subject', compact('data'));
}


 public function examResult()
{
    $user_id = auth('student')->user()->id;

    // Fetch all individual subject results for the student
    $data = ExamResult::with('exam', 'user', 'subject')
        ->where('user_id', $user_id)
        ->get();

    // Fetch the student's average scores and grades per exam
    $averages = StudentExamGrade::with('exam')
        ->where('user_id', $user_id)
        ->get();

    return view('student.exam_result', compact('data', 'averages'));
}


     public function myTimeTable()
     {
         $class_id = auth('student')->user()->classes->id;
         $data = TimeTable::with('classes','subject')->where('class_id', $class_id)->get();
        //  dd($data);
         return view('student.my_TimeTable', compact('data'));
     }




}
