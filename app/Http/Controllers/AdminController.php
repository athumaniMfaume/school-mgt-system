<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','Logged out successfully');
    }

    public function authenticate(Request $req){
        $req->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $req->email, 'password' => $req->password])) {
            if (Auth::guard('admin')->user()->role != 'admin') {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error','unauthorized user. Access denied');
            }
            return redirect()->route('admin.dashboard');
        }else {
            return redirect()->route('admin.login')->with('error','Invalid Credentials!');
        }

    }

    public function changePassword()
    {
        return view('admin.change_password');
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
       $user = User::find(Auth::guard('admin')->user()->id);

       if (Hash::check($old_password, $user->password)) {
           $user->password = $request->new_password;
           $user->update();
           return redirect()->back()->with('success', 'Password update successfully!');
       }else {
           return redirect()->back()->with('error', 'Old password doesnt match!');
       }
    }

    public function register(){
        $user = new User();
        $user->name = 'Student';
        $user->role = 'student';
        $user->email = 'student@gmail.com';
        $user->password = Hash::make('123');
        $user->save();
        return redirect()->route('admin.login')->with('success','user created successfully');
    }

    public function dashboard(){
        $subject = Subject::count();
        $class = Classes::count();
        $teacher = User::where('role','teacher')->count();
        $student = User::where('role','student')->count();
        return view('admin.dashboard',compact('subject','class','teacher','student'));
    }

    public function form(){
        return view('admin.form');
    }

    public function table(){
        return view('admin.table');
    }

        public function profile(){
                if (Auth::guard('admin')->check()) {
                 $id = Auth::guard('admin')->user()->id;
                 $user = User::where('id', $id)->first();
                 return view('admin.profile',compact('user'));
        
    } 
        
    }


}
