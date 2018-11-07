<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Request;
//use LRedis;
use Illuminate\Support\Facades\Log;
 
class ChatController extends Controller {
	public function __construct()
	{
		$this->middleware('guest');
	}
	public function sendMessage(Request $request){
		//$redis = LRedis::connection();
		
		$data = ['message' => Request::input('message'), 'user' => Request::input('user')];
		//$redis->publish('message', json_encode($data));
		return response()->json([]);
	}
}
