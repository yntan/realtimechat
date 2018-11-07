<?php

use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use App\Message;
use App\Events\SocketTesterEvent;

use LRedis;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
});

//Route::post('/sendmessage', 'ChatController@sendMessage');

Route::post('sendmessage', function() {
	$message = new Message();
	$token = request('_token');
	$user = request('user');
	$content = request('message');
	$message->user = $user;
	$message->content = $content;
	$message->save();

	$data = [
		'_token' => $token,
		'user' => $user,
		'message' => $content
	];

	//Log::error(json_encode($data));
	//event(new SocketTesterEvent($data));

	$redis = LRedis::connection();
	$redis->publish('message', json_encode($data));
	//return response()->json([]);
	
	return json_encode($data);
});