<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
	public function Index(Request $request)
	{
		if($this->CheckSession())
		{
			return redirect(url('/inicio'));
		}
		else
		{
			$isLogin = true;
			if($request->isMethod('get'))
			{
				#dd('soyget');
				$tituloPagina = 'Inicio de Sesi&oacute;n';
				return view('layout.login',get_defined_vars());
			}
			else if ($request->isMethod('post'))
			{
				if ($this->CheckLogin($request))
				{
					Session::put('usuario','wichin');
					$tituloPagina = 'Inicio';
					return redirect('/inicio');
				}
				else
				{
					$info = ['titulo'=>'ACCESO DENEGADO','msg'=>'El nombre de usuario y la contraseña que ingresaste no coinciden con nuestros registros.','class'=>'alert-danger'];
					Session::flash('mensaje',$info);

					$tituloPagina = 'Inicio de Sesi&oacute;n';
					return view('layout.login',get_defined_vars());
				}
			}
		}
	}

	public function Init()
	{
		$tituloPagina = 'Inicio';
		return view('inicio',get_defined_vars());

	}


	public function CheckSession()
	{
		if(Session::has('usuario'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function CheckLogin($request)
	{
		if($request->usuario=='wichin')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function Logout()
	{
		Session::forget('usuario');

		$tituloPagina = 'Inicio de Sesi&oacute;n';
		return redirect(url('/'));
	}

}
