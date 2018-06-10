<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProcesoController extends Controller
{
	private $usuario;
	public function __construct()
	{
		$this->usuario = Session::get('usuario');
	}

	public function InitCrear(Request $request)
	{
		$usuario		= $this->usuario;
		$tituloPagina 	= 'Crear Proceso';
		$titulo 		= 'CREACION';
		$subtitulo		= 'Proceso Jurídico';

		//CATALOGOS
		$catTipoProceso 	= $this->getTipoProceso();
		$catEstadoProceso	= $this->getEstadoProceso();
		$catAbogado			= $this->getPersona(2);
		$catCliente		 	= $this->getPersona(3);

		if($request->isMethod('post'))
		{
			$fecha			= $request->fecha;
			$descripcion	= $request->descripcion;
			$tipo 			= $request->tipoproceso;
			$estado         = $request->estadoproceso;
			$cliente   		= $request->cliente;
			$abogado 		= $request->abogado;
			

			$dataInsert = DB::table('proceso_legal')->insert([
				'descripcion'		=> $descripcion,
				'idTipo_Proceso'		=> $tipo,
				'idEstado_Proceso'	=> $estado,
				'idCliente'			=> $cliente,
				'idEmpleado'		=> $abogado,
				'fecha_inicio'		=> $fecha

			]);

			$response = $dataInsert?'El proceso se guardo exitosamente':'No fue posible guardar el proceso';
		}

		return view('modulos.procesos.crear',get_defined_vars());
	}

	public function getTipoProceso()
	{
		return DB::table('tipo_proceso')->get();
	}

	public function getEstadoProceso()
	{
		return DB::table('estado_proceso')->get();
	}

	public function getPersona($idTipo)
	{
		return DB::table('persona')
			->where('idtipo_persona',$idTipo)
			->get();
	}
}
