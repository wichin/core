<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
				$tituloPagina = 'Inicio de Sesi&oacute;n';
				return view('layout.login',get_defined_vars());
			}
			else if ($request->isMethod('post'))
			{
				if ($this->CheckLogin($request))
				{
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
		$usuario = Session::get('usuario');

		$tituloPagina = 'Inicio';
		return view('inicio',get_defined_vars());
	}


	public function CheckSession()
	{
		if(Session::has('usuario'))
		{
		    $temp = Session::get('usuario');
		    $temp['menus'] = $this->getMenus($temp['id']);
            Session::put('usuario',$temp);

			return true;
		}
		else
		{
			return false;
		}
	}

	public function CheckLogin($request)
	{
		$usuario = $request->usuario;
		$clave   = md5($request->clave);

		$query = DB::table('tb_persona as p')
			->join('tb_usuario as u', 'u.id_persona', '=', 'p.id')
			->where('u.email',$usuario)
			->where('u.password',$clave)
			->where('u.estado',1)
            ->select('u.id as idu','u.email as email','p.nombre as nombre','p.url_foto as foto')
			->get();
		#dd($query);
		if(isset($query) && count($query) > 0 && isset($query[0]->idu))
		{
			$menus = $this->getMenus($query[0]->idu);
			$data = ['nombres'=>$query[0]->nombre,'id'=>$query[0]->idu, 'email'=>$query[0]->email, 'menus'=>$menus, 'foto'=>$query[0]->foto];
			Session::put('usuario',$data);
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getMenus($usuario)
	{
	    $data = DB::table('tb_usuario as u')
            ->join('tb_acceso as acc','acc.id_usuario','=','u.id')
            ->join('tb_aplicacion as ap','ap.id','=','acc.id_aplicacion')
            ->join('tb_menu as me','me.id','=','ap.id_menu')
            ->join('tb_modulo as mo','mo.id','=','me.id_modulo')
            ->select('mo.id as id_mod','mo.nombre as nom_mod','mo.icono as icono','me.id as id_men','me.nombre as nom_men','ap.id as id_app','ap.nombre as nom_app','ap.url as url')
            ->where('u.estado',1)->where('acc.estado',1)->where('ap.estado',1)->where('me.estado',1)->where('mo.estado',1)
            ->where('u.id',$usuario)
            ->orderBy('mo.id')->orderBy('me.id')->orderBy('ap.id')
            ->get();

		if(isset($data) && count($data)>0)
		{
			$miCollect 	= collect($data);
			return json_decode($miCollect->groupBy('id_mod'));
		}
		else
		{
			return [];
		}
	}
	
	public function Logout()
	{
		Session::forget('usuario');

		$tituloPagina = 'Inicio de Sesi&oacute;n';
		return redirect(url('/'));
	}

}
