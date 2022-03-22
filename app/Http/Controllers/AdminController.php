<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


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

        return response()->json(['message'=>'account created successfully!','user'=>$user,'access_token'=>$accessToken,'status_code'=>201],201);

    }
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password'=> 'required'
        ]);
        $user = Admin::where('email',$loginData['email'])->first();

        if(!$user || !Hash::check($loginData['password'],$user->password)){
            return response(['message'=>'invalid credentials','status_code'=>401],401);
        }

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['message'=>'log in successfully!','user'=>$user,'access_token'=>$accessToken,'status_code'=>200],200)->setStatusCode(200);
    }
    public function reset_password(request $request){
      $validated = $request->validate([
        'newpassword'=> 'required|confirmed',
        'oldpassword' => 'required'
      ]);
      $id = auth()->user()->id;

      $data = Admin::find($id);
      if(!Hash::check( $validated['oldpassword'],$data->password)){
          return response(['message'=>'password salah','status_code'=>401],401);
      }else{
        $data->password = Hash::make($request->newpassword);
        $data->save();
        return response()->json(["message" => "Password Updated Successfully!",'status_code'=>200],200);
      }

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

        return response()->json(["message" => "Data Updated Successfully!", "data" => $data,'status_code'=>200],200);
    }

    public function delete($id){
        $data = Admin::find($id);
        if($data){
          $data->delete();
        }else{
          return response()->json(['status_code'=>400],400);
        }

        return response()->json(['status_code'=>204],204);
    }

    public function logoutApi()
    {
        $data = DB::table('oauth_access_tokens')->where('user_id', auth()->user()->id);
        if($data){
            $data->delete();
        }
        return response()->json(['status_code'=>200],200);
    }
}
