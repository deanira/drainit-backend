<?php

namespace App\Http\Controllers;

use App\TitikBanjir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CustomHelpper;

class TitikBanjirController extends Controller
{
    /**
     * @OA\Get(
     *     path="/titik_banjir",
     *     @OA\Response(
     *      response="200", 
     *      description="Display a listing of flood points."
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function index()
    {
        return TitikBanjir::select(
            'id',
            'id_admin',
            'nama_jalan',
            'kondisi_kerusakan',
            'foto',
            'keterangan',
            'status',
            DB::Raw('ST_AsGeoJSON(geometry) as geometry')
        )->get();
    }

    public function show($id)
    {
        return TitikBanjir::select(
            'id',
            'id_admin',
            'nama_jalan',
            'kondisi_kerusakan',
            'foto',
            'keterangan',
            'status',
            DB::Raw('ST_AsGeoJSON(geometry) as geometry')
        )->where('id', $id)->first();;
    }

    public function create(request $request)
    {
        $validated = $request->validate([
            'nama_jalan' => 'required',
            'geometry' => 'required',
            'foto' => 'nullable',
            'keterangan' => 'nullable',
            'kondisi_kerusakan' => 'required',
            'status' => 'nullable',
        ]);

        $validated['id_admin'] = auth()->user()->id;
        $validated['geometry'] = DB::Raw("ST_GeomFromGeoJSON('" . $request->geometry . "')");

        if (is_null($request->foto)) {
            $validated['foto'] = 'defaultbanjir.png';
        } else {
            $fileUploadHelper = new CustomHelpper();

            $encoded_img = $request->foto;
            $decoded = base64_decode($encoded_img);
            $mime_type = finfo_buffer(finfo_open(), $decoded, FILEINFO_MIME_TYPE);
            $extension = $fileUploadHelper->mime2ext($mime_type);
            $file = uniqid() . '.' . $extension;
            $file_dir = storage_path('app/public/images/') . $file;
            file_put_contents($file_dir, $decoded);
            $validated['foto'] = $file;
        }


        $data = TitikBanjir::create($validated);

        $data->geometry = json_decode($request->geometry);

        return response()->json(["message" => "Data Added Successfully!", "data" => $data, 'status_code' => 201], 201);
    }

    public function update(request $request, $id)
    {
        $validated = $request->validate([
            'nama_jalan' => 'required',
            'geometry' => 'required',
            'foto' => 'nullable',
            'keterangan' => 'nullable',
            'kondisi_kerusakan' => 'required',
            'status' => 'nullable',
        ]);

        $data = TitikBanjir::find($id);
        $data->id_admin = auth()->user()->id;
        $data->geometry = DB::Raw("ST_GeomFromGeoJSON('" . $request->geometry . "')");
        $data->nama_jalan = $request->nama_jalan;
        $data->kondisi_kerusakan = $request->kondisi_kerusakan;
        $data->keterangan = $request->keterangan;
        if (!is_null($request->foto)) {
            $fileUploadHelper = new CustomHelpper();

            $encoded_img = $request->foto;
            $decoded = base64_decode($encoded_img);
            $mime_type = finfo_buffer(finfo_open(), $decoded, FILEINFO_MIME_TYPE);
            $extension = $fileUploadHelper->mime2ext($mime_type);
            $file = uniqid() . '.' . $extension;
            $file_dir = storage_path('app/public/images/') . $file;
            file_put_contents($file_dir, $decoded);
            $data->foto = $file;
        }
        $data->save();

        $data->geometry = json_decode($request->geometry);

        return response()->json(["message" => "Data Updated Successfully!", "data" => $data, 'status_code' => 200], 200);
    }

    public function delete($id)
    {
        $data = TitikBanjir::find($id);
        if ($data) {
            $data->delete();
        } else {
            return response()->json(['status_code' => 400], 400);
        }

        return response()->json(['status_code' => 204], 204);
    }
}
