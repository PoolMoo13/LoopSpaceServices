<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function spaces()
	{
		return $this->hasMany('App\Space');
	}

	/**
     * Authenticates the user and return a token to secure API.
     *
     * @param array $credentials User data to confirm and evaluate.
     *
     * @return Response User token for secure.
     */
    public static function login($credentials = [])
    {
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

}
