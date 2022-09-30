<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('frontend.defaultLayout.register');
    }
    public function register(Request $req)
    {
        if ($req->password != $req->passwordConfirme) {
        return  redirect()->back()->with('errore',"كلمة المرور غير متطابقة")->withInput();
        }
        $data = $req->only('name','email','password');
        $dataValidated = Validator::make($data,[
            'name' =>'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ])->validate();
        $dataValidated['password']=Hash::make($dataValidated['password']);
        $user = User::create($dataValidated);
        Auth::guard()->login($user);
        return redirect('/');
    }

    public function showLogin()
    {
        return view('frontend.defaultLayout.login');
    }

    public function login(Request $req)
    {
        $data = $req->only('email','password');
        $dataValidated = Validator::make($data,[
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();
        if (!Auth::attempt($dataValidated)) {
            return  redirect()->back()->withInput(['email'])->withErrors(['error'=>'خطأ في اسم المستخدم او كلمة المرور']);
        }
        return redirect('/');
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->flush();
        return redirect('show-login');

    }

}
