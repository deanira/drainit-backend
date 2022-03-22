<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Votes;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Votes::all();
    }

    public function upcount($id){
        $countVote = Votes::select('id_pengaduan',DB::raw('count(id_voter) as jumlah_vote'))->where('vote',1)
        ->groupBy('id_pengaduan')->having('id_pengaduan',$id)->first();
        if($countVote){
            return $countVote;
        }
        return [
            "id_pengaduan" => $id,
            "jumlah_vote" => 0
        ];
    }

    public function downcount($id){
        $countVote = Votes::select('id_pengaduan',DB::raw('count(id_voter) as jumlah_vote'))->where('vote',0)
        ->groupBy('id_pengaduan')->having('id_pengaduan',$id)->first();
        if($countVote){
            return $countVote;
        }
        return [
            "id_pengaduan" => $id,
            "jumlah_vote" => 0
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validateData = $request->validate([
            'id_pengaduan' => 'required',
            'vote'=> 'required|boolean',
        ]);

        $validateData['id_voter'] = auth()->user()->id;

        $datavote = Votes::where('id_voter',$validateData['id_voter'])->where('id_pengaduan',$validateData['id_pengaduan'])->first();
        if(!$datavote){
            $vote = Votes::create($validateData);
            return response()->json(['message'=>'vote berhasil','data'=>$vote],201);
        }

        return response()->json(['message'=>'vote sudah ada', 'status code'=>'303']);
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
        //
        $validateData = $request->validate([
            'vote'=> 'boolean|nullable',
        ]);
        //
        $datavote = Votes::where('id_voter',auth()->user()->id)
            ->where('id_pengaduan',$id)->first();
        $datavote->vote = $validateData['vote'];
        $datavote->save();
        
        return response()->json(['message'=>'vote berhasil dirubah','data'=>$datavote, 'status_code'=>201],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Votes::find($id);
        if($data){
          $data->delete();
        }else{
          return response()->json(['status_code'=>400],400);
        }

        return response()->json(['status_code'=>204],204);
    }
}
