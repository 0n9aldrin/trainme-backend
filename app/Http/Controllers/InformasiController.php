<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformasiController extends Controller
{
	public function getInformasiUmum() {

        $data = DB::select("SELECT * FROM informasiumum ORDER BY nomor ASC");

        if(empty($data)) {
            return response()->json(array('success' => false,
                'message'=>'Tidak ada informasi Umum '),
                202);
        }
        else {	
            return response()->json(array('success' => true,
                'message'=>'Get item success',
                'data'=> $data),
                200);
        }
    }

	public function getKebijakanPrivasi() {

        $data = DB::select("SELECT * FROM kebijakanprivasi ORDER BY nomor ASC");

        if(empty($data)) {
            return response()->json(array('success' => false,
                'message'=>'Tidak ada informasi Umum '),
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