<?php namespace App\Http\Controllers\Modulos\Elecciones;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EstadisticaController extends Controller
{

    private $usuario;
    private $idUsuario;

    public function __construct()
    {
        $this->usuario = Session::get('usuario');
        $this->idUsuario = $this->usuario['id'];
    }

    public function InitResultadosDiaconos(Request $request)
    {
        $usuario = $this->usuario;
        $tituloPagina = 'Resultados Di&aacute;conos';
        $titulo = 'Resultados';
        $subtitulo = 'Diaconos';

        $resultado = $this->ObtenerTotalesDiaconos();
        $collTotal = collect($resultado)->sum('votos');
        $top5 = $this->ObtenerTop5Diaconos($resultado);
        $top5txt = json_encode($top5);

        $tablaTotales = $this->ObtenerTabla($resultado);

        return view('modulos.elecciones.diaconos.resultadoDiaconos', get_defined_vars());
    }

    public function ObtenerTotalesDiaconos()
    {
        return DB::table('tb_eleccion as el')->where('el.id_organizacion',2)
            ->join('tb_planilla as pl','pl.id_eleccion','=','el.id')
            ->join('tb_candidato as c','c.id_planilla','=','pl.id')
            ->join('tb_persona as p','p.id','=','c.id_persona')
            ->select('p.nombre','p.apellido','c.votos')
            ->orderBy('c.votos','desc')
            ->get();

        /*return DB::table('e_eleccion as e')
            ->join('e_candidato as c', 'c.id_eleccion', '=', 'e.id')
            ->join('persona as p', 'p.id', '=', 'c.id_persona')
            ->where('e.estado', 1)
            ->where('c.estado', 1)
            ->select('p.nombre', 'p.apellido', 'c.votos')
            ->orderBy('c.votos', 'desc')
            ->get();*/
    }

    public function ObtenerTop5Diaconos($data)
    {
        $color = ["#19B899", "#0D8ECF", "#0D52D1", "#2A0CD0", "#8A0CCF"];
        $result = [];
        if (isset($data) && count($data) > 0) {
            foreach ($data as $i => $item) {
                $result[$i]['nombre'] = $item->nombre . ' ' . $item->apellido;
                $result[$i]['votos'] = $item->votos;
                $result[$i]['color'] = $color[$i];

                if ($i > 3)
                    break;
            }
        }

        return $result;
    }

    public function ObtenerTabla($data)
    {
        $html = '<table class="table table-striped">';
        $html.= '<thead><tr>';
        $html.= '<th>No</th>';
        $html.= '<th>Candidato</th>';
        $html.= '<th>Votos</th>';
        $html.= '</tr></thead>';
        $html.= '<tbody>';
        foreach ($data as $i => $item)
        {
            $html.= '<tr>';
            $html.= '<td>'.($i+1).'</td>';
            $html.= '<td>'.$item->nombre . ' ' . $item->apellido.'</td>';
            $html.= '<td>'.$item->votos.'</td>';
            $html.= '</tr>';
        }
        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    public function InitRealTime(Request $request)
    {
        $resultado = $this->ObtenerTotalesDiaconos();
        $top5      = $this->ObtenerTop5Diaconos($resultado);
        $tabla     = $this->ObtenerTabla($resultado);
        $collTotal = collect($resultado)->sum('votos');

        return json_encode(['grafica'=>$top5,'tabla'=>$tabla,'total'=>$collTotal]);
    }

    public function InitResumenDiaconos(Request $request)
    {
        $usuario = $this->usuario;
        $tituloPagina = 'Resumen Di&aacute;conos';
        $titulo = 'Resumen';
        $subtitulo = 'Diaconos';

        $dataDigitadores = $this->ObtenerConteoDigitadores();
        $collTotal = collect($dataDigitadores)->sum('conteo');

        return view('modulos.estadisticas.resumenDiaconos', get_defined_vars());
    }

    public function ObtenerConteoDigitadores()
    {
        return DB::table('bit_elecciones as b')
            ->join('tb_eleccion as e','e.id','=','b.id_eleccion')
            ->join('tb_usuario as u','u.id','=','b.id_usuario')
            ->join('tb_persona as p','p.id','=','u.id_persona')
            ->where('e.id_estado',1)
            ->select('u.id','p.nombre','p.apellido',DB::raw('count(*) as conteo'))
            ->groupBy('u.id','p.nombre','p.apellido')
            ->get();
    }

}
