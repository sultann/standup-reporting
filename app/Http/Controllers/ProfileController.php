<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
class ProfileController extends Controller
{
    protected $user_id;
    public function __construct()
    {
        $this->middleware('auth');
        if (Auth::check())
        {
            $this->user_id = Auth::user()->id;
        }
    }

    public function index(){
        $teams = Team::all();
        $user = \Auth::user();
        $user->load('teams');
        $user_teams = $user->load('teams')->teams()->get()->lists('id')->toArray();
        return view::make('profile')->with('user', $user)->with('user_teams', $user_teams)->with('teams', $teams);
    }
    
    
    
    public function update(Request $request){
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
        ]);
        if ($validator->fails()) {
            return redirect('profile')
                ->withErrors($validator)
                ->withInput();
        }
        if($request->hasFile('avatar')) {
            $file = Input::file('avatar');
            $name = $file->getClientOriginalName();
            $file->move(public_path().'/images/', $name);
            User::find($this->user_id)->update(['avatar_url' => '/images/'.$name]);

        }

        User::find($this->user_id)->update(['name' => $request->name]);


        User::find($this->user_id)->teams()->sync($request->teams);
//        return   User::find($this->user_id);
        return Redirect::to('/profile')->with('message', 'Your profile has been updated');
    }



    public function update_user(Request $request){
        if ( !in_array(Auth::user()->role , array('admin','teamlead'), true ) )  return redirect('/login');
        $user  = User::findOrFail($request->user);
        $user->update(['role' =>$request->role]);
        if(isset($request->user_delete) && ($request->user_delete == 'on')){
            $reports =  $user->reports()->get()->pluck('id');
            DB::table('reports')->whereIn('id', $reports)->delete();

            $blockers =  $user->blockers()->get()->pluck('id');
            DB::table('blockers')->whereIn('id', $blockers)->delete();

            $blocker_comments =  $user->blocker_comments()->get()->pluck('id');
            DB::table('blocker_comments')->whereIn('id', $blocker_comments)->delete();

            $user->delete();

        }
        return Redirect::to('/')->with('message', 'Your profile has been updated');
    }
}


