<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Storage;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /*
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'image' => 'required|image',
            'phone_number' => 'required',
            'address' => 'required',

        ]);
        $image_name = Str::random(34);
        $request->file('image')->move(storage_path('avatar'), $image_name);
        $image_name = "http://backend.trainme.id/users/image/".$image_name;
        $users = new Users;
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->role = $request->role;
        $users->phone_number = $request->phone_number;
        $users->address = $request->address;
        $users->image = $image_name;
        $users->price = $request->price;
        $users->experience = $request->experience;


        // check unique email
        $email = "";
        $query = DB::select("SELECT email FROM users where email = ? limit 1 ",[$users->email]);
        foreach ($query as $data) {
            $email= $data->email;
        }

        if ($email == $users->email ){
            return response()->json(array(
            'success' => false,
            'message'=>'The email has already been taken.',
            'data'=> $users),
            200);
        }
        else if ($users -> save()){
            return response()->json(array(
            'success' => true,
            'message'=>'User create, Signup success',
            'data'=> $users),
            200);
        }
        else if (!$users -> save()){
            return response()->json(array(
            'success' => false,
            'message'=>'Signup failed',
            'data'=> $users),
            200);
        }
        
    }
    */
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image',
            'user_id' => 'required',
        ]);
        $image_name = Str::random(34);
        $request->file('image')->move(storage_path('avatar'), $image_name);
        $image_name = "http://backend.trainme.id/users/image/".$image_name;
        $updateUser = DB::update("UPDATE users SET image = '$image_name' WHERE  user_id = '$request->user_id'");
        
        if($updateUser){
            return response()->json(array(
            'success' => true,
            'message'=> 'Update Photo success'),
            200);
        }else{
            return response()->json(array(
            'success' => false,
            'message'=> 'Update Photo Failed'),
            200);
        }
    }
    
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
        ]);
        $users = new Users;
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->role = $request->role;
        $users->phone_number = $request->phone_number;
        $users->address = $request->address;
        $users->price = $request->price;
        $users->experience = $request->experience;
        $users->birthdate = $request->birthdate;
        $users->utr = $request->utr;
        $users->level = $request->level;
        $users->gender = $request->gender;
        

        // check unique email
        $email = "";
        $query = DB::select("SELECT email FROM users where email = ? limit 1 ",[$users->email]);
        foreach ($query as $data) {
            $email= $data->email;
        }

        if ($email == $users->email ){
            return response()->json(array(
            'success' => false,
            'message'=>'The username has already been taken.',
            'data'=> $users),
            200);
        }
        else if ($users -> save()){
            return response()->json(array(
            'success' => true,
            'message'=>'User create, Signup success',
            'data'=> $users),
            200);
        }
        else if (!$users -> save()){
            return response()->json(array(
            'success' => false,
            'message'=>'Signup failed',
            'data'=> $users),
            200);
        }
        
    }
    public function contact($user_id)
    {
        $query = DB::select("SELECT phone_number FROM users where user_id = ? limit 1 ",[$user_id]);

        $phone_number ="";
        foreach ($query as $data) {
            $phone_number="https://api.whatsapp.com/send?phone=".$data->phone_number."&text=Hi !%20CS_Let's play!%20I%20want%20to,%20play%20?";
        }

        return response()->json(array(
            'success' => true,
            'message'=>'Contact Users',
            'data'=>  $phone_number ),
            200);
    }

    public function ads(){
        $query = DB::select("select id, image,description from images where is_active = ?",[1]);
        return response()->json(array(
            'success' => true,
            'message'=>'List of ads',
            'data'=>  $query ),
            200);

        // $query = DB::select("select play.sparing_date,play_partner.status, users.name from play join play_partner on play.play_id = play_partner.play_id join users ON users.user_id = play_partner.`partner_id` where play.user_id = ? and play.play_type = ?",[$user_id,1]);
       

        // return response()->json(array(
        //     'success' => true,
        //     'message'=>'List sparing history',
        //     'data'=> $query),
        //     200);
    }
    public function get_profile($user_id){
        $query = DB::select("select user_id,name,email,password,image,role,phone_number,address, gender, price, experience, level, utr, birthdate, certificate from users LEFT JOIN certificate ON user_id = certificate.users_id where user_id = ?",[$user_id]);
        
        return response()->json(array(
            'success' => true,
            'message'=>'Detail Profile ',
            'data'=>  $query ),
            200);
    }
    public function index()
    {
        return Users::all();
    }

    public function show($id)
    {
        $user = Users::find($id);
        if (! $user) {
            return response()->json([
               'message' => 'users not found'
            ]);
        }

        return $user;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
 
            'email' => 'required',
     
            'password' => 'required'
     
             ]);
     
        $query = DB::select("select count(email) as total from users where email = ? and is_active = 1",[$request->email]);
        $flag = 0;
        
        foreach ($query as $data) {
            $flag =  $data->total;
        }
        if($flag== 1 ){
            $user = Users::where('email', $request->input('email'))->first();
            if(Hash::check($request->input('password'), $user->password)){
                return response()->json(array(
                    'success' => true,
                    'message'=>'Users login',
                    'data'=> $user),
                    200);
        
               }else{
                return response()->json(array(
                        'success' => false,
                        'message'=>'Username or password false'),
                        200);
         
               }
        }
        else {
            return response()->json(array(
                'success' => false,
                'message'=>'Username or password false'),
                200);

        }
      

        
    }

    public function update(Request $request,$id)
    {
        $user = Users::find($id);

        if ($user) {
            $user->update($request->all());

            return response()->json([
                'message' => 'Users has been updated'
            ]);
        }

        return response()->json([
            'message' => 'Users not found',
        ], 404);
    }
    public function get_avatar($name)
    {
        $avatar_path = storage_path('avatar') . '/' . $name;
        if (file_exists($avatar_path)) {
            $file = file_get_contents($avatar_path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
            }
        $res['success'] = false;
        $res['message'] = "Avatar not found";

        return $res;
    }

    public function delete($id)
    {
        $user = Users::find($id);


        if ($user) {
            $user->delete();

            return response()->json([
               'message' => 'User has been deleted'
            ]);
        }

        return response()->json([
            'message' => 'User not found'
        ], 404);
    }
}
function setPasswordAttribute($pass){

    return Hash::make($pass);
    
}

