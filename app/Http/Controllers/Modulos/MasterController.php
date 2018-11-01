<?php
namespace App\Http\Controllers\Modulos;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MasterController extends Controller
{
    protected $usuario;
    protected $idUsuario;

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

    public function GetCatalogo($tabla, $estado = null)
    {
        return DB::table($tabla)
            ->where(function ($sql) use($estado){
                if(isset($estado))
                    $sql->where('estado',$estado);
            })->get();
    }

    public function MsgHtml($icono, $mensaje, $clase)
    {
        return '<div class="alert alert-'.$clase.' text-center" role="alert"><h3><i class="fa '.$icono.' fa-lg"></i>&nbsp;&nbsp;'.$mensaje.'</h3></div>';
    }

    public function LabelHtml($titulo, $clase)
    {
        return '<h4 style="margin: 0; padding: 0;"><span class="label label-'.$clase.'">'.$titulo.'</span></h4>';
    }

    public function BtnHtml($accion, $tooltip, $icono)
    {
        #return '<a class="btn btn-primary "'.(isset($accion)?'onclick="'.$accion.'"':'').' '.(isset($tooltip)?'data-toggle="tooltip" data-placement="top" title="'.$tooltip.'"':'').'><i class="fa fa-'.(isset($icono)?$icono:'question').' fa-lg"></i></a>';
        return '<a '.(isset($accion)?'onclick="'.$accion.'"':'').' '.(isset($tooltip)?'data-toggle="tooltip" data-placement="top" title="'.$tooltip.'"':'').'><i class="fa fa-'.(isset($icono)?$icono:'question').' fa-2x"></i></a>';
    }

    public function RevertDate($date, $timeOut = false)
    {
        $flag = true;
        $item = explode(' ',$date);

        $dateIn     = count($item)>1 ? $date : $date.' 0:00:00';
        $condOut    = $timeOut ? 'd-m-Y H:i:s':'d-m-Y';

        try
        {
            $dateCarbon = Carbon::createFromFormat('Y-m-d H:i:s',$dateIn);
        }
        catch (\Exception $e)
        {
            $flag = false;
        }

        $dateFormat = $flag ? Carbon::parse($dateCarbon)->format($condOut) : $date;

        return $dateFormat;
    }

    public function InvertDate($date, $timeOut = false)
    {
        $flag = true;
        $item = explode(' ',$date);

        $dateIn     = count($item)>1 ? $date : $date.' 0:00:00';
        $condOut    = $timeOut ? 'Y-m-d H:i:s':'Y-m-d';

        $dateCarbon = Carbon::createFromFormat('d-m-Y H:i:s',$dateIn);

        try
        {
            $dateCarbon = Carbon::createFromFormat('d-m-Y H:i:s',$dateIn);
        }
        catch (\Exception $e)
        {
            $flag = false;
        }

        $dateFormat = $flag ? Carbon::parse($dateCarbon)->format($condOut) : $date;

        return $dateFormat;
    }
}
