<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use App\Models\Objective;


class ObjectiveController extends Controller
{
    public function index()
    {
        $objectives = Objective::all();
        return Inertia::render('Admin/Objective', ['objectives' => $objectives]);
    }

    public function store()
    {
        $objective_name = Request::input('objective_name');
        
        $objective_detail = Request::input('objective_detail');
        if( strcmp($objective_detail,'') === 0 ) {
            $objective_detail = "ยังไม่เคยบันทึกรายละเอียดเกี่ยวกับวัตถุประสงค์การใช้ห้องประชุมนี้";
        }

        $userin = Request::input('userin');
        $user_last_act = Request::input('user_last_act');

        try {
            Objective::create([ 'objective_name'=>$objective_name,
                                'objective_detail'=>$objective_detail,
                                'userin'=>$userin,
                                'user_last_act'=>$user_last_act
                             ]);
        } catch(\Exception  $e) {
            \Log::info($e->getMessage());
            return Redirect::back()->withErrors(['msg' => 'fail', 'sysmsg' => $e->getMessage()]);
        }

        return Redirect::route('manage_objective');
    }

    public function update($id)
    {
        // \Log::info(Request::all());
        // \Log::info($id);

        $objective_name = Request::input('objective_name');

        $objective_detail = Request::input('objective_detail');
        if( strcmp($objective_detail,'') === 0 ) {
            $objective_detail = "ยังไม่เคยบันทึกรายละเอียดเกี่ยวกับวัตถุประสงค์การใช้ห้องประชุมนี้";
        }

        $user_last_act = Request::input('user_last_act');

        //return Redirect::back()->withErrors(['msg' => 'fail', 'sysmsg' => 'Error']);
        //return Redirect::back()->withErrors(['msg' => 'fail', 'sysmsg' => $e->getMessage()]);
        //return Redirect::route('manage_objective');

        try {
            Objective::whereId((int)$id)
                        ->update([
                            'objective_name'=>$objective_name,
                            'objective_detail'=>$objective_detail,
                            'user_last_act'=>$user_last_act 
                        ]);
        } catch(\Exception  $e) {
            \Log::info($e->getMessage());
            return Redirect::back()->withErrors(['msg' => 'fail', 'sysmsg' => $e->getMessage()]);
        }

        return Redirect::route('manage_objective');
    }
}
