<?php namespace App\Http\Controllers\Modulos\Elecciones;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VotacionController extends Controller {

	private $usuario;
	private $idUsuario;

    /**
     * Constructor de la clase
     * WII 10-2017
     * VotacionController constructor.
     */
    public function __construct()
    {
        $this->usuario   = Session::get('usuario');
        $this->idUsuario = $this->usuario['id'];
    }

    /**
     * GET: Obtiene el listado de canditatos de elección activa
     * POST: Almacena votación
     * WII 10-2017
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function InitVotacionDiaconos(Request $request)
    {
        $usuario      = $this->usuario;
        $tituloPagina = 'Elecci&oacute;n Di&aacute;conos';
        $titulo       = 'Elecciones';
        $subtitulo    = 'Diaconos 2017';

        if($request->isMethod('POST'))
        {
            $response = $this->SetVotosDiaconos($request);

            if($response)
            {
                $info = ['titulo'=>'EXITO','msg'=>'La votación fue registrada','class'=>'success'];
                Session::flash('mensaje',$info);
            }
            else
            {
                $info = ['titulo'=>'ERROR','msg'=>'No fue posible registrar la votación','class'=>'warning'];
                Session::flash('mensaje',$info);
            }

            return redirect(url('/elecciones/votacion/diaconos'));
        }

        #ORGANIZACION DIACONOS ID->2
        $query = DB::table('tb_eleccion as el')->where('el.id_organizacion',2)->where('el.id_estado',1)
            ->join('tb_planilla as pl','pl.id_eleccion','=','el.id')
            ->join('tb_candidato as c','c.id_planilla','=','pl.id')
            ->join('tb_persona as p','p.id','=','c.id_persona')
            ->select('c.id as id_candidato','p.nombre','p.apellido','p.url_foto','el.id as id_eleccion')
            ->orderBy('p.apellido','asc')
            ->orderBy('p.nombre','asc')
            ->get();

        #dd($query);

        if(isset($query)&&count($query)>0)
        {
            $idEleccion = $query[0]->id_eleccion;
            $diaconos = collect($query)->chunk(3);
        }
        else
            $diaconos = [];

        return view('modulos.elecciones.diaconos.votacion',get_defined_vars());

    }

    /**
     * Transaccion que almacena votación de 7 candidatos, registra usuario que realiza la transacción.
     * WII 10-2017
     * @param $data
     * @return bool
     */
    public function SetVotosDiaconos($data)
    {
        $dataCandidato  = explode('|',$data->data);
        $idEleccion     = $data->elec;

        DB::beginTransaction();

        try
        {
            $insertBitacora = DB::table('bit_elecciones')->insert([
                'id_usuario'    => $this->idUsuario,
                'id_eleccion'   => $idEleccion
            ]);
        }
        catch (\Exception $e)
        {
            $insertBitacora = false;
        }

        if($insertBitacora)
        {
            $resultadoVotos = [];
            $i = 0;
            foreach ($dataCandidato as $dt)
            {
                if(isset($dt)&&$dt!='')
                {
                    $updateVoto = DB::table('tb_candidato')->where('id',$dt)
                        ->increment('votos');

                    $resultadoVotos[$i] = $updateVoto?1:0;
                    $i++;
                }
            }

            if(!in_array(0,$resultadoVotos))
            {
                DB::commit();
                return true;
            }
            else
            {
                DB::rollback();
                return false;
            }
        }
        else
        {
            DB::rollback();
            return false;
        }
    }

    public function InitTest(Request $request)
    {
        $usuario      = $this->usuario;
        $tituloPagina = 'Test';
        $titulo       = 'Módulo';
        $subtitulo    = 'de Pruebas';

        $query      = $this->ArrayTest();
        $candidatos = collect($query)->chunk(3);

        if($request->isMethod('POST'))
        {
            sleep(2);
            $data       = $request->data;
            $eleciones  = explode(':',$data);

            $presi  = explode('|',$eleciones[0]);
            $money  = explode('|',$eleciones[1]);
            $secre  = explode('|',$eleciones[2]);
            $vocal  = explode('|',$eleciones[3]);

            $info = ['titulo'=>'PROCESO EXITOSO','msg'=>'La votación fue completada con éxito.','class'=>'success'];
            Session::flash('mensaje',$info);
            return redirect(url('/elecciones/votacion/test'));
        }

        return view('modulos.elecciones.test',get_defined_vars());
    }

    public function ArrayTest()
    {
        $data = [];

        for($i=0; $i<8; $i++)
        {
            $objeto = ['idCandidato'=>($i+1),'nombre'=>'Candidato '.($i+1),'apellido'=>'Apellidos','foto'=>''];
            $data[$i] = (object)$objeto;
        }

        return $data;
    }

    public function QueryEleccion($idOrganizacion,$idTipoEleccion)
    {
        return DB::table('e_eleccion as e')
            ->join('organizacion as o','o.id','=','e.id_organizacion')
            ->join('e_tipo_eleccion as te','te.id','=','e.id_tipo_eleccion')
            ->join('e_candidato as c','c.id_eleccion','=','e.id')
            ->join('persona as p','p.id','=','c.id_persona')
            ->where('te.id',$idTipoEleccion)
            ->where('o.id',$idOrganizacion)
            ->where('e.estado',1)
            ->where('c.estado',1)
            ->select('e.id as idEleccion','c.id as idCandidato','p.nombre','p.apellido','p.url_foto as foto')
            ->orderBy('p.apellido','asc')
            ->orderBy('p.nombre','asc')
            ->get();
    }
}
