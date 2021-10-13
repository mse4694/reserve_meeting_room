<?php

namespace App\Http\Controllers;

use App\Models\Workunit;
use App\Models\Objective;
use App\Models\Meetingroom;

class UtilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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

    public function getWorkunitType()
    {
        $types = Workunit::select('workunit_type')->distinct()->get();
        if(count($types)) {
            $index = 0;
            foreach($types as $type){
                //\Log::info($type);
                switch ($type['workunit_type']) {
                    case 'internal':
                        $title_th = "หน่วยงานภายใน";
                        break;
                    case 'external':
                        $title_th = "หน่วยงานภายนอก";
                        break;
                    case 'company':
                        $title_th = "บริษัท";
                        break;
                    default:
                        $title_th = "";
                        break;
                }
                $types_tranform[] = [
                    'index'=>$index,
                    'title_en'=>$type->workunit_type,
                    'title_th'=>$title_th,
                ];
                $index++;
            }
        } else {
            $types_tranform = [];     //Not found meeting room
        }
        return response()->json(["workunit_types" => $types_tranform]);
    }

    public function getWorkunitNameFromType($workunit_type)
    {
        //\Log::info($workunit_type);
        $workunits = Workunit::where('workunit_type', $workunit_type)->get();
        return response()->json(["workunits" => $workunits]);
    }

    public function getObjective()
    {
        $objectives = Objective::all();
        return response()->json(["objectives" => $objectives]);
    }

    public function getMeetingRoom()
    {
        $mrooms = Meetingroom::where('status', 'READY')->get();
        if(count($mrooms)) {
            foreach($mrooms as $mroom){
                $mrooms_tranform[] = [
                    'id'=>$mroom->id,
                    'label'=>$mroom->fullname.' รองรับได้ ('.$mroom->capacity['min'].' - '.$mroom->capacity['max'].') คน',
                    'capacity_min'=>(int)$mroom->capacity['min'],
                    'capacity_max'=>(int)$mroom->capacity['max'],
                    'image1'=>$mroom->img_file['img1'],
                ];
            }
        } else {
            $mrooms_tranform = [];     //Not found meeting room
        }

        return response()->json(["mrooms" => $mrooms_tranform]);
    }
}
