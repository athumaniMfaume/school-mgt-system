<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    public function authenticate(Request $req)
{
    // Validate incoming request
    $req->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to login as Admin
    if (Auth::guard('admin')->attempt(['email' => $req->email, 'password' => $req->password])) {
        return redirect()->route('admin.dashboard');
    }

    // Attempt to login as Teacher
    if (Auth::guard('teacher')->attempt(['email' => $req->email, 'password' => $req->password])) {
        return redirect()->route('teacher.dashboard');
    }

    // Attempt to login as Student
    if (Auth::guard('student')->attempt(['email' => $req->email, 'password' => $req->password])) {
        return redirect()->route('student.dashboard');
    }

    // If no valid login attempt, redirect with error message
    return redirect('/')->with('error', 'Invalid credentials.');
}


}
