<?php

namespace App\Http\Controllers;

use App\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CustomHelpper;
use Illuminate\Support\Facades\Validator;

class PengaduanController extends Controller
{
  public function index()
  {
    $data = Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->orderBy('created_at', 'desc')->get();

    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }

      // $upvote = DB::table('votes')->select('id_pengaduan',DB::raw('count(id_voter) as jumlah_vote'))
      // ->where('vote',1)->groupBy('id_pengaduan')
      // ->having('id_pengaduan',$d->id)->first();
      // if($upvote){
      //   $d->upvote = $upvote->jumlah_vote;
      // }else{
      //   $d->upvote = 0;
      // }

      // $downvote = DB::table('votes')->select('id_pengaduan',DB::raw('count(id_voter) as jumlah_vote'))
      // ->where('vote',0)->groupBy('id_pengaduan')
      // ->having('id_pengaduan',$d->id)->first();
      // if($downvote){
      //   $d->downvote = $downvote->jumlah_vote;
      // }else{
      //   $d->downvote = 0;
      // }

    }
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->orderBy('created_at','desc')->get();
  }

  public function show($id)
  {
    $data = Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )->where('id', $id)->first();

    $data->nama_pelapor = DB::table('masyarakats')->where('id', $data->nama_pelapor)->first()->nama;
    if (!is_null($data->nama_petugas)) {
      $data->nama_petugas = DB::table('petugas')->where('id', $data->nama_petugas)->first()->nama;
    }
    if (!is_null($data->nama_admin)) {
      $data->nama_admin = DB::table('admins')->where('id', $data->nama_admin)->first()->nama;
    }

    // $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
    //   ->where('vote', 1)->groupBy('id_pengaduan')
    //   ->having('id_pengaduan', $data->id)->first();

    // if ($upvote) {
    //   $data->upvote = $upvote->jumlah_vote;
    // } else {
    //   $data->upvote = 0;
    // }

    // $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
    //   ->where('vote', 0)->groupBy('id_pengaduan')
    //   ->having('id_pengaduan', $data->id)->first();
    // if ($downvote) {
    //   $data->downvote = $downvote->jumlah_vote;
    // } else {
    //   $data->downvote = 0;
    // }

    return $data;
  }

  public function get_by_masyarakat()
  {
    $id = auth()->user()->id;
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('id_masyarakat', $id)->orderBy('created_at', 'desc')->get();

    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
    }
    return $data;
  }

  public function get_by_petugas()
  {
    $id = auth()->user()->id;
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('id_petugas', $id)->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('id_petugas',$id)->orderBy('created_at','desc')->get();
  }

  public function create(request $request)
  {
    $validator = Validator::make($request->all(), [
      'nama_jalan' => 'required',
      'foto' => 'nullable',
      'tipe_pengaduan' => 'required',
      'deskripsi_pengaduan' => 'required',
      'geometry' => 'required|JSON'
    ]);
    if ($validator->fails()) {
      return response(['errors' => $validator->errors()->all()], 422);
    }
    $request['id_masyarakat'] = auth()->user()->id;
    $request['status_pengaduan'] = "NOT_YET_VERIFIED";
    $geometry = $request['geometry'];
    $request['geometry'] = DB::Raw("ST_GeomFromGeoJSON('" . $request['geometry'] . "')");

    if (is_null($request->foto)) {
      $request['foto'] = 'defaultpengaduan.png';
    } else {
      $fileUploadHelper = new CustomHelpper();

      $encoded_img = $request->foto;
      $decoded = base64_decode($encoded_img);
      $mime_type = finfo_buffer(finfo_open(), $decoded, FILEINFO_MIME_TYPE);
      $extension = $fileUploadHelper->mime2ext($mime_type);
      $file = uniqid() . '.' . $extension;
      $file_dir = storage_path('app/public/images/') . $file;
      file_put_contents($file_dir, $decoded);
      $request['foto'] = $file;
    }
    $data = Pengaduan::create($request->toArray());
    $data->geometry = $geometry;

    return response()->json(["message" => "Added Successfully!", "data" => $data, "status_code" => 201], 201);
  }

  public function anonim(request $request)
  {
    $validator = Validator::make($request->all(), [
      'nama_jalan' => 'required',
      'foto' => 'nullable',
      'tipe_pengaduan' => 'required',
      'deskripsi_pengaduan' => 'required',
      'geometry' => 'required|JSON'
    ]);
    if ($validator->fails()) {
      return response(['errors' => $validator->errors()->all()], 422);
    }
    $request['status_pengaduan'] = "NOT_YET_VERIFIED";
    $geometry = $request['geometry'];
    $request['geometry'] = DB::Raw("ST_GeomFromGeoJSON('" . $request['geometry'] . "')");

    if (is_null($request->foto)) {
      $request['foto'] = 'defaultpengaduan.png';
    } else {
      $fileUploadHelper = new CustomHelpper();

      $encoded_img = $request->foto;
      $decoded = base64_decode($encoded_img);
      $mime_type = finfo_buffer(finfo_open(), $decoded, FILEINFO_MIME_TYPE);
      $extension = $fileUploadHelper->mime2ext($mime_type);
      $file = uniqid() . '.' . $extension;
      $file_dir = storage_path('app/public/images/') . $file;
      file_put_contents($file_dir, $decoded);
      $request['foto'] = $file;
    }

    $data = Pengaduan::create($request->toArray());
    $data->geometry = $geometry;

    return response()->json(["message" => "Added Successfully!", "data" => $data, "status_code" => 201], 201);
  }

  public function updateAdmin(request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'status_pengaduan' => 'required'
    ]);
    if ($validator->fails()) {
      return response(['errors' => $validator->errors()->all()], 422);
    }
    $data = Pengaduan::select('id', 'id_masyarakat', 'id_admin', 'id_petugas', 'nama_jalan', 'foto', 'tipe_pengaduan', 'deskripsi_pengaduan', 'status_pengaduan', 'feedback_masyarakat', DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('id', $id)->first();

    $data->id_admin = auth()->user()->id;
    $data->status_pengaduan = $request->status_pengaduan;
    $data->save();

    return response()->json(["message" => "Admin, Update Successfully!", "data" => $data, "status_code" => 200], 200);
  }

  public function feedbackMasyarakat(request $request, $id)
  {
    $idMasyarakat = auth()->user()->id;
    $validator = Validator::make($request->all(), [
      'feedback_masyarakat' => 'required',
    ]);
    if ($validator->fails()) {
      return response(['errors' => $validator->errors()->all()], 422);
    }
    $data = Pengaduan::select('id', 'id_masyarakat', 'id_admin', 'id_petugas', 'nama_jalan', 'foto', 'tipe_pengaduan', 'deskripsi_pengaduan', 'status_pengaduan', 'feedback_masyarakat', DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('id', $id)->first();
    if ($idMasyarakat == $data->id_masyarakat) {
      if ($data->status_pengaduan === "DONE") {
        $data->feedback_masyarakat = $request->feedback_masyarakat;
        $data->save();
      } else {
        return response()->json(["message" => "The report hasn't finished yet!", "status_code" => 403], 403);
      }
    } else {
      return response()->json(["message" => "You don't have access", "status_code" => 403], 403);
    }
    return response()->json(["message" => "Feedback Updated Successfully!", "data" => $data, "status_code" => 200], 200);
  }

  public function verify(request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'id_petugas' => 'required',
    ]);
    if ($validator->fails()) {
      return response(['errors' => $validator->errors()->all()], 422);
    }
    $data = Pengaduan::select('id', 'id_masyarakat', 'id_admin', 'id_petugas', 'id_petugas as nama_petugas', 'nama_jalan', 'foto', 'tipe_pengaduan', 'deskripsi_pengaduan', 'status_pengaduan', 'feedback_masyarakat', DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('id', $id)->first();
    $data->status_pengaduan = "ON_PROGRESS";
    $data->id_petugas = $request['id_petugas'];
    $data->save();
    $data->nama_petugas = DB::table('petugas')->where('id', $data->nama_petugas)->first()->nama;

    return response()->json(["message" => "Report is on progress!", "data" => $data, "status_code" => 200], 200);
  }

  public function reject($id)
  {
    $data = Pengaduan::find($id);
    $data->status_pengaduan = "REJECTED";
    $data->save();

    return response()->json(["message" => "Report successfully rejected!", "status_code" => 200], 200);
  }

  public function done($id)
  {
    $idPetugas = auth()->user()->id;
    $data = Pengaduan::find($id);
    if ($idPetugas == $data->id_petugas) {
      $data->status_pengaduan = "DONE";
      $data->save();
    } else {
      return response()->json(["message" => "You don't have access", "status_code" => 403], 403);
    }

    return response()->json(["message" => "Congratulations, the report has been done!", "status_code" => 200], 200);
  }

  public function listwithvote()
  {
    $data = Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->orderBy('created_at', 'desc')->get();

    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }

      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }

      $vote = DB::table('votes')->select('vote')
        ->where('id_pengaduan', $d->id)->where('id_voter', auth()->user()->id)->first();
      if ($vote) {
        $d->vote = $vote->vote;
      } else {
        $d->vote = null;
      }
    }
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->orderBy('created_at','desc')->get();
  }

  public function get_by_petugas_sortedup()
  {
    $id = auth()->user()->id;
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('id_petugas', $id)->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    do {
      $swapped = false;
      for ($i = 0, $c = count($data) - 1; $i < $c; $i++) {
        if ($data[$i]->upvote < $data[$i + 1]->upvote) {
          list($data[$i + 1], $data[$i]) =
            array($data[$i], $data[$i + 1]);
          $swapped = true;
        }
      }
    } while ($swapped);
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('id_petugas',$id)->orderBy('created_at','desc')->get();
  }

  public function get_by_petugas_sorteddown()
  {
    $id = auth()->user()->id;
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('id_petugas', $id)->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    do {
      $swapped = false;
      for ($i = 0, $c = count($data) - 1; $i < $c; $i++) {
        if ($data[$i]->downvote < $data[$i + 1]->downvote) {
          list($data[$i + 1], $data[$i]) =
            array($data[$i], $data[$i + 1]);
          $swapped = true;
        }
      }
    } while ($swapped);
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('id_petugas',$id)->orderBy('created_at','desc')->get();
  }

  public function get_not_assign()
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->whereNull('id_petugas')->where('status_pengaduan', 'Sudah diverifikasi')
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->whereNull('id_petugas')->whereNotNull('id_admin')->orderBy('created_at','desc')->get();
  }

  public function get_not_assign_sortedup()
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->whereNull('id_petugas')->where('status_pengaduan', 'Sudah diverifikasi')
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    do {
      $swapped = false;
      for ($i = 0, $c = count($data) - 1; $i < $c; $i++) {
        if ($data[$i]->upvote < $data[$i + 1]->upvote) {
          list($data[$i + 1], $data[$i]) =
            array($data[$i], $data[$i + 1]);
          $swapped = true;
        }
      }
    } while ($swapped);
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->whereNull('id_petugas')->whereNotNull('id_admin')->orderBy('created_at','desc')->get();
  }

  public function get_not_assign_sorteddown()
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->whereNull('id_petugas')->where('status_pengaduan', 'Sudah diverifikasi')
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    do {
      $swapped = false;
      for ($i = 0, $c = count($data) - 1; $i < $c; $i++) {
        if ($data[$i]->downvote < $data[$i + 1]->downvote) {
          list($data[$i + 1], $data[$i]) =
            array($data[$i], $data[$i + 1]);
          $swapped = true;
        }
      }
    } while ($swapped);
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->whereNull('id_petugas')->whereNotNull('id_admin')->orderBy('created_at','desc')->get();
  }

  public function get_not_verified()
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->whereNull('id_admin')->where('status_pengaduan', 'NOT_YET_VERIFIED')
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->whereNull('id_admin')->orderBy('created_at','desc')->get();
  }

  public function get_by_tipe($tipe)
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('tipe_pengaduan', $tipe)
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('tipe_pengaduan',$tipe)->orderBy('created_at','desc')->get();
  }

  public function get_by_status($status)
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('status_pengaduan', $status)
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('status_pengaduan',$status)->orderBy('created_at','desc')->get();
  }

  public function get_by_status_sortedup($status)
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('status_pengaduan', $status)
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    do {
      $swapped = false;
      for ($i = 0, $c = count($data) - 1; $i < $c; $i++) {
        if ($data[$i]->upvote < $data[$i + 1]->upvote) {
          list($data[$i + 1], $data[$i]) =
            array($data[$i], $data[$i + 1]);
          $swapped = true;
        }
      }
    } while ($swapped);
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('status_pengaduan',$status)->orderBy('created_at','desc')->get();
  }

  public function get_by_status_sorteddown($status)
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('status_pengaduan', $status)
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    do {
      $swapped = false;
      for ($i = 0, $c = count($data) - 1; $i < $c; $i++) {
        if ($data[$i]->downvote < $data[$i + 1]->downvote) {
          list($data[$i + 1], $data[$i]) =
            array($data[$i], $data[$i + 1]);
          $swapped = true;
        }
      }
    } while ($swapped);
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('status_pengaduan',$status)->orderBy('created_at','desc')->get();
  }

  public function get_by_tipe_n_status($tipe, $status)
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('status_pengaduan', $status)->where('tipe_pengaduan', $tipe)
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }
    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('status_pengaduan',$status)->where('tipe_pengaduan',$tipe)->get();
  }

  public function get_by_tipe_n_status_sortedup($tipe, $status)
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('status_pengaduan', $status)->where('tipe_pengaduan', $tipe)
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }

    do {
      $swapped = false;
      for ($i = 0, $c = count($data) - 1; $i < $c; $i++) {
        if ($data[$i]->upvote < $data[$i + 1]->upvote) {
          list($data[$i + 1], $data[$i]) =
            array($data[$i], $data[$i + 1]);
          $swapped = true;
        }
      }
    } while ($swapped);

    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('status_pengaduan',$status)->where('tipe_pengaduan',$tipe)->get();
  }

  public function get_by_tipe_n_status_sorteddown($tipe, $status)
  {
    $data =  Pengaduan::select(
      'id',
      'id_masyarakat',
      'id_masyarakat as nama_pelapor',
      'id_admin',
      'id_admin as nama_admin',
      'id_petugas',
      'id_petugas as nama_petugas',
      'nama_jalan',
      'foto',
      'tipe_pengaduan',
      'deskripsi_pengaduan',
      'status_pengaduan',
      'feedback_masyarakat',
      'created_at',
      'updated_at',
      DB::Raw('ST_AsGeoJSON(geometry) as geometry')
    )
      ->where('status_pengaduan', $status)->where('tipe_pengaduan', $tipe)
      ->orderBy('created_at', 'desc')->get();
    foreach ($data as $d) {
      if (!is_null($d->nama_pelapor)) {
        $d->nama_pelapor = DB::table('masyarakats')->where('id', $d->nama_pelapor)->first()->nama;
      }
      if (!is_null($d->nama_petugas)) {
        $d->nama_petugas = DB::table('petugas')->where('id', $d->nama_petugas)->first()->nama;
      }
      if (!is_null($d->nama_admin)) {
        $d->nama_admin = DB::table('admins')->where('id', $d->nama_admin)->first()->nama;
      }
      $upvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 1)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();

      if ($upvote) {
        $d->upvote = $upvote->jumlah_vote;
      } else {
        $d->upvote = 0;
      }

      $downvote = DB::table('votes')->select('id_pengaduan', DB::raw('count(id_voter) as jumlah_vote'))
        ->where('vote', 0)->groupBy('id_pengaduan')
        ->having('id_pengaduan', $d->id)->first();
      if ($downvote) {
        $d->downvote = $downvote->jumlah_vote;
      } else {
        $d->downvote = 0;
      }
    }

    do {
      $swapped = false;
      for ($i = 0, $c = count($data) - 1; $i < $c; $i++) {
        if ($data[$i]->downvote < $data[$i + 1]->downvote) {
          list($data[$i + 1], $data[$i]) =
            array($data[$i], $data[$i + 1]);
          $swapped = true;
        }
      }
    } while ($swapped);

    return $data;
    // return Pengaduan::select('id','id_masyarakat','id_admin','id_petugas','nama_jalan','foto','tipe_pengaduan','deskripsi_pengaduan','status_pengaduan','feedback_masyarakat',DB::Raw('ST_AsGeoJSON(geometry) as geometry'))->where('status_pengaduan',$status)->where('tipe_pengaduan',$tipe)->get();
  }

  public function delete($id)
  {
    $data = Pengaduan::find($id);
    if ($data) {
      $data->delete();
    } else {
      return response()->json(["status_code" => 400], 400);
    }

    return response()->json(["status_code" => 204], 204);
  }
}
