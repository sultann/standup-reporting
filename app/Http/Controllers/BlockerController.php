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
    public function blockerDetails(Blocker $id){
        $blocker = load('id.user');
        return $blocker;
                        return view::make('single-blocker',
                            [
                                'blocker' => $id,
                            ]

                            );
    }
    
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
