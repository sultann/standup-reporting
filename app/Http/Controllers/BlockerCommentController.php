<?php

namespace App\Http\Controllers;

use App\BlockerComment;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class BlockerCommentController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		if (!Auth::check())  return;
	}

    public function store(Request $request){
		$comment =  $request->comment;
		$user	= Auth::user();
		$blocker_comment = new BlockerComment();
		$blocker_comment->blocker_id  =  $request->blocker_id;
		$blocker_comment->user_id  = $user->id;
		$blocker_comment->comment  = $comment;
		$blocker_comment->save();
		return redirect()->back();
	}
}
