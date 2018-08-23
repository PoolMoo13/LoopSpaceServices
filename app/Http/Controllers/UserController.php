<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTFactory;
use JWTAuth;
use App\User;

class UserController extends Controller
{
	public function login(Request $request)
	{
		// $credentials = $request->only('email', 'password');
		// $response = \App\User::login($credentials);
		// return response()->json($response)->setStatusCode($response->code);


		$validator = Validator::make($request->all(), [
			'email' => 'required|string|email|max:255',
			'password'=> 'required'
		]);
		if ($validator->fails()) {
			return response()->json($validator->errors());
		}
		$credentials = $request->only('email', 'password');
		try {
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 401);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'could_not_create_token'], 500);
		}
		return response()->json(compact('token'));
	}

	public function register(Request $request)
	{
		/*$user = $request->all();
		$response = \App\User::register($user);

		return response()->json($response)->setStatusCode($response->code);*/
		
		$validator = Validator::make($request->all(), [
			'email' => 'required|string|email|max:255|unique:users',
			'name' => 'required',
			'password'=> 'required'
		]);
		if ($validator->fails()) {
			return response()->json($validator->errors());
		}
		User::create([
			'name' => $request->get('name'),
			'email' => $request->get('email'),
			'password' => bcrypt($request->get('password')),
		]);
		$user = User::first();
		$token = JWTAuth::fromUser($user);
		
		return response()->json(compact('token'));
	}
	
	
	public function refreshtoken()
	{
			$response = \App\User::refreshToken();
			return response()->json($response)->setStatusCode($response->code);
	}
	public function logout()
	{
			$response = new \App\Response();
			$token = JWTAuth::getToken();
			if ($token) {
					$payload = JWTAuth::decode($token);
					$user = \App\User::find($payload['user']['id']);
					if($user){
							$user->push_notif_token = null;
							$user->save();
					}
					if (JWTAuth::invalidate($token)) {
							$response->code = 200;
							$response->msg = 'Logout con éxito.';
					}
			}

			return response()->json($response)->setStatusCode($response->code);
	}
}
