<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
//        return $user_teams;
        return view::make('profile')->with('user', $user)->with('user_teams', $user_teams)->with('teams', $teams);
    }
    
    
    
    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
        ]);
        if ($validator->fails()) {
            return redirect('profile')
                ->withErrors($validator)
                ->withInput();
        }
        User::find($this->user_id)->update(['name' => $request->name]);
        User::find($this->user_id)->teams()->sync($request->teams);
        return redirect('/profile');
    }
}
