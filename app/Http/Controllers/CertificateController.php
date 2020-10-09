<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Storage;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'users_id' => 'required',
            'certificate' => 'required|image',
            'start_certificate' => 'required',
            'end_certificate' => 'required',

        ]);
        $image_name = Str::random(34);
        $request->file('certificate')->move(storage_path('certificate'), $image_name);
        $image_name ="http://backend.trainme.id/users/certificate/".$image_name;
        $users = new Certificate;
        $users->users_id = $request->users_id;
        $users->certificate = $image_name;
        $users->start_certificate = $request->start_certificate;
        $users->end_certificate = $request->end_certificate;

        if ($users -> save()){
            return response()->json(array(
            'success' => true,
            'message'=>'Certificate Uploaded',
            'data'=> $users),
            200);
        }
        else if (!$users -> save()){
            return response()->json(array(
            'success' => false,
            'message'=>'Failed to upload',
            'data'=> $users),
            200);
        }
        
    }
       public function get_certificate($name)
    {
        $avatar_path = storage_path('certificate') . '/' . $name;
        if (file_exists($avatar_path)) {
            $file = file_get_contents($avatar_path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
            }
        $res['success'] = false;
        $res['message'] = "Avatar not found";

        return $res;
    }
    
     public function certificate(Request $request)
    {
        $this->validate($request, [
            'certificate' => 'required|image',
            'users_id' => 'required',
        ]);
        $image_name = Str::random(34);
        $request->file('certificate')->move(storage_path('certificate'), $image_name);
        $image_name = "http://backend.trainme.id/users/certificate/".$image_name;
        $count = 0;
        
        $query = DB::select("SELECT users_id FROM certificate where users_id = ? ",[$request->users_id]);
        
        
        if (empty($query)){
            $updateUser = DB::update("insert into certificate (users_id,certificate) values('$request->users_id','$image_name')");
        }
        else {
            $updateUser = DB::update("UPDATE certificate SET certificate = '$image_name' WHERE  users_id = '$request->users_id'");
        }
         if($updateUser){
            return response()->json(array(
            'success' => true,
            'message'=> 'Upload Certificate success'),
            200);
        }else{
            return response()->json(array(
            'success' => false,
            'message'=> 'Upload Certificate Failed'),
            200);
         }
        
    }
}