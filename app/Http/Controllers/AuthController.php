<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // admin login
    public function adminLogin()
    {
        return view('login', ['role' => 'admin']);
    }

    // student login
    public function studentLogin()
    {
        return view('login', ['role' => 'student']);
    }

    // student register
    public function studentRegister()
    {
        return view('register');
    }

    // student store
    public function studentStore(Request $request)
    {
        // validate request
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'campus' => 'required',
            'college' => 'required',
            'program' => 'required',
            'major' => 'required',
            'guardian_name' => 'required',
            'guardian_contact' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',

        ]);

        // create student
        $student = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student',
        ]);

        // create student data
        $student->studentData()->create([
            'campus' => $request->campus,
            'college' => $request->college,
            'program' => $request->program,
            'major' => $request->major,
            'guardian_name' => $request->guardian_name,
            'guardian_contact' => $request->guardian_contact,
        ]);

        // login student
        auth()->login($student);

        // redirect student
        return redirect()->route('student.dashboard');
    }

    // organization login
    public function organizationLogin()
    {
        return view('login', ['role' => 'organization']);
    }

    // authenticate user
    public function authenticate(Request $request)
    {
        // validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // check user
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return back()->withErrors(['error' => 'Invalid credentials']);
        }

        // redirect user
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        } elseif ($user->role === 'organization') {
            return redirect()->route('organization.dashboard');
        } else {
            return back()->withErrors(['error' => 'Invalid credentials']);
        }
    }

    // student signup
    public function studentSignup()
    {
        return view('signup');
    }

    // register student
    public function registerStudent(Request $request)
    {
        // validate request


        // create student


        // login student


        // redirect student

    }


    // logout
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
