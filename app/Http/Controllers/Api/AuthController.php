<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register (Request $request) {
	    $validator = Validator::make($request->all(), [
	        'name' => 'required|string|max:255',
	        'email' => 'required|string|email|max:255|unique:users',
	        'password' => 'required|string|min:6|confirmed',
	    ]);
	    if ($validator->fails())
	    {
	        return response(['status'=>'error','message'=>'Failed to create user','errors'=>$validator->errors()->all()], 422);
	    }
	    $request['password']=Hash::make($request['password']);
	    $request['remember_token'] = Str::random(10);
	    $user = User::create($request->toArray());
	    $token = $user->createToken('Register User')->accessToken;
	    $response = ['status'=> 'success', 'message'=> 'success to create user', 'token' => $token, 'token_type' => 'Bearer'];
	    return response($response, 200);
	}

	public function login (Request $request) {
	    $validator = Validator::make($request->all(), [
	        'email' => 'required|string|email|max:255',
	        'password' => 'required|string|min:6|confirmed',
	    ]);
	    if ($validator->fails())
	    {
	        return response(['status'=>'error','message'=>'Failed to login user','errors'=>$validator->errors()->all()], 422);
	    }
	    $user = User::where('email', $request->email)->first();
	    if ($user) {
	        if (Hash::check($request->password, $user->password)) {
	            $token = $user->createToken('Login User')->accessToken;
	            $response = ['status'=> 'success', 'message'=> 'success to login user','token' => $token, 'token_type' => 'Bearer'];
	            return response($response, 200);
	        } else {
	            $response = ['status'=>'error',"message" => "Password mismatch",'errors'=>[]];
	            return response($response, 422);
	        }
	    } else {
	        $response = ['status'=>'error',"message" =>'User does not exist','errors'=>[]];
	        return response($response, 422);
	    }
	}

	public function logout (Request $request) {
    	$token = $request->user()->token();
	    if ($token->revoke()) {
	    	$response = [
                'message' => 'You have been successfully logged out!',
                'status' => 'success'
            ];
	    	return response($response, 200);
	    } else {
	    	$response = [
                'message' => 'You have not been successfully logged out!',
                'status' => 'failed'
            ];
	    	return response($response, 422);
	    }
    }
}
