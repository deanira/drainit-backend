<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        return Admin::all();
    }

    public function show($id){
        return Admin::find($id);
    }

    public function profile(){
        $id = auth()->user()->id;
        return Admin::find($id);
    }

    public function register(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|max:55',
            'email' => 'email|required|unique:admins',
            'password'=> 'required|confirmed',
            'no_hp'=> 'required'
        ]);

        $validateData['password'] = Hash::make($request->password);

        $user = Admin::create($validateData);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['message'=>'account created successfully!','user'=>$user,'access_token'=>$accessToken],201);
        
    }
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password'=> 'required'
        ]);
        $user = Admin::where('email',$loginData['email'])->first();

        if(!$user || Hash::check($user->password, $request->password)){
            return response(['message'=>'invalid credentials']);
        }

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['message'=>'log in successfully!','user'=>$user,'access_token'=>$accessToken],200);
    }
    public function update(request $request){
        $validateData = $request->validate([
            'nama' => 'required|max:55',
            'email' => 'email|required',
            'password'=> 'required|confirmed',
            'no_hp'=> 'required'
        ]);
        $id = auth()->user()->id;

        $data = Admin::find($id);
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->save();

        return response()->json(["message" => "Data Updated Successfully!", "data" => $data],200);
    }

    public function delete($id){
        $data = Admin::find($id);
        $data->delete();

        return response()->json(null,204);
    }
}
