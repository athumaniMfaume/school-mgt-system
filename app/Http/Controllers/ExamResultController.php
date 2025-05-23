<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StudentExamGrade;


class ExamResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = User::where('role','student')->get();
        $exam = Exam::all();
        $subject = Subject::all();
        return view('admin.exam_result.exam_result',compact('student','exam','subject'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

   public static function calculateGrade($score)
{
    if ($score >= 90) return 'A';
    elseif ($score >= 80) return 'B';
    elseif ($score >= 70) return 'C';
    elseif ($score >= 60) return 'D';
    elseif ($score >= 50) return 'E';
    else return 'F';
}




    public function store(Request $request)
{
    $request->validate([
        'exam_id' => 'required',
        'user_id' => 'required',
        'subject_id' => 'required',
        'score' => 'required|numeric|min:0|max:100',
    ]);

    // Store individual score
    $result = new ExamResult();
    $result->exam_id = $request->exam_id;
    $result->user_id = $request->user_id;
    $result->subject_id = $request->subject_id;
    $result->score = $request->score;
    $result->grade = $this->calculateGrade($request->score);
    $result->save();

    // ✅ Step 1: Get all subject_ids the student has results for in this exam
    $subjectIds = ExamResult::where('user_id', $request->user_id)
        ->where('exam_id', $request->exam_id)
        ->pluck('subject_id')
        ->unique();

    $subjectAverages = [];

    // ✅ Step 2: Calculate average score for each subject
    foreach ($subjectIds as $subjectId) {
        $avg = ExamResult::where('user_id', $request->user_id)
            ->where('exam_id', $request->exam_id)
            ->where('subject_id', $subjectId)
            ->avg('score');

        $subjectAverages[] = $avg;
    }

    // ✅ Step 3: Calculate total average across all subjects
    $totalAverage = count($subjectAverages) > 0
        ? array_sum($subjectAverages) / count($subjectAverages)
        : 0;

    // ✅ Step 4: Convert total average to grade
    $finalGrade = $this->calculateGrade($totalAverage);

    // ✅ Step 5: Save or update in student exam summary table
    StudentExamGrade::updateOrCreate(
        ['user_id' => $request->user_id, 'exam_id' => $request->exam_id],
        ['average_score' => $totalAverage, 'grade' => $finalGrade]
    );

    return redirect()->back()->with('success', 'Score saved and grade updated!');
}



    public function read(Request $request)
    {
    $query = ExamResult::query()->with('user','exam','subject');

    // Apply filters based on request
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }


    $data = $query->get();
    $user = User::where('role','student')->get();


    return view('admin.exam_result.exam_result_list', compact('data', 'user'));
   }

    /**
     * Display the specified resource.
     */
    public function show(ExamResult $examResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {

        $data = ExamResult::with('user','exam','subject')->find($id);
        $subject = Subject::all();
        $exam = Exam::all();
        $student = User::where('role','student')->get();
        return view('admin.exam_result.exam_result_edit', compact('data','exam','subject','student'));



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {



        $request->validate([
            'exam_id' => 'required',
            'user_id' => 'required',
            'subject_id' => 'required',
            'score' => 'required',
            'grade' => 'required',
        ]);

        $data = ExamResult::find($request->id);

        $data->exam_id = $request->exam_id;
        $data->user_id = $request->user_id;
        $data->subject_id = $request->subject_id;
        $data->score = $request->score;
        $data->grade = $request->grade;


        $data->update();
        return redirect()->route('exam_result.read')->with('success', 'Exam Result updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = ExamResult::find($id);
        $data->delete();
        return redirect()->route('exam_result.read')->with('success', 'Exam Result deleted successfully!');
    }
}
