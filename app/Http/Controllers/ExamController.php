<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = Classes::all();
        return view('admin.exam.exam',compact('class'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function read(Request $request)
    {
    $query = Exam::query()->with('classes');

    // Apply filters based on request
    if ($request->filled('class_id')) {
        $query->where('class_id', $request->class_id);
    }


    $data = $query->get();
    $class = Classes::all();


    return view('admin.exam.exam_list', compact('data', 'class'));
   }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'name' => 'required',
            'term' => 'required',
            'date' => 'required',
        ]);

        $data = new Exam();
        $data->class_id = $request->class_id;
        $data->name = $request->name;
        $data->term = $request->term;
        $data->date = $request->date;

        $data->save();
        return redirect()->back()->with('success','Exam Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {

        $data = Exam::find($id);
        $class = Classes::all();
        return view('admin.exam.exam_edit', compact('data','class'));



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {



        $request->validate([
            'class_id' => 'required',
            'name' => 'required',
            'term' => 'required',
            'date' => 'required',
        ]);

        $data = Exam::with('classes')->find($request->id);

        $data->class_id = $request->class_id;
        $data->name = $request->name;
        $data->term = $request->term;
        $data->date = $request->date;

        $data->update();
        return redirect()->route('exam.read')->with('success', 'Exam updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = Exam::find($id);
        $data->delete();
        return redirect()->route('exam.read')->with('success', 'Exam deleted successfully!');
    }
}
