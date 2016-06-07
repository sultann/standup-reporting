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
use Carbon\Carbon;

Route::get('/', 'HomeController@index');
Route::Post('/', 'HomeController@filteredReport');
Route::auth();

Route::get('report/create', 'ReportController@create');
Route::post('report/store', 'ReportController@store');
Route::get('report/user/{id}', 'ReportController@index');
Route::get('report/team/{id}', 'ReportController@teamReport');
//Route::post('report/filtered-reports', 'ReportController@filteredReports');
//Route::post('report/filtered-reports', 'ReportController@filteredReports');

Route::get('profile', 'ProfileController@index');
Route::post('profile/update', 'ProfileController@update');


//Route::get('/?select-date-filter')

Route::get('test1', function (){
    $MonthlyReports = Auth::user();
    $MonthlyReports->load(['reports'=> function ($query) {
        $query->whereMonth('created_at', '=', date('m'));
        $query->orderBy('created_at', 'desc');
    }])->get();

    $MonthlyReports->load(['teams.members.reports']);
    $MonthlyReports->load(['blockers']);
    return $MonthlyReports;
});

Route::get('test2', function (){
    $blocker = new \App\Blocker();
    $blocker->all()->orderBy('created_at', 'desc');
    $blocker->load(['user']);
    return $blocker;
});
Route::get('test3', function (){
   $time = \App\User::all();
    return $time;
});

Route::get('generate-report', function() {
    $teams = \App\Team::all();
    $teams->load(['members.reports' => function ($query) {
        $query->wheredate('created_at', '=', Carbon::today()->toDateString());
    }]);
    $teams->load(['members.blockers' => function($query){
        $query->orderBy('created_at', 'desc')->take(1);
    }]);

    return $teams;

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
