<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function register() {
        return view('registration');
    }
    public function login(Request $request){
        if(Auth::check()){
            return redirect()->route('dashboards')->with('fail', 'login failed, please logout first');
        }
        $validated = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if($validated->fails()){
            return redirect()->route('home')->withErrors($validated)->withInput();
        }

        $user = User::where('email', $request->email)->first();
        if($user){
            $password_check = Hash::check($request->password, $user->password);
            if($password_check){
                Auth::login($user);
                return redirect()->route('dashboards')->with('success', 'login successful');
            }else{
                return redirect()->route('home')->with('fail', 'login failed');
            }
        }else{
            return redirect()->route('home')->with('fail', 'login failed');
        }

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home')->with('success', 'logout success');
    }

    public function registration_submit(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'address' => 'required|min:1',
            'mobile' => 'required|integer|min:10',
            'gender' => 'required'
        ]);

        if($validated->fails()){
            return redirect()->route('register')->withErrors($validated);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'gender' => $request->gender
        ]);

        if($user && $student){
            return redirect()->route('home')->with('success', 'Registration Success');
        }
    }

    public function view_categories(){
        $categories = Category::all();
        return view('teachers.view_categories', compact('cateogries'));
    }
}
