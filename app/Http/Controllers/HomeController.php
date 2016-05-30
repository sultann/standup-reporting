<?php

namespace App\Http\Controllers;

use App\Http\Requests;
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
        }else{
            $reports =  DB::table('reports')
                ->where('user_id', '=', $this->user_id)
                ->whereMonth('created_at', '=', date('m'))
                ->get();
            return view::make('home')->with('reports', $reports)->with('today', $this->todayDayReport())->with('lastDay', $this->lastDayReport());
        }

    }


    public function lastDayReport(){
        $report = DB::table('reports')
            ->where('user_id', '=', $this->user_id)
            ->whereDate('created_at', '=', Carbon::yesterday()->toDateString())
            ->get();
        return $report;
    }

    public function todayDayReport(){
        $report = DB::table('reports')
            ->where('user_id', '=', $this->user_id)
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->get();
        return $report;
    }


}
