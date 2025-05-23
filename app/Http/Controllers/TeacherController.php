<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AssignTeacherToClass;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\TimeTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $class = Classes::all();
        return view('admin.teacher.teacher',compact('class'));
    }

    public function mySubject()
    {
        $user_id = Auth::guard('teacher')->user()->id;
        $data = AssignTeacherToClass::with('classes','subject')->where('user_id', $user_id)->
        with('subject','classes')->get();
       //  dd($data);
        return view('teacher.my_subject', compact('data'));
    }

    public function changePassword()
     {
         return view('teacher.change_password');
     }

     public function updatePassword(Request $request)
     {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user = User::find(Auth::guard('teacher')->user()->id);

        if (Hash::check($old_password, $user->password)) {
            $user->password = $request->new_password;
            $user->update();
            return redirect()->back()->with('success', 'Password update successfully!');
        }else {
            return redirect()->back()->with('error', 'Old password doesnt match!');
        }
     }

    public function myTimeTable()
    {
        // $class_id = Auth::user()->classes->id;
        $class_id = Auth::guard('teacher')->user()->classes->id;
        $data = TimeTable::with('classes','subject')->where('class_id', $class_id)->get();
       
        return view('teacher.my_TimeTable', compact('data'));
    }

    public function dashboard()
     {
        $user = Auth::guard('teacher')->user();
         $data = Announcement::where('type','teacher')->latest()->limit(1)->get();
          $class_id = Auth::guard('teacher')->user()->classes->id;
          $class = AssignTeacherToClass::with('classes')->where('class_id', $class_id)->count();
          $subject = AssignTeacherToClass::with('classes','user')->where('class_id', $class_id)->
          with('subject')->count();
         return view('teacher.dashboard', compact('data','user','subject','class'));
        
     }

     public function logout(){
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher.login')->with('success','Logged out successfully');
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
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'dob' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
    'phone' => ['required', 'regex:/^(?:\+255|0)(7|6|5|4|2)\d{8}$/'], // Tanzanian phone validation
    'password' => 'required|string',
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
]);


    $data = new User();
    $data->class_id = $request->class_id;
    $data->name = $request->name;
    $data->email = $request->email;
    $data->dob = $request->dob;
    $data->phone = $request->phone;
    $data->role = 'teacher';
    $data->password = Hash::make($request->password);

    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('teachers', 'public');
        $data->image = $imagePath;
    }

    $data->save();

    return redirect()->route('teacher.create')->with('success', 'Teacher Added Successfully!');
}

    public function read()
    {
    $data = User::where('role','teacher')->get();

    return view('admin.teacher.teacher_list', compact('data'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $data = User::find($id);
        $class = Classes::get();
        return view('admin.teacher.teacher_edit', compact('data','class'));

    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request)
{
    $request->validate([
        'class_id' => 'sometimes|required',
        'name' => 'sometimes|string|max:255',
        'email' => ['sometimes', 'email', 'unique:users,email,' . $request->id],
        'dob' => ['sometimes', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
        'phone' => ['sometimes', 'required', 'regex:/^(?:\+255|0)(7|6|5|4|2)\d{8}$/'],
        'password' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = User::findOrFail($request->id);

    if ($request->has('class_id')) {
        $data->class_id = $request->class_id;
    }
    if ($request->has('name')) {
        $data->name = $request->name;
    }
    if ($request->has('email')) {
        $data->email = $request->email;
    }
    if ($request->has('dob')) {
        $data->dob = $request->dob;
    }
    if ($request->has('phone')) {
        $data->phone = $request->phone;
    }
    if ($request->filled('password')) {
        $data->password = Hash::make($request->password);
    }

    // Handle image update
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($data->image && \Storage::disk('public')->exists($data->image)) {
            \Storage::disk('public')->delete($data->image);
        }
        // Store new image
        $imagePath = $request->file('image')->store('teachers', 'public');
        $data->image = $imagePath;
    }

    $data->save();

    return redirect()->route('teacher.read')->with('success', 'Teacher Updated Successfully!');
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

    return redirect()->route('teacher.read')->with('success', 'Teacher Deleted Successfully!');
}

    public function login()
    {
        return view('teacher.login');
    }

    public function authenticate(Request $req){
        $req->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('teacher')->attempt(['email' => $req->email, 'password' => $req->password])) {
            if (Auth::guard('teacher')->user()->role != 'teacher') {
                Auth::guard('teacher')->logout();
                return redirect()->route('teacher.login')->with('error','unauthorized user. Access denied');
            }
            return redirect()->route('teacher.dashboard');
        }else {
            return redirect()->route('teacher.login')->with('error','something went wrong');
        }

    }
}
