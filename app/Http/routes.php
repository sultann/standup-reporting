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
use App\lib\Html2Text;
Route::get('/', 'HomeController@index');
Route::Post('/', 'HomeController@filteredReport');
Route::auth();

Route::get('report/create', 'ReportController@create');
Route::post('report/store', 'ReportController@store');
Route::get('report/user/{id}', 'ReportController@userReports');
Route::get('report/team/{team_id}', 'ReportController@teamReports');
Route::get('/generate-report', 'ReportController@generateTodayDocReport');
Route::get('generate-report/{date}', 'ReportController@generateCustomDocReport');

Route::get('profile', 'ProfileController@index');
Route::post('profile/update', 'ProfileController@update');


Route::get('/blocker/resolve/{id}', 'BlockerController@resolveBlocker');
Route::get('test', function(){
	$html = new Html2Text('Hello, &quot;<b>world</b>&quot;');
	return $html->getText();
}) ;


Route::get('/test', function(){
	$doc = new VsWord();
	$paragraph = new PCompositeNode();
	$paragraph->addPNodeStyle( new AlignNode(AlignNode::TYPE_RIGHT) );
	$paragraph->addText("Some more text ... More text about... Some more text ... More text about... Some more text ... More text about...");
	/**/
	echo '<pre>'.($doc->getDocument()->getBody()->look()).'</pre>';

	$doc->saveAs('align.docx');
});



