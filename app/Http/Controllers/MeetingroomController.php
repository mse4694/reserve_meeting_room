<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Models\Meetingroom;
//use \Illuminate\Database\QueryException;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Http\Request;

class MeetingroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/ManageMeetingRoom');
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
    public function store()
    {
        // dd( 
        //      Request::input('fullname'),
        //      Request::input('shortname'),
        //      Request::input('building_id'),
        //      Request::input('floor'),
        //      Request::input('status'),
        //      Request::input('capacity_normal'),
        //      Request::input('capacity_min'),
        //      Request::input('capacity_max'),
        //      Request::input('price_half_day'),
        //      Request::input('price_full_day'),
        //      Request::input('description'),
        //      Request::file('image'),
        // );

        $building_id = Request::input('building_id');
        $floor = Request::input('floor');
        $capacity = ['normal' => Request::input('capacity_normal'), 'min' => Request::input('capacity_min'), 'max' => Request::input('capacity_max')];
        $price = ['half_day' => Request::input('price_half_day'), 'full_day' => Request::input('price_full_day')];
        $fullname = Request::input('fullname');
        $shortname = Request::input('shortname');
        //$description = Request::input('description');
        $description = ['description'=>Request::input('description')];
        $status = Request::input('status');
        $userin = '10039018';
        $img_file = ['img1'=> Request::file('image'),];

        $add_meeting_room = Meetingroom::create(['building_id'=>$building_id,'floor'=>$floor,
                                                'capacity'=>$capacity,'price'=>$price,
                                                'fullname'=>$fullname, 'shortname'=>$shortname,
                                                'description'=>$description, 'status'=>$status,
                                                'userin'=>$userin, 'img_file'=>$img_file 
                                           ]);

        // if(!$add_meeting_room){
        //     $addStatus = "error";
        //     $addDetail = "เพิ่มข้อมูลห้องประชุม ไม่สำเร็จ";
        //     //\Log::info(Auth::user()->name.'!เพิ่มข้อมูลแพทย์ SAP-ID : ' . $siriraj_id . ' ชื่อ : ' . $preceptor_name .' ไม่สำเร็จ!');
        // }

        return Redirect::route('manage_meeting_room');
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

    public function showall()
    {
        //dd( Meetingroom::all());
        $mrooms = Meetingroom::all();
        if(count($mrooms)) {
            //\Log::info(count($mrooms));
            foreach($mrooms as $mroom){
                $mrooms_tranform[] = [
                    'id'=>$mroom->id,
                    'building_id'=>$mroom->building_id,
                    'fullname'=>$mroom->fullname,
                    'shortname'=>$mroom->shortname,
                    'floor'=>$mroom->floor,
                    'capacity_normal'=>$mroom->capacity['normal'],
                    'capacity_min'=>$mroom->capacity['min'],
                    'capacity_max'=>$mroom->capacity['max'],
                    'price_half_day'=>$mroom->price['half_day'],
                    'price_full_day'=>$mroom->price['full_day'],
                    'status'=>$mroom->status,
                    'description'=>$mroom->description['description'],
                    'image'=>$mroom->img_file['img1'],
                ];
            }
        } else {
            //\Log::info("No room");
            $mrooms_tranform = [];
        }
        //\Log::info($mrooms_tranform);
        return $mrooms_tranform;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        if(is_array(Request::input('building_id'))) {
            $building_id = Request::input('building_id')['building_id'];
        } else {
            $building_id = Request::input('building_id');
        }

        if(is_array(Request::input('status'))) {
            $status = Request::input('status')['value'];
        } else {
            $status = Request::input('status');
        }

        // dd( 
        //     (int)$id,
        //     Request::input('id'),
        //     Request::input('fullname'),
        //     Request::input('shortname'),
        //     // Request::input('building_id'),
        //     $building_id,
        //     Request::input('floor'),
        //     // Request::input('status'),
        //     $status,
        //     Request::input('capacity_normal'),
        //     Request::input('capacity_min'),
        //     Request::input('capacity_max'),
        //     Request::input('price_half_day'),
        //     Request::input('price_full_day'),
        //     Request::input('description'),
        //     Request::input('image'),
        // );

        \Log::info(Request::all());

        //$building_id = Request::input('building_id');
        $floor = Request::input('floor');
        $capacity = ['normal' => Request::input('capacity_normal'), 'min' => Request::input('capacity_min'), 'max' => Request::input('capacity_max')];
        $price = ['half_day' => Request::input('price_half_day'), 'full_day' => Request::input('price_full_day')];
        $fullname = Request::input('fullname');
        $shortname = Request::input('shortname');
        //$description = Request::input('description');
        $description = ['description'=>Request::input('description')];
        //$status = Request::input('status');
        $userin = '10039018';
        $user_last_act = '10039019';
        $img_file = ['img1'=> Request::input('image')];

        try {
            $upd_mroom = Meetingroom::whereId((int)$id)
                                    ->update([
                                        'building_id'=>$building_id,'floor'=>$floor,
                                        'capacity'=>$capacity,'price'=>$price,
                                        'fullname'=>$fullname, 'shortname'=>$shortname,
                                        'description'=>$description, 'status'=>$status,
                                        'userin'=>$userin, 'user_last_act'=>$user_last_act, 'img_file'=>$img_file 
                                    ]);
        } catch(\Exception  $e) {
            // $updStatus = "error";
            // $updDetail = "อัพเดทข้อมูลแพทย์ ไม่สำเร็จ";
            // \Log::info($username .' !อัพเดทข้อมูลแพทย์ ที่ตาราง [preceptor] ID : ' . $id . ' ชื่อ : ' . $preceptor_name .' ไม่สำเร็จ!');
            // \Log::info($e->message());
            // DB::rollback();
            // session([$updStatus => $updDetail]);
            //return back()->withInput()->with('menuType', 'editPreceptor');
            //return Redirect::route('manage_meeting_room');
            \Log::info($e);
            return Redirect::route('manage_meeting_room');
        }

        return Redirect::route('manage_meeting_room');
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
