<?php

namespace App\Http\Controllers;

use App\Blocker;
use App\Report;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BlockerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
          $blockers = Blocker::with('user')
              ->orderBy('created_at', 'desc')
              ->where('status', 1)
              ->paginate(20);
        return View::make('blocker')->with([
            'blockers' =>   $blockers
        ]);
        return $blockers;
    }


	/**
     * Returns single blocker's contents and comments
	 * @param Blocker $id
     * @return mixed
     */
    public function blockerDetails(Blocker $id){
        $blocker = $id;
        $blocker->load(['user','comment.user'])->get();
        return view::make('single-blocker', [
            'blocker' => $blocker,
            'user'  =>  $blocker->user,
            'comments'    => $blocker->comment,
        ]);
//        return 'worked';
    }

	/**
     * Marks the blocker as resolve
     * @param Blocker $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resolveBlocker(Blocker $id){
        $blocker = $id;
        $blocker_user_id = $blocker->user()->first()->id;
         if(Auth::user()->role == 'admin' ||  Auth::user()->id == $blocker_user_id){

             $id->status = 0;
             $id->update();
             return redirect()->back();
         }
    }
}
