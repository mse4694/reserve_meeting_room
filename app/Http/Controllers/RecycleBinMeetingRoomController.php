<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Models\Meetingroom;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecycleBinMeetingRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dmrooms = Meetingroom::onlyTrashed()->get();
        if(count($dmrooms)) {
            foreach($dmrooms as $mroom){
                $dmrooms_tranform[] = [
                    'id'=>$mroom->id,
                    'building_id'=>$mroom->building_id,
                    'fullname'=>$mroom->fullname,
                    'shortname'=>$mroom->shortname,
                    'floor'=>$mroom->floor,
                    'capacity_normal'=>(int)$mroom->capacity['normal'],
                    'capacity_min'=>(int)$mroom->capacity['min'],
                    'capacity_max'=>(int)$mroom->capacity['max'],
                    'price_half_day'=>(int)$mroom->price['half_day'],
                    'price_full_day'=>(int)$mroom->price['full_day'],
                    'status'=>$mroom->status,
                    'description'=>$mroom->description['description'],
                    'image1'=>$mroom->img_file['img1'],
                    'image2'=>$mroom->img_file['img2'],
                    'image3'=>$mroom->img_file['img3'],
                ];
            }
        } else {
            $dmrooms_tranform = [];    //Not found delete meeting room
        }

        return Inertia::render('Admin/RecycleBinMeetingRoom', ['dmrooms_tranform' => $dmrooms_tranform]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        //return Redirect::back()->withErrors(['msg' => 'fail']);
        $restore = Meetingroom::withTrashed()->find((int)$id)->restore();
        //\Log::info($restore);
        if($restore) {
            return Redirect::route('recycle_bin_meeting_room');
        } else {
            return Redirect::back()->withErrors(['msg' => 'fail']);
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }
}
