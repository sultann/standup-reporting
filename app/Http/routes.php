<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomeController@index');
Route::get('test', function () {
//    $result = App\Team::all();
    $result = App\Team::find(1)->members()->get();
    return $result;
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::post('report/update', 'ReportController@update');

Route::get('standup-robot', function (){
//
// $allUser = User::all();
//    foreach ($allUser as $user){
//        $report = new \App\Report();
//        $report->user_id = $user->id;
//        $report->task_done = NULL;
//        $report->blocker = NULL;
//        $report->blocker_status = 0;
//        $report->can_update = 1;
//        $report->save();
//    }
////    dd(Carbon::yesterday());
//    $report = DB::table('reports')
//            ->where('user_id', '=', 10)
//            ->whereDate('created_at', '=', Carbon::yesterday()->toDateString())
//            ->get();
//            return $report;

    $reports =  DB::table('reports')
        ->where('user_id', '=', 11)
        ->wheredate('created_at', '=', Carbon::today()->toDateString())
        ->get();
    return $reports;

});