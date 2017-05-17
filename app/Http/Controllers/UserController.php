<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class UserController extends Controller
{
	public function viewSignup()
	{
		return view('user.signup');
	}
	
	public function viewSignin()
	{
		return view('user.signin');
	}
	
	public function signup(Request $request, HasherContract $hasher)
	{
		$input = $request->only('email', 'password', 'same_password');
		$rules = [
			'email' => ['required', 'email', 'unique:users', 'max:255'],
			'password' => ['required', 'same:same_password'],
			'same_password' => ['required'],
		];
		$validator = Validator::make($input, $rules);
		
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}
		
		$user = new User();
		$user->email = $input['email'];
		$user->password_hash = $hasher->make($input['password']);
		$user->confirmed = true;// TODO: на продакшн сделать подтверждение
		$user->save();
		
		return response()->json([
			'redirect' => route('user/viewSignin'),
		]);
	}
	
	public function signin(Request $request)
	{
		$input = $request->only('email', 'password', 'remember');
		$rules = [
			'email' => ['required', 'email'],
			'password' => 'required',
			'remember' => ['required', 'boolean'],
		];
		$validator = Validator::make($input, $rules);
		
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}
		
		$credentials = [
			'email' => $input['email'],
			'password' => $input['password'],
		];
		$remember = (boolean)$input['remember'];
		
		if (Auth::attempt($credentials, $remember)) {
			return response()->json([
				'redirect' => route('todo/index'),
			]);
		} else {
			return response()->json([], 400);
		}
	}
	
	public function logout()
	{
		Auth::logout();
		
		return redirect()->route('user/viewSignin');
	}
	
	public function uniqueEmail(Request $request)
	{
		return response()->json(!User::where('email', $request->input('email'))->exists());
	}
}