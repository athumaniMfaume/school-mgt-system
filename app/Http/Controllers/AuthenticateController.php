<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;



class AuthenticateController extends Controller
{

        public function login()
{

    return view('login');

}


public function login_post(Request $req)
{
    $req->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $req->email)->first();

    if (!$user || !Hash::check($req->password, $user->password)) {
        return redirect('/')->with('error', 'Invalid credentials.');
    }

    // Use the user's role to log in using the correct guard
    $guard = $user->role; // must be 'admin', 'teacher', or 'student'

    if (in_array($guard, ['admin', 'teacher', 'student'])) {
        Auth::guard($guard)->login($user);

        return match ($guard) {
            'admin' => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
        };
    }

    return redirect('/')->with('error', 'Invalid user role.');
}


    public function changePassword()
     {
         return view('change_password');
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

    // Determine the current logged-in guard
    if (Auth::guard('admin')->check()) {
        $user = Auth::guard('admin')->user();
    } elseif (Auth::guard('teacher')->check()) {
        $user = Auth::guard('teacher')->user();
    } elseif (Auth::guard('student')->check()) {
        $user = Auth::guard('student')->user();
    } else {
        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    if (Hash::check($old_password, $user->password)) {
        $user->password = Hash::make($new_password); // Make sure to hash the new password
        $user->save();
        return redirect()->back()->with('success', 'Password updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Old password does not match!');
    }
}

public function logout()
{
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully');
    } elseif (Auth::guard('teacher')->check()) {
        Auth::guard('teacher')->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully');
    } elseif (Auth::guard('student')->check()) {
        Auth::guard('student')->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully');
    } else {
        return redirect()->back()->with('error', 'No active session found');
    }
}

public function forgotPassword()
{
    return view('forgot_password');
}

public function forgotPasswordPost(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', __($status))
        : back()->withErrors(['email' => __($status)]);
}

public function recoverPassword(Request $request)
{
    return view('recover_password', [
        'token' => $request->query('token'),
        'email' => $request->query('email'),
    ]);
}





public function recoverPasswordPost(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    if ($status == Password::PASSWORD_RESET) {
        return redirect()->route('login')->with('success', 'Password reset successfully.');
    } else {
        return back()->withErrors(['email' => __($status)]);
    }
}




public function profile()
{
    if (Auth::guard('admin')->check()) {
        $id = Auth::guard('admin')->user()->id;
        $user = User::where('id', $id)->first();
        return view('admin.profile', compact('user'));
    } elseif (Auth::guard('teacher')->check()) {
        $id = Auth::guard('teacher')->user()->id;
        $user = User::with('classes')->where('id', $id)->first();
        return view('teacher.profile', compact('user'));
    } elseif (Auth::guard('student')->check()) {
        $id = Auth::guard('student')->user()->id;
        $user = User::with('classes')->where('id', $id)->first();
        return view('student.profile', compact('user'));
    } else {
        return redirect()->back()->with('error', 'No active session found');
    }



}




public function editProfile(Request $request)
{
    // Detect user from any guard
    $user = Auth::guard('admin')->user()
         ?? Auth::guard('teacher')->user()
         ?? Auth::guard('student')->user();

    if (!$user) {
        return redirect()->back()->with('error', 'No active session found');
    }

    // Validation
    $request->validate([
        'email' => [
            'required',
            'email',
            Rule::unique('users')->ignore($user->id),
        ],
        'name' => 'required',
    ]);

    // Update
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    $message = match ($user->role) {
        'admin' => 'Admin info updated successfully!',
        'teacher' => 'Teacher info updated successfully!',
        'student' => 'Student info updated successfully!',
        default => 'Info updated successfully!',
    };

    return redirect()->back()->with('success', $message);
}





}
