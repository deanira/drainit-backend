<?php

namespace App\Http\Controllers;

use App\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\CustomHelpper;

class MasyarakatController extends Controller
{
    public function index(){
        return Masyarakat::all();
    }

    public function show($id){
        return Masyarakat::find($id);
    }

    public function profile(){
        $id = auth()->user()->id;
        return Masyarakat::find($id);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:55',
            'email' => 'email|required|unique:masyarakats',
            'password'=> 'required|confirmed',
            'foto'=> 'nullable',
            'no_hp'=> 'required',
            'alamat'=> 'required',
        ]);

        $validated['password'] = Hash::make($request->password);
        if(is_null($request->foto)){
            $validated['foto'] = 'defaultmasyarakat.png';
        }else{
          $fileUploadHelper = new CustomHelpper();

          $encoded_img = $request->foto;
          $decoded = base64_decode($encoded_img);
          $mime_type = finfo_buffer(finfo_open(), $decoded, FILEINFO_MIME_TYPE);
          $extension = $fileUploadHelper->mime2ext($mime_type);
          $file = uniqid() .'.'. $extension;
          $file_dir = storage_path('app/public/images/'). $file;
          file_put_contents($file_dir, $decoded);
          $validated['foto'] = $file;
        }

        $user = Masyarakat::create($validated);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['message'=>'account created successfully!','user'=>$user,'access_token'=>$accessToken,'status_code'=>201],201);

    }
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password'=> 'required'
        ]);
        $user = Masyarakat::where('email',$loginData['email'])->first();

        if(!$user || !Hash::check( $loginData['password'],$user->password)){
            return response(['message'=>'invalid credentials','status_code'=>401],401);
        }

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['message'=>'log in successfully!','user'=>$user,'access_token'=>$accessToken,'status_code'=>200],200);
    }
    public function reset_password(request $request){
      $validated = $request->validate([
        'newpassword'=> 'required|confirmed',
        'oldpassword' => 'required'
      ]);
      $id = auth()->user()->id;

      $data = Petugas::find($id);
      if(!Hash::check( $validated['oldpassword'],$data->password)){
          return response(['message'=>'password salah','status_code'=>401],401);
      }else{
        $data->password = Hash::make($request->newpassword);
        $data->save();
        return response()->json(["message" => "Password Updated Successfully!",'status_code'=>200],200);
      }

    }
    public function update(request $request){
        $validated = $request->validate([
            'nama' => 'required|max:55',
            'email' => 'email|required',
            'password'=> 'nullabe|confirmed',
            'foto'=> 'nullable',
            'no_hp'=> 'required',
            'alamat'=> 'required',
        ]);
        $id = auth()->user()->id;

        $data = Masyarakat::find($id);
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->email = $request->email;
        if(!is_null($request->password)){
          $data->password = Hash::make($request->password);
        }
        $data->alamat = $request->alamat;

        if(!is_null($request->foto)){
          $fileUploadHelper = new CustomHelpper();

          $encoded_img = $request->foto;
          $decoded = base64_decode($encoded_img);
          $mime_type = finfo_buffer(finfo_open(), $decoded, FILEINFO_MIME_TYPE);
          $extension = $fileUploadHelper->mime2ext($mime_type);
          $file = uniqid() .'.'. $extension;
          $file_dir = storage_path('app/public/images/'). $file;
          file_put_contents($file_dir, $decoded);
          $data->foto = $file;
        }

        $data->save();

        return response()->json(["message" => "Data Updated Successfully!", "data" => $data,'status_code'=>200],200);
    }

    public function delete($id){
        $data = Masyarakat::find($id);
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
