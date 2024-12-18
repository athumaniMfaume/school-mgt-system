<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = Classes::get();
        $academic = AcademicYear::get();
        return view('admin.student.student',compact('class','academic'));
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
            'class_id' => 'required',
            'academic_year_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'dob' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'phone' => 'required',
            'admission_date' => 'required',
            'password' => 'required',

        ]);

        $data = new User();
        $data->class_id = $request->class_id;
        $data->academic_year_id = $request->academic_year_id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->dob = $request->dob;
        $data->father_name = $request->father_name;
        $data->mother_name = $request->mother_name;
        $data->phone = $request->phone;
        $data->admission_date = $request->admission_date;
        $data->role = 'student';
        $data->password = Hash::make($request->password);


        $data->save();

        return redirect()->route('student.create')->with('success', 'Student Added Successfully!');
    }

    public function read(Request $request)
    {
    $query = User::query()->with( 'academic_year', 'classes')->where('role','student');

    // Apply filters based on request
    if ($request->filled('class_id')) {
        $query->where('class_id', $request->class_id);
    }
    if ($request->filled('academic_year_id')) {
        $query->where('academic_year_id', $request->academic_year_id);
    }

    $data = $query->get();
    $class = Classes::all();
    $academic = AcademicYear::all();

    return view('admin.student.student_list', compact('data', 'class',  'academic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $data = User::with('academic_year','classes')->find($id);
        $class = Classes::get();
        $academic = AcademicYear::get();
        return view('admin.student.student_edit', compact('data','class','academic'));

    }

    public function update(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'academic_year_id' => 'required',
            'name' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'admission_date' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'password' => 'required',

        ]);

        $data = User::find($request->id);
        $data->class_id = $request->class_id;
        $data->academic_year_id = $request->academic_year_id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->dob = $request->dob;
        $data->father_name = $request->father_name;
        $data->mother_name = $request->mother_name;
        $data->phone = $request->phone;
        $data->admission_date = $request->admission_date;
        $data->password = Hash::make($request->password);

        $data->update();

        return redirect()->route('student.read')->with('success', 'Student Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return redirect()->route('student.read')->with('success', 'Student Deleted Successfully!');
    }
}
