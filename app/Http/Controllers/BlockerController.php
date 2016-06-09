<?php

namespace App\Http\Controllers;

use App\Blocker;
use App\Report;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class BlockerController extends Controller
{
    
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
