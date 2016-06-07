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
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomeController@index');
Route::auth();

Route::get('/home', 'HomeController@index');
Route::post('report/update', 'ReportController@update');
Route::post('report/{$id}/index', 'ReportController@index');
Route::get('profile', 'ProfileController@index');
Route::post('profile/update', 'ProfileController@update');
Route::get('blockers', function (){
    $teams = \App\Blocker();
    $teams->where('status', '=', 1);
    return $teams;
});
Route::get('test10', function (){
    $teams = new Report();
    $teams->where('blocker_status', '=', 1);
    return $teams;
});
Route::get('test1', function (){

//    $info = DB::select(DB::raw('SELECT user_id FROM reports WHERE date(created_at) = "2016-06-01"'));
//    $info = DB::select(DB::raw('select id, email, name from users WHERE id not in (SELECT user_id FROM reports WHERE date(created_at) = "'.Carbon::today()->toDateString().'"')
//    $info = DB::select(DB::raw('SELECT user_id FROM reports WHERE date(created_at) = "'.Carbon::today()->toDateString().'"'));
//    $mylist = [];
//    foreach ($info as $aInfo){
//        $mylist[] = $aInfo->user_id;
//    }
//  // return $info;
//    //select id, email from users WHERE id not in (SELECT user_id FROM reports WHERE date(created_at) = '2016-06-01')
//    $teams = \App\Team::all();
//    $teams->load(['members' => function($m) use ($mylist){
//        function ($query){
//            // $query->whereNotIn('id',$info);
//        }
//
//    }]);
//    return $teams;
//    foreach ($teams as $team){
//
//        foreach ($team->members as $member){
//            if(count($member->reports)>1){
//                echo $member->reports;
//            }
//        }
//
//    }

//    $user = Team::all();
//    $user->load(['members'] => function($query){
//
//        return $query;
//    });
    $users = new App\User();
    return $users->lastEmptyReport()->get();
    $users->load([
        'lastEmptyReport'  => function ($query) {
//        if(!count($query->take(1)->latest())<1){
//        var_dump($query);
            return $query->take(1);
//        }
        }
    ]);
    return $users;
//    echo  $users;
});
Route::get('test2', function (){
    $user_reports = Auth::user();
    $user_reports->role;
    return Auth::user()->role;
});

Route::get('test5', function (){
    $users = DB::table('users')
        ->leftJoin('reports', 'users.id', '=', 'reports.user_id')
//        ->where('reports.created_at', '=', Carbon::yesterday()->toDateString() )
        ->get();
//        ->lists('name', 'email');
    $users->take(1);
    return response($users);
//    echo $users;
});
Route::get('test', function() {
    $teams = \App\Team::all();
    $teams->load(['members.reports' => function ($query) {
        $query->wheredate('created_at', '=', Carbon::yesterday()->toDateString());
    }]);

    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    $header = array('size' => 16, 'bold' => true,'alignment' => 'center');
    $reportHeader = 'StandUp Report for the day of '. date('jS F, Y');
    $section->addText(htmlspecialchars($reportHeader, ENT_COMPAT, 'UTF-8'), $header);
    $lineStyle = array('weight' => 1, 'width' => 300, 'height' => 0, 'color' => 635552);
    $section->addLine($lineStyle);
    foreach ($teams as $team){
        $section->addTextBreak(3);
        $section->addText(htmlspecialchars($team->team_name, ENT_COMPAT, 'UTF-8'), $header);
        $styleTable = array('borderSize' => 1, 'borderColor' => '000', 'cellMargin' => 80, 'alignment' => 'center');
        $styleFirstRow = array('borderBottomSize' => 2, 'borderBottomColor' => '000');
        $styleCell = array('valign' => 'center','alignment' => 'center');
        $fontStyle = array('bold' => true);
        $phpWord->addTableStyle('Team Table', $styleTable, $styleFirstRow);
        $table = $section->addTable('Team Table');
        $table->addRow(900);
        $table->addCell(2700, $styleCell)->addText(htmlspecialchars('Name', ENT_COMPAT, 'UTF-8'), $fontStyle);
        $table->addCell(2700, $styleCell)->addText(htmlspecialchars('Task Done', ENT_COMPAT, 'UTF-8'), $fontStyle);
        $table->addCell(2700, $styleCell)->addText(htmlspecialchars('Blocker', ENT_COMPAT, 'UTF-8'), $fontStyle);
        foreach ($team->members as $team_member){
            $table->addRow();
            $table->addCell(2000)->addText(htmlspecialchars($team_member->name, ENT_COMPAT, 'UTF-8'));
            if(count($team_member->reports->toArray())>0){
                foreach ($team_member->reports as $report){
                    $table->addCell(2000)->addText(htmlspecialchars($report->task_done, ENT_COMPAT, 'UTF-8'));
                    $table->addCell(2000)->addText(htmlspecialchars(empty($report->blocker)?'X':$report->blocker, ENT_COMPAT, 'UTF-8'));
                }
            }else{
                $table->addCell(2000)->addText(htmlspecialchars('X', ENT_COMPAT, 'UTF-8'));
                $table->addCell(2000)->addText(htmlspecialchars('X', ENT_COMPAT, 'UTF-8'));
            }
        }
    }
//    $footer->addPreserveText('Page {PAGE} of {NUMPAGES}.');
    $parentFolder = date('Y');
    $childFolder = date('M');
    $fileName   = 'Reports-'. date('d-m-y').'.docx';
    $dirStrucre = './'.$parentFolder.'/'.$childFolder.'/';
    if(!is_dir($dirStrucre)){
        mkdir("./".$parentFolder.'/'.$childFolder,  0777, true);
    }

    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($dirStrucre.'/'.$fileName);


});

