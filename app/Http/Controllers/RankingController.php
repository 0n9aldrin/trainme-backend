<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
	public function getAllRankingWoman() {

        $data = DB::select("SELECT * FROM rangking WHERE genderid=0 ORDER BY age ASC");

        if(empty($data)) {
            return response()->json(array('success' => false,
                'message'=>'Ranking Not Found'),
                202);
        }
        else {	
            return response()->json(array('success' => true,
                'message'=>'Get item success',
                'data'=> $data),
                200);
        }
    }
    
    public function getAllRankingMan() {

        $data = DB::select("SELECT * FROM rangking WHERE genderid=1 ORDER BY age ASC");

        if(empty($data)) {
            return response()->json(array('success' => false,
                'message'=>'Ranking Not Found'),
                202);
        }
        else {	
            return response()->json(array('success' => true,
                'message'=>'Get item success',
                'data'=> $data),
                200);
        }
    }
}