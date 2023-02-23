<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.users.newUser',[]));
        }
        return view('frontend.users.newUser');
    }
    public function editUsers(Request $req)
    {
        $users = User::all();
        if ($req->ajax()) {
            return response( getAjaxResponse('frontend.users.editUsers',['users'=>$users]));
        }
        return view('frontend.users.editUsers',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if ($req->password != $req->passwordConfirme) {
            if ($req->ajax()) {
                return response()->json(["passwordError"=>"كلمة المرور غير متطابقة"] , $status = 500);
            }

            return  redirect()->back()->with('errore',"كلمة المرور غير متطابقة")->withInput();
        }
            $data = $req->only('name','email','password');
            $dataValidated = Validator::make($data,[
                'role'=>'in:acountant,waiter',
                'name' =>'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ])->validate();
            $dataValidated['password']=Hash::make($dataValidated['password']);
            $user = User::create($dataValidated);
            if ($req->ajax()) {
                return response()->json(["message"=>"تم إدخال مستخدم جدديد بنجاح"]);
            }
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json(["user"=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->password != $request->passwordConfirme) {
            if ($request->ajax()) {
                return response()->json(["passwordError"=>"كلمة المرور غير متطابقة"] , $status = 500);
            }

            return  redirect()->back()->with('errore',"كلمة المرور غير متطابقة")->withInput();
        }
        $data = $request->only('name','email','password');
        $dataValidated = Validator::make($data,[
            'role'=>'in:acountant,waiter',
            'name' =>'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ])->validate();
        $user = User::find($id);
        $user->name= $request->name;
        $user->email=$request->email;
        $user->password=$request->password;
        $user->role=$request->role;
        $user->update();
        return response()->json(["message"=>'تم التعديل بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(["message"=>' تم حذف المستخدم بنجاح ']);
    }
}
