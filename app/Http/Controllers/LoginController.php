<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	public function Index(Request $request)
	{
		return view('layout.login',get_defined_vars());
	}
}
