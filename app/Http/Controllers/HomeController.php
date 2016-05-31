<?php

namespace App\Http\Controllers;

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

        if(Auth::user()->role == 'admin'){
            $reports =  DB::table('reports')->where('task_done', '!==', NULL)->get();
            return view::make('home-admin')->with('reports', $reports);
        }else {

            $report = Auth::user();

//            return $report->reports;


            $user_reports = DB::table('reports')
                ->where('user_id', '=', $this->user_id)
                ->whereMonth('created_at', '=', date('m'))
                ->get();
            $todays_report = DB::table('reports')
                ->where('user_id', '=', $this->user_id)
                ->wheredate('created_at', '=', Carbon::today()->toDateString())
                ->get();

            $last_report = User::find($this->user_id)->reports()->orderBy('created_at', 'desc')->first();
            $report_updated = $todays_report ? true : false;
            $user = Auth::user();
            $user->load(['teams.members.reports' => function ($query) {
                $query->wheredate('created_at', '=', Carbon::today()->toDateString());
            }])->get();

//            return $user;

            return view::make('home')
                ->with('last_report', $last_report)
                ->with('report_updated', $report_updated)
                ->with('user', $user);
        }

    }



}
