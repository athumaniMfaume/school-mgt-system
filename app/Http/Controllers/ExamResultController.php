<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required',
            'user_id' => 'required',
            'subject_id' => 'required',
            'score' => 'required',
            'grade' => 'required',

        ]);

        $data = new ExamResult();
        $data->exam_id = $request->exam_id;
        $data->user_id = $request->user_id;
        $data->subject_id = $request->subject_id;
        $data->score = $request->score;
        $data->grade = $request->grade;

        $data->save();
        return redirect()->back()->with('success','Exam Result Added Successfully!');
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
