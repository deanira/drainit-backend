<?php

namespace App\Http\Controllers;

use App\PembaruanPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CustomHelpper;

class PembaruanPengaduanController extends Controller
{
    public function get_by_id_pengaduan($id)
    {
        $data = PembaruanPengaduan::select(
            'id',
            'id_pengaduan',
            'id_petugas as nama_petugas',
            'id_petugas',
            'judul',
            'deskripsi',
            'foto',
            'waktu'
        )->where('id_pengaduan', $id)->orderBy('waktu', 'desc')->get();
        foreach ($data as $d) {
            if (!is_null($d->nama_petugas)) {
                $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
            }
        }
        return $data;
    }

    public function create(request $request)
    {
        $validated = $request->validate([
            'id_pengaduan' => 'required',
            'judul' => 'required',
            'foto' => 'nullable',
            'deskripsi' => 'required'
        ]);
        $validated['id_petugas'] = auth()->user()->id;
        $idPetugas = DB::table('pengaduans')->where('id', $validated['id_pengaduan'])->first()->id_petugas;

        if ($validated['id_petugas'] == $idPetugas) {
            if (is_null($request->foto)) {
                $validated['foto'] = 'tidak ada';
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

            $data = PembaruanPengaduan::create($validated);

            return response()->json(["message" => "Added Successfully!", "data" => $data, 'status_code' => 201], 201);
        } else {
            return response()->json(["message" => "You don't have access", 'status_code' => 403], 403);
        }
    }
}
