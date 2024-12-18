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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function dashboard()
     {
         $data = Announcement::where('type','student')->latest()->limit(1)->get();
         $class_id = Auth::user()->classes->id;
         $subject = AssignTeacherToClass::with('classes','user')->where('class_id', $class_id)->
         with('subject')->count();

         return view('student.dashboard', compact('data','subject'));
     }

     public function mySubject()
     {
         $class_id = Auth::user()->classes->id;
         $data = AssignTeacherToClass::with('classes','user')->where('class_id', $class_id)->
         with('subject')->get();
        //  dd($data);
         return view('student.my_subject', compact('data'));
     }

     public function examResult()
     {
         $user_id = Auth::user()->id;
         $data = ExamResult::with('exam','user','subject')->where('user_id', $user_id)->get();
         return view('student.exam_result', compact('data'));
     }

     public function myTimeTable()
     {
         $class_id = Auth::user()->classes->id;
         $data = TimeTable::with('classes','subject')->where('class_id', $class_id)->get();
        //  dd($data);
         return view('student.my_TimeTable', compact('data'));
     }

    public function index()
    {
        return view('student.login');
    }

    public function logout()
     {
        Auth::logout();

         return redirect()->route('student.login')->with('success','logout successfully');

     }

     public function changePassword()
     {
         return view('student.change_password');
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
        $user = User::find(Auth::user()->id);

        if (Hash::check($old_password, $user->password)) {
            $user->password = $request->new_password;
            $user->update();
            return redirect()->back()->with('success', 'Password update successfully!');
        }else {
            return redirect()->back()->with('error', 'Old password doesnt match!');
        }
     }

    public function authenticate(Request $req){
        $req->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {

            if (Auth::user()->role != 'student') {
                    Auth::logout();
                    return redirect()->route('student.login')->with('error','unauthorized user. Access denied');
                }
                return redirect()->route('student.dashboard');
            }else {
                return redirect()->route('student.login')->with('error','Email or Password is wrong!');
            }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
