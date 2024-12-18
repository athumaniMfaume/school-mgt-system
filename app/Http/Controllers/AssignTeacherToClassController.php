<?php

namespace App\Http\Controllers;

use App\Models\AssignTeacherToClass;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class AssignTeacherToClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = Classes::all();
        $subject = Subject::all();
        $teacher = User::where('role','teacher')->get();

        return view('admin.assign_teacher_class.assign_teacher_class',compact('class','subject','teacher'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function read(Request $request)
    {
    $query = AssignTeacherToClass::query()->with('classes','user','subject');

    // Apply filters based on request
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }


    $data = $query->get();
    $user = User::where('role','teacher')->get();


    return view('admin.assign_teacher_class.assign_teacher_class_list', compact('data', 'user'));
   }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'user_id' => 'required',
        ]);

        $class_id = $request->class_id;
        $subject_id = $request->subject_id;
        $user_id = $request->user_id;

        foreach ($subject_id as $subject_id) {
            AssignTeacherToClass::updateOrCreate(
                [
                'class_id' => $class_id,
                'subject_id' => $subject_id,
                'user_id' => $user_id,
                ]);
        }


        return redirect()->back()->with('success', 'Subject Class Assign Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignTeacherToClass $assignTeacherToClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $data = AssignTeacherToClass::with('subject','classes','user')->find($id);
        $class = Classes::get();
        $subject = Subject::get();
        $user = User::where('role','teacher')->get();
        return view('admin.assign_teacher_class.assign_teacher_class_edit', compact('data','class','subject','user'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'user_id' => 'required',

        ]);

        $data = AssignTeacherToClass::find($request->id);
        $data->class_id = $request->class_id;
        $data->subject_id = $request->subject_id;
        $data->user_id = $request->user_id;


        $data->update();

        return redirect()->route('teacher_class.read')->with('success', 'Teacher Class Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = AssignTeacherToClass::findOrFail($id);
        $data->delete();
        return redirect()->route('teacher_class.read')->with('success', 'Teacher Class Deleted Successfully!');
    }
}
