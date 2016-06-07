<?php

namespace App\Http\Controllers;

use App\Blocker;
use App\Http\Requests;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user_id;
    public function __construct()
    {
        $this->middleware('auth');
        if (Auth::check())
        {
            $this->user_id = Auth::user()->id;
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->generateReport(Carbon::today());
    }

    public function filteredReport(Request $request){
        $date = Carbon::parse($request->dateFilter);
        return $this->generateReport($date);
    }

    public function generateReport($date){

        if(Auth::user()->role == 'admin'){
            $teams = Team::all();
            $teams->load(['members.reports' => function ($query) use($date) {
                $query->wheredate('created_at', '=', $date);
            }]);
//            $teams->load('blockers');

            $lateParties = new User();
            $lateParties = $lateParties->lastEmptyReport()->get();
            $blockers = Blocker::all();
            $blockers->load(['user']);

//            return $blockers;
            return view::make('homeAdmin')
                ->with('teams', $teams)
                ->with('blockers', $blockers)
                ->with('date', $date)
                ->with('late_parties', $lateParties);
        }else {

            /*Generates running months reports*/
            $userReports = Auth::user();
            $userReports->load(['reports'=> function ($query) {
                $query->whereMonth('created_at', '=', date('m'));
                $query->orderBy('created_at', 'desc');
            }])->get();

            $userReports->load(['teams.members.reports']);
            $userReports->load(['blockers']);

            $todayReport = null;$lastDayTask = null;
            foreach ($userReports->reports as $key=>$report){

                if($report->created_at->toDateString()== Carbon::today()->toDateString()){
                    $todayReport = $report;
                }
            }

            if(count($userReports->reports)>1){
                $lastDayTask =  $userReports->reports[count($userReports->reports)-1];
            }

            return view::make('home')
                ->with('TodaysReport', $todayReport)
                ->with('yesterday', $lastDayTask)
                ->with('user_reports', $userReports);
        }
    }



}
