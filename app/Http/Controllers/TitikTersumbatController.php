<?php

namespace App\Http\Controllers;

use App\TitikRusak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CustomHelpper;

class TitikTersumbatController extends Controller
{
    public function index(){
        return TitikRusak::select(
            'id',
            'id_admin',
            'nama_jalan',
            'keterangan',
            'status',
            'foto',
            DB::Raw('ST_AsGeoJSON(geometry) as geometry')
        )->get();
    }

    public function show($id){
        return TitikRusak::select(
            'id',
            'id_admin',
            'nama_jalan',
            'keterangan',
            'status',
            'foto',
            DB::Raw('ST_AsGeoJSON(geometry) as geometry')
        )->where('id',$id)->first();;
    }

    public function create(request $request){

        $validated = $request->validate([
            'nama_jalan' => 'required',
            'geometry' => 'required',
            'foto'=> 'required',
            'keterangan' => 'nullable',
            'status'=> 'nullable',
        ]);

        $validated['id_admin'] = auth()->user()->id;
        $validated['geometry'] = DB::Raw("ST_GeomFromGeoJSON('".$request->geometry."')");

        if(is_null($request->foto)){
            $validated['foto'] = 'defaulttersumbat.png';
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

        $data = TitikRusak::create($validated);

        $data->geometry = json_decode($request->geometry);

        return response()->json(["message" => "Data Added Successfully!", "data" => $data,'status_code'=>201],201);
    }

    public function update(request $request, $id){

        $validated = $request->validate([
            'nama_jalan' => 'required',
            'geometry' => 'required',
            'foto'=> 'nullable',
            'keterangan' => 'nullable',
            'status'=> 'nullable',
        ]);

        $data = TitikRusak::find($id);
        $data->id_admin = auth()->user()->id;
        $data->geometry = DB::Raw("ST_GeomFromGeoJSON('".$request->geometry."')");
        $data->nama_jalan = $request->nama_jalan;
        $data->keterangan = $request->keterangan;

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

        $data->geometry = json_decode($request->geometry);

        return response()->json(["message" => "Data Updated Successfully!", "data" => $data,'status_code'=>200],200);
    }

    public function delete($id){
        $data = TitikRusak::find($id);
        if($data){
          $data->delete();
        }else{
          return response()->json(['status_code'=>400],400);
        }

        return response()->json(['status_code'=>204],204);
    }
}
