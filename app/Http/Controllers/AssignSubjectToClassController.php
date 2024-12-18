<?php

namespace App\Http\Controllers;

use App\Models\AssignSubjectToClass;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Http\Request;

class AssignSubjectToClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = Classes::all();
        $subject = Subject::all();

        return view('admin.assign_subject_class.assign_subject_class',compact('class','subject'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function read(Request $request)
    {
    $query = AssignSubjectToClass::query()->with('classes');

    // Apply filters based on request
    if ($request->filled('class_id')) {
        $query->where('class_id', $request->class_id);
    }


    $data = $query->get();
    $class = Classes::all();


    return view('admin.assign_subject_class.assign_subject_class_list', compact('data', 'class'));
   }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
        ]);

        $class_id = $request->class_id;
        $subject_id = $request->subject_id;

        foreach ($subject_id as $subject_id) {
            AssignSubjectToClass::updateOrCreate(
                [
                'class_id' => $class_id,
                'subject_id' => $subject_id
                ]);
        }


        return redirect()->back()->with('success', 'Subject Class Assign Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignSubjectToClass $assignSubjectToClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $data = AssignSubjectToClass::with('subject','classes')->find($id);
        $class = Classes::get();
        $subject = Subject::get();
        return view('admin.assign_subject_class.assign_subject_class_edit', compact('data','class','subject'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',

        ]);

        $data = AssignSubjectToClass::find($request->id);
        $data->class_id = $request->class_id;
        $data->subject_id = $request->subject_id;


        $data->update();

        return redirect()->route('subject_class.read')->with('success', 'Subject Class Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = AssignSubjectToClass::findOrFail($id);
        $data->delete();
        return redirect()->route('subject_class.read')->with('success', 'Subject Class Deleted Successfully!');
    }
}
