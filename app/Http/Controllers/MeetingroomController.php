<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Models\Meetingroom;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        //      Request::input('image1'),
        //      Request::file('image1'),
        //      Request::input('image2'),
        //      Request::file('image2'),
        //      Request::input('image3'),
        //      Request::file('image3'),
        // );

        $building_id = Request::input('building_id');
        $floor = Request::input('floor');
        $capacity = ['normal' => Request::input('capacity_normal'), 'min' => Request::input('capacity_min'), 'max' => Request::input('capacity_max')];
        $price = ['half_day' => Request::input('price_half_day'), 'full_day' => Request::input('price_full_day')];
        $fullname = Request::input('fullname');
        $shortname = Request::input('shortname');
        $description = ['description'=>Request::input('description')];
        $status = Request::input('status');
        $userin = '10039018';
        
        try {
            if( Request::hasFile('image1') ) {
                $uuid = (string) Str::uuid();
                $imgName1 = $uuid.".jpg";
                $path1 = Request::file('image1')->storePubliclyAs('public/picture', $imgName1);
            } else {
                $imgName1 = Request::input('image1');
            }

            if( Request::hasFile('image2') ) {
                $uuid = (string) Str::uuid();
                $imgName2 = $uuid.".jpg";
                $path2 = Request::file('image2')->storePubliclyAs('public/picture', $imgName2);
            } else {
                $imgName2 = Request::input('image2');
            }

            if( Request::hasFile('image3') ) {
                $uuid = (string) Str::uuid();
                $imgName3 = $uuid.".jpg";
                $path3 = Request::file('image3')->storePubliclyAs('public/picture', $imgName3);
            } else {
                $imgName3 = Request::input('image3');
            }

            //$path = $path1 ." | ". $path2 ." | ". $path3;
            //\Log::info($path);

            $img_file = ['img1'=> $imgName1, 'img2'=> $imgName2, 'img3'=> $imgName3];

            Meetingroom::create(['building_id'=>$building_id,'floor'=>$floor,
                                 'capacity'=>$capacity,'price'=>$price,
                                 'fullname'=>$fullname, 'shortname'=>$shortname,
                                 'description'=>$description, 'status'=>$status,
                                 'userin'=>$userin, 'img_file'=>$img_file 
                                ]);
        } catch(\Exception  $e) {
            \Log::info($e->getMessage());
        }

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
        //     //Request::input('image1'),
        //     Request::input('oldimage1'),
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
        $oldimage1 = Request::input('oldimage1');
        $oldimage2 = Request::input('oldimage2');
        $oldimage3 = Request::input('oldimage3');
        //$img_file = ['img1'=> Request::input('image')];

        // $imageSet = array([
        //               {'name' => 'image1', 'oldname' => $oldimage1},
        //               {'name' => 'image2', 'oldname' => $oldimage2},
        //               {'name' => 'image3', 'oldname' => $oldimage3}
        // ]);

        try {
            // รูปห้องที่ 1 
            if( Request::hasFile('image1') ) {
                $uuid = (string) Str::uuid();
                $imgFile = Request::file('image1');
                $imgExtension = strtolower($imgFile->getClientOriginalExtension());
                $imgName1 = $uuid.".".$imgExtension;
                if( strcmp($oldimage1, "no_image.jpg") === 0 ) {
                    $path = $imgFile->storePubliclyAs('public/picture', $imgName1);
                } else {
                    Storage::delete('public/picture/'.$oldimage1);
                    $path = $imgFile->storePubliclyAs('public/picture', $imgName1);
                }
            } else {
                if( strcmp($oldimage1, "no_image.jpg") !== 0 ) {
                    $imgName1 = $oldimage1;
                } else {
                    $imgName1 = Request::input('image1');
                }
            }

            // รูปห้องที่ 2 
            if( Request::hasFile('image2') ) {
                $uuid = (string) Str::uuid();
                $imgFile = Request::file('image2');
                $imgExtension = strtolower($imgFile->getClientOriginalExtension());
                //$imgExtension = strtolower(Request::file('image2')->getClientOriginalExtension());
                $imgName2 = $uuid.".".$imgExtension;
                //$imgName2 = $uuid.".jpg";
                if( strcmp($oldimage2, "no_image.jpg") === 0 ) {
                    $path = $imgFile->storePubliclyAs('public/picture', $imgName2);
                } else {
                    Storage::delete('public/picture/'.$oldimage2);
                    $path = $imgFile->storePubliclyAs('public/picture', $imgName2);
                }
            } else {
                if( strcmp($oldimage2, "no_image.jpg") !== 0 ) {
                    $imgName2 = $oldimage2;
                } else {
                    $imgName2 = Request::input('image2');
                }
            }

            // รูปห้องที่ 2 
            if( Request::hasFile('image3') ) {
                $uuid = (string) Str::uuid();
                $imgFile = Request::file('image3');
                $imgExtension = strtolower($imgFile->getClientOriginalExtension());
                $imgName3 = $uuid.".".$imgExtension;
                //$imgName3 = $uuid.".jpg";
                if( strcmp($oldimage3, "no_image.jpg") === 0 ) {
                    $path = $imgFile->storePubliclyAs('public/picture', $imgName3);
                } else {
                    Storage::delete('public/picture/'.$oldimage3);
                    $path = $imgFile->storePubliclyAs('public/picture', $imgName3);
                }
            } else {
                if( strcmp($oldimage3, "no_image.jpg") !== 0 ) {
                    $imgName3 = $oldimage3;
                } else {
                    $imgName3 = Request::input('image3');
                }
            }
            
            $img_file = ['img1'=> $imgName1, 'img2'=> $imgName2, 'img3'=> $imgName3];

            Meetingroom::whereId((int)$id)
                        ->update([
                            'building_id'=>$building_id,'floor'=>$floor,
                            'capacity'=>$capacity,'price'=>$price,
                            'fullname'=>$fullname, 'shortname'=>$shortname,
                            'description'=>$description, 'status'=>$status,
                            'userin'=>$userin, 'user_last_act'=>$user_last_act, 'img_file'=>$img_file 
                        ]);
        } catch(\Exception  $e) {
            //  \Log::info($e->getMessage());
            // session([$updStatus => $updDetail]);
            //return back()->withInput()->with('menuType', 'editPreceptor');
            return Redirect::back()->withErrors(['msg' => $e->getMessage()]);
            // return Redirect::route('manage_meeting_room');
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

    public function storeImage() 
    {

    }
}
