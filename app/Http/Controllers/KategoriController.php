<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Kategori::all();
    }

    public function show($id)
    {
        return Kategori::find($id);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|unique:kategoris'
        ]);

        $data = Kategori::create($validated);
        return response()->json(['message'=>'Kategori created successfully!','kategori'=>$data,'status_code'=>201],201);

    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori' => 'required|unique:kategoris'
        ]);

        $data = Kategori::find($id);
        $data->kategori = $validated['kategori'];

        $data->save();
        return response()->json(["message" => "Data Updated Successfully!", "data" => $data,'status_code'=>200],200);
    }
    public function delete($id)
    {
        $data = Kategori::find($id);
        if($data){
          $data->delete();
        }else{
          return response()->json(['status_code'=>400],400);
        }

        return response()->json(['status_code'=>204],204);
    }
}
