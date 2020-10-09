<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function create(Request $request)
    {
       

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'organizer' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'poster' =>'required|image'

        ]);
        $image_name = Str::random(34);
        $request->file('poster')->move(storage_path('poster'), $image_name);
        
        $image_name = "http://backend.trainme.id/event/image/".$image_name;
        $event = new Event;
        $event->name = $request->name;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->link = $request->link;
        $event->organizer = $request->organizer;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->poster = $image_name;

        
        if ($event -> save()){
            return response()->json(array(
            'success' => true,
            'message'=>'Event created',
            'data'=> $event),
            200);
        }
    }

    public function list_event(){
        $query = DB::select("select event_id, name, short_description, description,location,organizer,start_date,end_date,poster, link from event where is_active = ? and `end_date` >= NOW() ORDER By start_date ASC",[1]);
        return response()->json(array(
            'success' => true,
            'message'=>'List of event',
            'data'=>  $query ),
            200);
    }
    public function get_poster($name)
    {
        $avatar_path = storage_path('poster') . '/' . $name;
        if (file_exists($avatar_path)) {
            $file = file_get_contents($avatar_path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
            }
        $res['success'] = false;
        $res['message'] = "Avatar not found";

        return $res;
    }
}
