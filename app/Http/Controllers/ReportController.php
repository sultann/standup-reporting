<?php

namespace App\Http\Controllers;

use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Stores new report in the DB
     */
    public function update(Request $request){
        // @todo have to validate the form
        $report = new Report();
        $report->user_id  = Auth::user()->id;
        $report->task_done  = $request->task_done;
        $report->blocker  = $request->blocker;
        $report->blocker_status  = 1;
        $report->can_update  = 0;
       // dd($report);
        $report->save();
        return redirect('/');
    }


    public function lastDayReport(){
        $lastDayReport = DB::table('reports')->where('user_id', Auth::user()->id)->where('create_at', Carbon::yesterday());
    }
}
