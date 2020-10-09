<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Play;
use Illuminate\Support\Facades\DB;

class PlayController extends Controller
{
    public function createsparing(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'sparing_date' => 'required',
            'expired_date' => 'required',
            'title' => 'required',
            'address' => 'required',
            'desription' => 'required'
        ]);
        $play = new Play;
        $play-> user_id = $request->user_id;
        $play-> sparing_date = $request->sparing_date;
        $play-> expired_date = $request->expired_date;
        $play-> title = $request->title;
        $play-> address = $request->address;
        $play-> level = $request->level;
        $play-> desription = $request->desription;
        $play-> play_type = 1;
        $play -> save();
        
        if ($play -> save()){
            return response()->json(array(
            'success' => true,
            'message'=>'Invitation sparing created',
            'data'=> $play),
            200);
        }
        else if (!$play-> save()){
            return response()->json(array(
            'success' => false,
            'message'=>'Signup failed',
            'data'=> []),
            200);
        }
    }

    public function createcoaching(Request $request)
    {
        $this->validate($request, [
        'user_id' => 'required',
        'sparing_date' => 'required',
        'expired_date' => 'required',
        'title' => 'required',
        'address' => 'required',
        'desription' => 'required'
        
    ]);
    $play = new Play;
    $play-> user_id = $request->user_id;
    $play-> sparing_date = $request->sparing_date;
    $play-> expired_date = $request->expired_date;
    $play-> title = $request->title;
    $play-> address = $request->address;
    $play-> desription = $request->desription;
    $play-> play_type = 2;
    $play -> save();
    
    if ($play -> save()){
        return response()->json(array(
        'success' => true,
        'message'=>'Invitation coahing created',
        'data'=> $play),
        200);
    }
    else if (!$play-> save()){
        return response()->json(array(
        'success' => false,
        'message'=>'Signup failed',
        'data'=> []),
        200);
    }
    }

    public function index()
    {
        return Sparing::all();
    }

    public function springhobby($id)
    {
        // return Coach::all();
        return Sparing::where('hobby_id', '=', $id)
                        ->where('expired_date', '>=','NOW()')
                        ->get();
    }
    public function historysparing($user_id)
    {
        $query = DB::select("select play_id, sparing_date, expired_date title, address, desription, level from play where user_id = ? and play.play_type = ?",[$user_id,1]);
       

        return response()->json(array(
            'success' => true,
            'message'=>'List sparing history',
            'data'=> $query),
            200);
    }

    public function historycoaching($user_id)
    {
        //$query = DB::select("select play.sparing_date,play_partner.status, users.name from play join play_partner on play.play_id = play_partner.play_id join users ON users.user_id = play_partner.`partner_id` where play.user_id = ? and play.play_type = ?; ",[$user_id,2]);
        $query = DB::select("select play_id, sparing_date, expired_date, title, address, desription from play where user_id = ? and play.play_type = ?",[$user_id,2]);

        return response()->json(array(
            'success' => true,
            'message'=>'List coaching history',
            'data'=> $query),
            200);
    }

    public function coaching()
    {
        $id = 2;
        $query = DB::select("select users.name,users.phone_number, play.user_id,play_id,title ,play.address,sparing_date,expired_date,desription from `play` join users on play.user_id = users.user_id where `expired_date` >= NOW() and play_type= ?",[$id]);

        if ($query == null){
            return response()->json(array(
                'success' => false,
                'message'=>'Nothing of invitation',
                'data'=> $query),
                200);
        }
        else if($id == 2){
            return response()->json(array(
                'success' => true,
                'message'=>'Lisf coaching invitation  ',
                'data'=> $query),
                200);
        }
        else{
            return response()->json(array(
                'success' => false,
                'message'=>'Something error',
                'data'=> []),
                200);
        }
        return $query;
    }
    public function sparing()
    {
        $id = 1;
        $query = DB::select("select users.name,users.phone_number, users.gender,  play.user_id,play_id,title ,play.address,sparing_date,expired_date,desription, play.level from `play` join users on play.user_id = users.user_id where `expired_date` >= NOW() and play_type= ?",[$id]);

        if ($query == null){
            return response()->json(array(
                'success' => false,
                'message'=>'Nothing of invitation',
                'data'=> $query),
                200);
        }
        else if($id == 1){
            return response()->json(array(
                'success' => true,
                'message'=>'Lisf sparing invitation  ',
                'data'=> $query),
                200);
        }
    
        else{
            return response()->json(array(
                'success' => false,
                'message'=>'Something error',
                'data'=> []),
                200);
        }
        return $query;
    }

    public function listrequstsparing($play_id)
    {
        $query = DB::select("select play.play_id, play.title, play_partner.pp_id, play_partner.notes, play_partner.created_at, play_partner.status, users.name, users.email, users.utr, users.level, users.gender, users.birthdate, users.phone_number, users.image from play_partner join play on play_partner.play_id = play.play_id join users on play_partner.partner_id = users.user_id where play_partner.play_id =? and play.play_type = 1  and users.is_active = 1 order by play_partner.created_at;",[$play_id]);

        if ($query == null){
            return response()->json(array(
                'success' => false,
                'message'=>'Nothing of invitation',
                'data'=> $query),
                200);
        }
        else {
            return response()->json(array(
                'success' => true,
                'message'=>'Lisf Requester for Sparring',
                'data'=> $query),
                200);
        }
    
    }
    public function listrequstcoaching($play_id)
    {
        
        // $query = DB::select("select play.title,play_partner.partner_id, users.name, users.phone_number, play.sparing_date,play.expired_date,play_partner.status, play_partner.notes from play join play_partner on play.play_id = play_partner.play_id join users on users.user_id = play_partner.partner_id  where play_partner.status = 'waiting' and play.play_type = 2 and play.user_id =? order by play_partner.created_at;",[$id]);
        $query = DB::select("select play.play_id, play.title, play_partner.pp_id, play_partner.notes, play_partner.created_at, play_partner.status, users.name, users.email, users.phone_number,users.image, users.price, users.experience, c.certificate from play_partner join play on play_partner.play_id = play.play_id join users on play_partner.partner_id = users.user_id LEFT JOIN certificate c on play_partner.partner_id = c.users_id  where play_partner.play_id =? and play.play_type = 2 and users.is_active = 1  order by play_partner.created_at;",[$play_id]);

        if ($query == null){
            return response()->json(array(
                'success' => false,
                'message'=>'Nothing of invitation',
                'data'=> $query),
                200);
        }
        else {
            return response()->json(array(
                'success' => true,
                'message'=>'Lisf Requester  for coaching invitation  ',
                'data'=> $query),
                200);
        }
    
    }
    // public function invitation($id)
    // {
    //     $query = DB::select("select user_id,sparing_date,expired_date,time,desription from `play` where `expired_date` >= NOW() and play_type= ?",[$id]);
    //     if ($query == null){
    //         return response()->json(array(
    //             'success' => true,
    //             'message'=>'Nothing of invitation',
    //             'data'=> $query),
    //             200);
    //     }
    //     else if($id == "approve"){
    //         return response()->json(array(
    //             'success' => true,
    //             'message'=>'Lisf sparing invitation  ',
    //             'data'=> $query),
    //             200);
    //     }
    //     else if($id == "reject"){
    //         return response()->json(array(
    //             'success' => true,
    //             'message'=>'Lisf coaching invitation  ',
    //             'data'=> $query),
    //             200);
    //     }
    //     else{
    //         return response()->json(array(
    //             'success' => true,
    //             'message'=>'Something error',
    //             'data'=> []),
    //             200);
    //     }
    // }
    public function detailinvitation($play_type,$play_id)
    {
        $query = DB::select("select user_id,sparing_date,expired_date,desription from `play` where `expired_date` >= NOW() and play_type= ? and play_id = ?",[$play_type,$play_id]);
        
        // var_dump($query);
        if ($query == null){
            return response()->json(array(
                'success' => false,
                'message'=>'Nothing of invitation',
                'data'=> $query),
                200);
        }
        else if($play_type == 1){
            return response()->json(array(
                'success' => true,
                'message'=>'Lisf detail sparing invitation  ',
                'data'=> $query),
                200);
        }
        else if($play_type == 2){
            return response()->json(array(
                'success' => true,
                'message'=>'Lisf detail coaching invitation  ',
                'data'=> $query),
                200);
        }
        else{
            return response()->json(array(
                'success' => false,
                'message'=>'Something error',
                'data'=> $query),
                200);
        }
    }
    public function update(Request $request,$d)
    {
        $coach = Sparing::find($id);

        if ($coach) {
            $coach->update($request->all());

            return response()->json([
                'message' => 'Sparing has been updated'
            ]);
        }

        return response()->json([
            'message' => 'Sparing not found',
        ], 404);
    }
    
    public function delete($coach_id)
    {
        $coach = Sparing::find($coach_id);


        if ($coach) {
            $coach->delete();

            return response()->json([
               'message' => 'Sparing has been deleted'
            ]);
        }

        return response()->json([
            'message' => 'Sparing not found'
        ], 404);
    }
}