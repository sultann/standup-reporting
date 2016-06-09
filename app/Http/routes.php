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
Route::get('report/user/{id}', 'ReportController@userReports');
Route::get('report/team/{team_id}', 'ReportController@teamReports');
Route::get('generate-report', 'ReportController@generateTodayDocReport');
Route::get('generate-report/{date}', 'ReportController@generateCustomDocReport');

Route::get('profile', 'ProfileController@index');
Route::post('profile/update', 'ProfileController@update');


Route::get('/blocker/resolve/{id}', 'BlockerController@resolveBlocker');

Route::get('mail-test', function () {

    $user = \App\User::findOrFail(1);

    Mail::send('greeting', ['user' => $user], function ($m) use ($user) {
        $m->from('sultan.nasir@gagagugu.com', 'Your Application');

        $m->to('tapos.aa@gmail.com', $user->name)->subject('Your Reminder!');
    });
});


