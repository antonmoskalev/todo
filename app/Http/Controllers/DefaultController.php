<?php

namespace App\Http\Controllers;

use Auth;

class DefaultController extends Controller
{
	public function index()
	{
		if (Auth::check()) {
			return redirect()->route('todo/index');
		} else {
			return redirect()->route('user/viewSignin');
		}
	}
}