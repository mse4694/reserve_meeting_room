<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        if(count($events)) {
            foreach($events as $event){
                    $color = "#0c6496";
                if($event->status === 1) {
                    $color = "#549150";
                } elseif ( $event->status === 2) {
                    $color = '#b31225';
                }
                $events_tranform[] = [
                    'id'=>$event->id,
                    'objective_id'=>$event->objective,
                    'title'=>$event->title,
                    'detail'=>$event->detail,
                    'start'=>$event->start,
                    'end'=>$event->end,
                    'prepare'=>$event->prepare,
                    'resourceId'=>$event->resourceId,
                    'attendees'=>$event->attendees,
                    'responsible_person'=>$event->responsible_person,
                    'coordinator'=>$event->coordinator,
                    'workunit_id'=>$event->workunit,
                    'tel'=>$event->tel,
                    'equipment'=>$event->equipment,
                    'food_drink'=>$event->food_drink,
                    'color'=>$color
                    //'color'=>'#e6e8dc',
                    // 'textColor'=>$color,
                    // 'borderColor'=>$color,
                    // 'backgroudColor'=>$color
                ];
            }
        } else {
            $events_tranform = [];     //Not found meeting room
        }
        
        return response()->json(["events" => $events_tranform]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('BookingRoom');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
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
        return Inertia::render('EventDisplay', ['eventDetail' => $id]);
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
