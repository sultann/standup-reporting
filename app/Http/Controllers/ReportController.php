<?php

namespace App\Http\Controllers;

use App\Blocker;
use App\Report;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(User $id){
        $reports = $id;
//        $reportsCollection = $reports->reports()->simplePaginate(2);
//        $reports->load(['blockers' => function ($query) {
//            $query->orderBy('created_at', 'desc');
//        }]);
        $reports->load('reports','teams');
//        $reports->load();
        $reports->paginate(15);
        $reports->reports();
//         return $reportsCollection;
        return view::make('individual-person-report')
            ->with('reports', $reports);
    }

    public function teamReport(Team $id){
        $teamReport = $id;
        $teamReport->load('members.reports');
        return $teamReport;
//        return view::make('individual-team-report')
//            ->with('teamReports', $teamReport);
    }

    public function filteredReports(Request $request){
        $date = Carbon::parse($request->dateFilter);

//        $reports =  DB::table('reports')
//            ->where('created_at', '=', $date)
//            ->get();
//        $reports->load('users');

        $reports = \App\User::all();
        $reports->load(['reports' =>function ($query) use($date) {
            $query->where('created_at', '=', $date);
            $query->orderBy('created_at', 'desc');
        }]);


//            $reports->load(['reports'=> function ($query) {
//            $query->whereMonth('created_at', '=', date('m'));
//            $query->orderBy('created_at', 'desc');
//        }])->get();
        return $reports;

    }

    /**
     *  Stores new report in the DB
     */
    public function store(Request $request){
        // @todo have to validate the form

        $todaysReport = null;
        $lastDayReport= null;
        $user = User::find(Auth::user()->id);

        $todaysReport = Report::where('user_id',$user->id)->whereDate('created_at','=',Carbon::today()->toDateString())->first();
        $lastDayReport = $user->lastReport()->get();

        if($todaysReport){
            DB::table('reports')
                ->where('id', $todaysReport->id)
                ->update(['task_done' => $request->task_done]);
        }else{
            $report = new Report();
            $report->user_id  = $user->id;
            $report->task_done  = $request->task_done;
            $report->save();
        }

        if(isset($request->task_done_last_day) && !empty($request->task_done_last_day) && $lastDayReport){
            $lastDayReport = $lastDayReport[0];
            DB::table('reports')
                ->where('id', $lastDayReport->id)
                ->update(['task_done' => $request->task_done_last_day]);
        }

        if(isset($request->blocker) && !empty($request->blocker)){
                $blocker = new Blocker();
                $blocker->user_id = $user->id;
                $blocker->blocker = $request->blocker;
                $blocker->status  = 1;
                $blocker->save();
            }



        return redirect('/');
    }
    
}
