<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function sanitizeInput($input = "", $trim = true)
    {
        switch ($trim) {
            case true:
                $data = trim($input);
                $data = htmlspecialchars($input);
                $data = stripslashes($input);
                $data = strip_tags($input);
                break;
            case false:
                $data = htmlspecialchars($input);
                $data = stripslashes($input);
                $data = strip_tags($input);
                break;
            default:
                # code...
                break;
        }
        return $data;
    }

    public function viewLogin()
    {

        if(Auth::check()){
            return view('welcome');
        }
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('view.login')->with('message', "User Logged Out");
    }

    public function login(Request $request)
    {

        if (Auth::check()) {
            return redirect()->route('welcome');
        } else {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8'
            ]);

            $credentials = [
                'email' => $this->sanitizeInput($request->email),
                'password' => $this->sanitizeInput($request->password),
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->route('welcome')->with("message", "You logged in succesfully!");
            } else {
                return redirect()->route('view.login')->withErrors("Invalid Credentials");
            }
        }
    }

    public function viewRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $data = [
            'name' => $this->sanitizeInput($request->name),
            'email' => $this->sanitizeInput($request->email),
            'password' => Hash::make($this->sanitizeInput($request->password))
        ];

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            User::create($data);
            return redirect()->route('view.register')->with("message", "User Registered messagefully!");
        } else {
            return redirect()->route('view.register')->withErrors("Email is already registered!");
        }
    }
}
