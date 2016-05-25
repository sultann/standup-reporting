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

Route::get('/', 'HomeController@index');
Route::get('test', function () {
//    $result = App\Team::all();
    $result = App\Team::find(1)->members()->get();
    return $result;
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::post('report/update', 'ReportController@update');