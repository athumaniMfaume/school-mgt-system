<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
    'dob' => ['required', 'date', 'before_or_equal:' . now()->subYears(12)->format('Y-m-d')],
    'father_name' => 'required',
    'mother_name' => 'required',
    'phone' => ['required', 'regex:/^(?:\+255|0)(7|6|5|4|2)\d{8}$/'],
    'admission_date' => 'required|date|after_or_equal:today',
    'password' => 'required|min:6',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
], [
    'dob.before_or_equal' => 'The student must be at least 12 years old.',
    'admission_date.after_or_equal' => 'The admission date cannot be before today.',
    'phone.regex' => 'Please enter a valid Tanzanian phone number, starting with +255 or 0, followed by 9 digits.',
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

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('students', $filename, 'public');
        $data->image = $path;
    }

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
        'class_id' => 'sometimes',
        'academic_year_id' => 'sometimes',
        'name' => 'sometimes',
        'dob' => ['sometimes', 'date', 'before_or_equal:' . now()->subYears(12)->format('Y-m-d')],
        'phone' => ['sometimes', 'regex:/^(?:\+255|0)(7|6|5|4|2)\d{8}$/'],
        'email' => ['sometimes', 'email', 'unique:users,email,' . $request->id],
        'admission_date' => ['sometimes', 'date', 'after_or_equal:today'],
        'father_name' => 'sometimes',
        'mother_name' => 'sometimes',
        'password' => 'sometimes',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
        'dob.before_or_equal' => 'The student must be at least 12 years old.',
        'phone.regex' => 'Please enter a valid Tanzanian phone number, starting with +255 or 0, followed by 9 digits.',
        'admission_date.after_or_equal' => 'The admission date cannot be before today.',
    ]);

    $data = User::findOrFail($request->id);

    $data->class_id = $request->class_id;
    $data->academic_year_id = $request->academic_year_id;
    $data->name = $request->name;
    $data->email = $request->email;
    $data->dob = $request->dob;
    $data->father_name = $request->father_name;
    $data->mother_name = $request->mother_name;
    $data->phone = $request->phone;
    $data->admission_date = $request->admission_date;
    if ($request->filled('password')) {
    $data->password = Hash::make($request->password);
}

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($data->image && Storage::disk('public')->exists($data->image)) {
            Storage::disk('public')->delete($data->image);
        }

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('students', $filename, 'public');
        $data->image = $path;
    }

    $data->update();

    return redirect()->route('student.read')->with('success', 'Student Updated Successfully!');
}

    /**
     * Remove the specified resource from storage.
     */

public function delete($id)
{
    $data = User::findOrFail($id);

    // Delete image file if exists
    if ($data->image && Storage::disk('public')->exists($data->image)) {
        Storage::disk('public')->delete($data->image);
    }

    $data->delete();

    return redirect()->route('student.read')->with('success', 'Student Deleted Successfully!');
}
}
