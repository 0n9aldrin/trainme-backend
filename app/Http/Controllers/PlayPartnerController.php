<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PlayPartner;
use Illuminate\Support\Facades\DB;

class PlayPartnerController extends Controller
{
    public function request(Request $request)
    {
        $this->validate($request, [
            'play_id' => 'required',
            'notes' => 'required',
            'partner_id' => 'required'
            
        ]);

        $query = DB::select("select count(partner_id) as total from `play_partner` where partner_id = ? and `status` =  'waiting'",[$request->partner_id]);
        $flag = 0;
        foreach ($query as $data) {
            $flag = $data->total;
        }

        if($flag== 1 ){
            return response()->json(array(
                'success' => false,
                'message'=>'You already request',
                'data'=> $request->all()),
                200);
        }
        else{
            // return $query;
            if(PlayPartner::create($request->all())){
                return response()->json(array(
                    'success' => true,
                    'message'=>'Request sent',
                    'data'=> $request->all()),
                    200);
            }
            else{
                return response()->json(array(
                    'success' => false,
                    'message'=>'Request failed sent',
                    'data'=> $request->all()),
                    200);
            }
        }
        

    
    }
    public function approval(Request $request)
    {
        

        $play_partner = PlayPartner::find($request->pp_id);

        $play_partner->update($request->all());

        if ($request->status == 'accept') {
           return response()->json(array(
                'success' => true,
                'message'=>'Accept invitation',
                'data'=> $request->all()),
                200);
        }
        else if ($request->status == 'reject') {
            return response()->json(array(
                 'success' => false,
                 'message'=>'Reject invitation',
                 'data'=> $request->all()),
                 200);
         }
        // return s";
    }
    
    public function allStatusRequest($user_id){
        $query = DB::select("select play.title, play_partner.pp_id, play_partner.notes, play_partner.created_at, play_partner.status from play_partner join play on play_partner.play_id = play.play_id where play_partner.partner_id =? and play.play_type = 1 order by play_partner.created_at;",[$user_id]);

        if ($query == null){
            return response()->json(array(
                'success' => false,
                'message'=>'User never join sparring',
                'data'=> $query),
                200);
        }
        else {
            return response()->json(array(
                'success' => true,
                'message'=>'Lisf Status Join Sparring',
                'data'=> $query),
                200);
        }
    }
    
    public function allStatusRequestCoaching($user_id){
        $query = DB::select("select play.title, play_partner.pp_id, play_partner.notes, play_partner.created_at, play_partner.status from play_partner join play on play_partner.play_id = play.play_id where play_partner.partner_id =? and play.play_type = 2 order by play_partner.created_at;",[$user_id]);

        if ($query == null){
            return response()->json(array(
                'success' => false,
                'message'=>'User never join coaching',
                'data'=> $query),
                200);
        }
        else {
            return response()->json(array(
                'success' => true,
                'message'=>'Lisf Status Join Coaching',
                'data'=> $query),
                200);
        }
    }
    public function index()
    {
        return SparingPartner::all();
    }

    public function show($id)
    {
        $sparing =  SparingPartner::find($id);
        if (! $sparing) {
            return response()->json([
               'message' => 'sparing not found'
            ]);
        }

        return $sparing;
    }
    
    public function update(Request $request,$id)
    {
        $sparing = SparingPartner::find($id);

        if ($sparing) {
            $sparing->update($request->all());

            return response()->json([
                'message' => 'Sparing has been updated'
            ]);
        }

        return response()->json([
            'message' => 'Sparing not found',
        ], 404);
    }
    
    public function delete($id)
    {
        $sparing = SparingPartner::find($id);


        if ($sparing) {
            $sparing->delete();

            return response()->json([
               'message' => 'Sparing has been deleted'
            ]);
        }

        return response()->json([
            'message' => 'Sparing not found'
        ], 404);
    }
}