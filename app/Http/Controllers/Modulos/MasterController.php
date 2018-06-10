<?php
namespace App\Http\Controllers\Modulos;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
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

    public function MsgHtml($icono, $mensaje, $clase)
    {
        return '<div class="alert alert-'.$clase.' text-center" role="alert"><h3><i class="fa '.$icono.' fa-lg"></i>&nbsp;&nbsp;'.$mensaje.'</h3></div>';
    }
}
